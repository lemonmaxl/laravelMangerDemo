<?php

use Illuminate\Database\Seeder;
use App\Model\Role;
class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //创建初始用户数据
        // DB::table('amdins')->insert([
        //     'name' => str_random(10),
        //     'email' => str_random(10).'@gmail.com',
        //     'password' => bcrypt('secret'),
        // ]);
        
        // 获取角色信息
        $adminRole = Role::where('name' , 'admin')->first();
        $userRole = Role::where('name' , 'user')->first();

        // 使用模型工厂填充数据
        $admin = factory('App\Model\Admin')->create([
        		'name' => 'lemon',
        		'email' => 'lemon@163.com',
        		'password' => bcrypt('5071024'),
        	])->each(function($u) use ($adminRole)
            {
                $u->attachRole($adminRole);
            });
        $users = factory('App\Model\Admin', 3)->create([
        		'password' => bcrypt('123456')
        	])->each(function($u) use ($userRole)
            {
                $u->roles()->attach($userRole->id);
            });
    }
}
