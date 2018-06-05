<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    /**
     * 允许被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
    	'name',
    	'pid',
    	
    ];
}
