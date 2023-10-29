<?php

namespace App\Jobs\JobHelpers\MarketingNewsletterHelpers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface MessageInterface
{
    public function getMessage(User $user): string;
    public function getUsers(): Collection;
}
