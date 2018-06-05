<?php

use Illuminate\Database\Seeder;
use App\Model\Cate;
class CatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $Cate = new Cate;
        $Cate->name = '手机';
        $Cate->pid = 0;
        $Cate->save();

        $Cate = new Cate;
        $Cate->name = '苹果';
        $Cate->pid = 1;
        $Cate->save();

        $Cate = new Cate;
        $Cate->name = 'iPhone8';
        $Cate->pid = 2;
        $Cate->save();

        $Cate = new Cate;
        $Cate->name = '小米';
        $Cate->pid = 1;
        $Cate->save();

        $Cate = new Cate;
        $Cate->name = '小米6';
        $Cate->pid = 4;
        $Cate->save();
    }
}
