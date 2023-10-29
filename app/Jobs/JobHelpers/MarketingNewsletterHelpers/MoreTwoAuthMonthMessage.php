<?php

namespace App\Jobs\JobHelpers\MarketingNewsletterHelpers;

use App\Jobs\JobHelpers\JobHelpersInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class MoreTwoAuthMonthMessage implements MessageInterface, JobHelpersInterface
{
    /**
     * Сообщение для пользователей у которых больше двух авторизаций за
     * последний месяц
     */

    private const MESSAGE_TEMPLATE = 'Здравствуйте, %s, у нас для вас акция, подробности можно узнать по ссылке: https://google.ru';

    public function getScheduleTime(): string
    {
        return '46 16 * * *';
    }

    public function getMessage(User $user): string
    {
        return sprintf(self::MESSAGE_TEMPLATE, $user->getFullName());
    }

    public function getUsers(): Collection
    {
        return User::query()
            ->whereHas('loginSource', function (Builder $builder) {
                $builder->where('tms', '>=', Carbon::now()->subMonth()->toDateTimeString());
            }, '>', 2)
            ->get();
    }
}
