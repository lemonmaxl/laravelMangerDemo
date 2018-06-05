<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Zizaco\Entrust\Traits\EntrustUserTrait;
class Admin extends User
{
    //
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username','email', 'password', 'status',
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
     * 获得此用户的角色。
     */
    // public function roles()
    // {
    //     return $this->belongsToMany('App\Model\Role' , 'role_admin');
    // }
}
