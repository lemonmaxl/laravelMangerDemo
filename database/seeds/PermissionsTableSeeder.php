<?php

use Illuminate\Database\Seeder;
use App\Model\Permission;
class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permission = new Permission;
        $permission->name = 'create user';
        $permission->display_name = '创建用户';
        $permission->description = '创建用户';
        $permission->save();

        $permission = new Permission;
        $permission->name = 'edit user';
        $permission->display_name = '编辑用户';
        $permission->description = '编辑用户';
        $permission->save();

        $permission = new Permission;
        $permission->name = 'delete user';
        $permission->display_name = '删除用户';
        $permission->description = '删除用户';
        $permission->save();

        $permission = new Permission;
        $permission->name = 'ban user';
        $permission->display_name = '禁用用户';
        $permission->description = '禁用用户';
        $permission->save();

        $permission = new Permission;
        $permission->name = 'login backed';
        $permission->display_name = '登录后台';
        $permission->description = '登录后台';
        $permission->save();
    }
}
