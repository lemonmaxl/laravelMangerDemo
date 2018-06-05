<?php

namespace App\Model;

use Zizaco\Entrust\EntrustRole;
class Role extends EntrustRole
{
    
    protected $fillable = [
        'name', 'display_name', 'description' ,'status',
    ];
    /**
     * 获得此角色对应的多个用户。
     */
    // public function users()
    // {
    //     return $this->belongsToMany('App\Model\Admin' , 'role_admin');
    // }

    /**
     * 获得此角色对应的多个权限。
     */
    // public function permis()
    // {
    //     return $this->belongsToMany('App\Model\Permission');
    // }
}
