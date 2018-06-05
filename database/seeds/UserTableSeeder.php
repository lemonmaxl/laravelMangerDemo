<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //创建初始用户数据
        // DB::table('users')->insert([
        //     'name' => str_random(10),
        //     'email' => str_random(10).'@gmail.com',
        //     'password' => bcrypt('secret'),
        // ]);
        

        // 使用模型工厂填充数据
        $admin = factory('App\User')->create([
        		'name' => 'lemon',
        		'email' => 'lemon@163.com',
        		'password' => bcrypt('5071024'),
        	]);
        $users = factory('App\User', 3)->create([
        		'password' => bcrypt('123456')
        	]);
    }
}
