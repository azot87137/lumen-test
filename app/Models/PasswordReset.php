<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    /**
     * @var string
     */
    protected $table = 'password_resets';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'token'];
}
