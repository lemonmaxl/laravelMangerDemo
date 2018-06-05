<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * 允许被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [

    	'name',
    	'icon',
    	'url',
    	'parent_id',
    	'sort',
    	'status',

    ];
}
