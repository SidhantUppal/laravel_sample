<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;

class User extends Authenticatable
{
    use Notifiable, Sortable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'image',
        'signup_stage',
        'height_type',
        'weight_type',
        'goal_weight_type',
        'social_login',
        'facebook_login_id'
    ];

    /**
     * The attributes that should be sorted for arrays.
     * @var array
     */
    public $sortable = [
        'first_name', 'last_name', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that can be encrypt.
     * @var array
     */
    protected $encryptables = [
        'id',
    ];

  
}
