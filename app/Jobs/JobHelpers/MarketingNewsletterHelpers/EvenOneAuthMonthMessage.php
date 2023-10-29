<?php

namespace App\Jobs\JobHelpers\MarketingNewsletterHelpers;

use App\Jobs\JobHelpers\JobHelpersInterface;
use App\Models\Action;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class EvenOneAuthMonthMessage implements MessageInterface, JobHelpersInterface
{
    /**
     * Сообщение для пользователей у которых есть хотя бы одна авторизация за послединй
     * месяц. И не было авторизаций в период действия Акции.
     */

    private const MESSAGE_TEMPLATE = 'Здравствуйте, %s, Вы выбраны для участия в акции %s. Успейте до %s принять участие.';

    // Идентификатор акции в промежуток действия которой, не должно быть авторизаций пользователя.
    // Эта же акция будет использована в шаблоне сообщения
    private const ACTION_ID = 1;

    private Action $action;

    public function __construct()
    {
        $this->action = Action::query()->find(self::ACTION_ID);
    }

    public function getScheduleTime(): string
    {
        return '0 15 * * *';
    }

    public function getMessage(User $user): string
    {
        return sprintf(self::MESSAGE_TEMPLATE,
            $user->getFullName(),
            $this->action->title,
            $this->action->date_end
        );
    }

    public function getUsers(): Collection
    {
        return User::query()
            ->whereHas('loginSource', function (Builder $builder) {
                $builder->whereBetween('tms', [
                    Carbon::now()->startOfMonth()->subMonth()->toDateTimeString(),
                    Carbon::now()->startOfMonth()->toDateTimeString()
                ]);
                $builder->whereNotBetween('tms', [
                    $this->action->date_start . ' 00:00:00',
                    $this->action->date_end . ' 23:59:59'
                ]);
            })
            ->get();
    }
}
