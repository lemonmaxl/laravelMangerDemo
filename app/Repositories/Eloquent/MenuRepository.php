<?php
namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\Repository;
use App\Model\Menu;
use Cache;
/**
* 仓库模式(菜单仓库)
*/
class MenuRepository extends Repository
{
	
	public function model()
	{
		// 返回菜单的类名
		
		return Menu::class;
	}

	/**
	 * 递归排序菜单
	 * @param  [type]  $menus [description]
	 * @param  integer $pid   [description]
	 * @return [type]         [description]
	 */
	public function sortMenu($menus , $pid = 0)
	{
		$arr = [];
		if ($menus) {
			if (empty($menus)) {
				return '';
			}
		}
		foreach ($menus as $k => $v) {
			if ($v['parent_id'] == $pid) {
				$arr[$k] = $v;//父级菜单
				$arr[$k]['child'] = self::sortMenu($menus , $v['id']);
			}
		}
		return $arr;
	}

	/**
	 * 获取菜单集合->递归排序->倒序排序子菜单
	 * @return [type] [description]
	 */
	public function sortChildMenuAndSetCache()
	{
		// 获取所有的菜单数据并倒序
		$menus = $this->model->orderBy('sort' , 'desc')->get()->toArray();
		if ($menus) {
			//递归排序
			$menusList = $this->sortMenu($menus);
			// 倒叙排序子菜单
			foreach ($menusList as $k => &$v) {
				if ($v['child']) {
					$sortChild = array_column($v['child'], 'sort');
					array_multisort($sortChild , SORT_DESC , $v['child']);
				}
			}
			// 缓存菜单数据
			Cache::forever('menusList', $menusList);
			return $menusList;
		}
		
		return '';
	}

	/**
	 * 获取菜单列表
	 * @return [type] [description]
	 */
	public function getMenuList()
	{
		if (Cache::has('menusList')) {
			return Cache::get('menusList');
		}
		return $this->sortChildMenuAndSetCache();
	}

	/**
	 * 修改菜单时获取菜单数据
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function editMenu($id)
	{
		$menus = $this->model->find($id)->toArray();
		if ($menus) {
			$menus['update'] = url('admin/menus/' . $id);
			$menus['msg'] = '加载成功';
			$menus['mstatus'] = true;
			return $menus;
		}
		return ['mstatus'=>false , 'msg'=> '加载失败'];
	}

	/**
	 * 更新菜单 , 重新缓存
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function updateMenu($request)
	{
		$menu = $this->model->find($request->id);
		if ($menu) {
			$isUpdate = $menu->update($request->all());
			if ($isUpdate) {
				$this->sortChildMenuAndSetCache();
				flash('修改菜单成功' , 'success');
				return true;
			}
			flash( '修改菜单失败' , 'error');
			return false;
		}
		abort(404 , '菜单数据找不到');
	}

	/**
	 * 删除菜单 , 重新缓存
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function destroyMenu($id)
	{
		$isDel = $this->model->destroy($id);
		if ($isDel) {
			$this->sortChildMenuAndSetCache();
			flash('删除菜单成功' , 'success');
			return true;
		}
		flash('删除菜单成功' , 'error');
		return false;
	}

}