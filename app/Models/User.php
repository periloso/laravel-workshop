<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Event handlers
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($user) {
            \Log::info('Saving user: ' . $user);
            /// Password autohashing
            if ($user->isDirty('password')) {
                $user->password = \Hash::make($user->password);
            }
        });

        static::saved(function ($user) {
            \Log::info('User saved: ' . $user);
        });
    }
}
