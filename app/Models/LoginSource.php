<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LoginSource extends Model
{
    use HasFactory;

    protected $table = 'login_source';

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
