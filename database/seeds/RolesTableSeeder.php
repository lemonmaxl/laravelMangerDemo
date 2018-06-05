<?php

use Illuminate\Database\Seeder;
use App\Model\Role;
use App\Model\Permission;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 超级管理员
        
		$admin = new Role();
		$admin->name         = 'admin';
		$admin->display_name = '超级管理员'; // optional
		$admin->description  = 'User is allowed to manage and edit other users'; // optional
		$admin->save();

		// 普通管理员
		$owner = new Role();
		$owner->name         = 'user';
		$owner->display_name = '普通管理员'; // optional
		$owner->description  = 'User is the owner of a given project'; // optional
		$owner->save();

		// 获取所有的权限id 数组
		$allPermissions = array_column( Permission::all()->toArray() , 'id' );
		// 同步赋予超级管理员所有的权限
		$admin->perms()->sync($allPermissions);

		// 赋予普通管理员创建用户的权限
		$createUser = Permission::where('display_name' , '创建用户')->first();
		$owner->attachPermission($createUser);
		
    }
}
