<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\MenuRepository;
use App\Http\Requests\MenuRequest;

class Menu extends Controller
{

	protected $menu;
	public function __construct(MenuRepository $menu)
	{
		$this->menu = $menu;
	}

	
    //菜单首页
    public function index()
    {
    	
    	$menu = $this->menu->findByField('parent_id' , 0);
    	$menuList = $this->menu->getMenuList();
    	// dd($menuList);
    	return view('admin.menu.index' , [ 'menu' => $menu , 'menuList' => $menuList] );
    }

    /**
     * 添加菜单
     * @param  MenuRequest $request [description]
     * @return [type]               [description]
     */
    public function store(MenuRequest $request)
	{
		//你也可以使用 all 方法以 数组 形式获取到所有输入数据
		//调用仓库中的crate方法
		$res = $this->menu->create($request->all());
		// 添加之后刷新缓存
		$this->menu->sortChildMenuAndSetCache();
	    if ($res) {
	    	flash('添加菜单成功' , 'success');
	    }else{
	    	flash('添加菜单失败' , 'failed');
	    }
	    return redirect('admin/menus');
	}

	/**
	 * 返回指定菜单数据
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function edit($id)
	{
		$menus = $this->menu->editMenu($id);
		return response()->json($menus);
	}

	/**
	 * 更新菜单
	 * @param  MenuRequest $request [description]
	 * @return [type]               [description]
	 */
	public function update(MenuRequest $request)
	{
		$this->menu->updateMenu($request);
		return redirect('admin/menus');
	}

	/**
	 * 删除菜单
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function destroy($id)
	{
		$this->menu->destroyMenu($id);
		return redirect('admin/menus');
	}



}
