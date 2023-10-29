<?php

namespace App\Jobs\JobHelpers\MarketingNewsletterHelpers;

class MessagesList
{
    public static function list(): array
    {
        return [
            EvenOneAuthMessage::class,
            EvenOneAuthMonthMessage::class,
            MoreTwoAuthMonthMessage::class,
        ];
    }
}
