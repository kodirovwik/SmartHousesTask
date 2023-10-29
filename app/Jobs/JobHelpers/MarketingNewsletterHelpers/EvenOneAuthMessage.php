<?php

namespace App\Jobs\JobHelpers\MarketingNewsletterHelpers;

use App\Jobs\JobHelpers\JobHelpersInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class EvenOneAuthMessage implements MessageInterface, JobHelpersInterface
{
    /**
     * Сообщение сообщений для пользователей у которых есть хотя бы одна авторизация
     */

    private const MESSAGE_TEMPLATE = 'Здравствуйте, %s, Вы давно не появлялись на сервисе, узнайте последние новости по ссылке: https://google.ru';

    public function getScheduleTime(): string
    {
        return '20 17 * * *';
    }

    public function getMessage(User $user): string
    {
        return sprintf(self::MESSAGE_TEMPLATE, $user->getFullName());
    }

    public function getUsers(): Collection
    {
        return User::query()
            ->whereHas('loginSource')
            ->get();
    }
}
