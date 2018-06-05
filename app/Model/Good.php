<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    /**
     * 允许被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
    	'cateid',
    	'title',
    	'short_title',
    	'number',
		'short_desc',
		'detail',
		'markt_price',
		'shop_price',
		'sale_price',
		'start_time',
		'end_time',
		'pic',
		'tags',
    	
    ];
}
