<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();
// 前台
Route::group(['namespace' => 'Home' ], function(){
	// 首页
    Route::get('/', 'Index@index');
    Route::group(['prefix'=>'home'] , function(){
    	// 点击like
    	Route::post('index/pick_goods' , 'Index@click_pick_goods');
    	// 搜索
    	Route::get('index/search_goods' , 'Index@searchGoods');
    	// 分类Id查找商品
    	Route::resource('index', 'Index');
    	
    	
    });
});


Route::group(['prefix'=>'admin' , 'namespace' => 'Admin' ], function () {
	
    // 后台登录
    Route::get('/sign_in', 'Login@index');
    // 登录处理
    Route::post('/sign_in', 'Login@login');

    Route::group(['middleware' => ['CheckAdminLogin']] , function(){
    	// 后台首页
	    Route::get('/index', 'Index@index');
	    Route::get('/info', 'Index@info');
	    // 退出登录
	    Route::get('logout' , 'Login@logout');
	    // 菜单路由
	    Route::resource('menus', 'Menu');
	    // 获得指定管理员的信息
	    Route::post('managers/get_minfo', 'Manager@getManagerInfoById');
	    // 管理员分配
	    Route::post('managers/assign', 'Manager@assignRole');
	    // 管理员管理
	    Route::resource('managers' , 'Manager');
	    // 用户管理
	    Route::resource('users' , 'User');
	    // 获得指定管理员的信息
	    Route::post('roles/get_rinfo', 'Role@getRoleInfoById');
	    // 角色分配权限
	    Route::post('roles/assign' , 'Role@assignPermiss');
	    // 获取权限节点
	    Route::post('roles/get_json_info' , 'Role@permissionsInfoToJson');
	    // 角色管理
	    Route::resource('roles' , 'Role');

	    // 权限管理
	    Route::resource('permissions' , 'Permission');

	    // 分类管理
	    Route::get('cates/list' , 'Cate@index');
	    Route::resource('cates' , 'Cate');
	    // 商品管理
	    Route::get('goods/list' , 'Good@index');
	    // 上传图片
	    Route::post('goods/pic' , 'Good@uploadPic');
	    // 获取图片列表
	    Route::post('goods/get_pic' , 'Good@getPicList');
	    // 设置上架,新品,推荐,热卖状态
	    Route::post('goods/setSomeThing' , 'Good@setGoodsStatus');
	    // 库存
	    Route::post('goods/stock' , 'Good@setStock');
	    Route::resource('goods' , 'Good');
	    // Excel操作
	    Route::post('excelgoods/excel' , 'ExcelRead@uploadExcel');
	    Route::post('excelgoods/import','ExcelRead@import');
	    Route::resource('excelgoods','ExcelRead');
		
    });
    
	
});


