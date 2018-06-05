<?php

namespace App\Model;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $fillable = [
        'name', 'display_name', 'description' ,'status',
    ];

    /**
     * 获得权限的多角色。
     */
    // public function roles()
    // {
    //     return $this->belongsToMany('App\Model\Role');
    // }
}
