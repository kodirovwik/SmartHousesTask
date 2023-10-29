<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;

    public function getFullName(): string
    {
        return $this->second_name.' '.$this->first_name.' '.$this->middle_name;
    }

    public function loginSource(): HasMany
    {
        return $this->hasMany(LoginSource::class);
    }
}
