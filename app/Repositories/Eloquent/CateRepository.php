<?php
namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\Repository;
use App\Model\Cate;
use Cache;
/**
* 仓库模式(分类仓库)
*/
class CateRepository extends Repository
{
	
	public function model()
	{
		// 返回菜单的类名
		
		return Cate::class;
	}

	/**
	 * 递归排序分类
	 * @param  [type]  $menus [description]
	 * @param  integer $pid   [description]
	 * @return [type]         [description]
	 */
	public function sortCate($cates , $pid = 0)
	{
		$arr = [];
		if ($cates) {
			if (empty($cates)) {
				return '';
			}
		}
		foreach ($cates as $k => $v) {
			if ($v['pid'] == $pid) {
				$arr[$k] = $v;//父级菜单
				$arr[$k]['child'] = self::sortCate($cates , $v['id']);
			}
		}
		return $arr;
	}

	/**
	 * 获取菜单集合->递归排序->倒序排序子菜单
	 * @return [type] [description]
	 */
	// public function sortChildMenuAndSetCache()
	// {
	// 	// 获取所有的菜单数据并倒序
	// 	$menus = $this->model->orderBy('sort' , 'desc')->get()->toArray();
	// 	if ($menus) {
	// 		//递归排序
	// 		$menusList = $this->sortCate($menus);
	// 		// 倒叙排序子菜单
	// 		foreach ($menusList as $k => &$v) {
	// 			if ($v['child']) {
	// 				$sortChild = array_column($v['child'], 'sort');
	// 				array_multisort($sortChild , SORT_DESC , $v['child']);
	// 			}
	// 		}
	// 		// 缓存菜单数据
	// 		Cache::forever('menusList', $menusList);
	// 		return $menusList;
	// 	}
		
	// 	return '';
	// }

	/**
	 * 获取菜单列表
	 * @return [type] [description]
	 */
	// public function getMenuList()
	// {
	// 	if (Cache::has('menusList')) {
	// 		return Cache::get('menusList');
	// 	}
	// 	return $this->sortChildMenuAndSetCache();
	// }

	/**
	 * 修改菜单时获取菜单数据
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function editCate($id)
	{
		$cates = $this->model->find($id)->toArray();
		if ($cates) {
			$cates['update'] = url('admin/cates/' . $id);
			$cates['msg'] = '加载成功';
			$cates['mstatus'] = true;
			return $cates;
		}
		return ['mstatus'=>false , 'msg'=> '加载失败'];
	}

	/**
	 * 更新菜单 , 重新缓存
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function updateCate($request)
	{
		$cate = $this->model->find($request->id);
		if ($cate) {
			$isUpdate = $cate->update($request->all());
			if ($isUpdate) {
				
				flash('修改分类成功' , 'success');
				return true;
			}
			flash( '修改分类失败' , 'failed');
			return false;
		}
		abort(404 , '分类数据找不到');
	}

	/**
	 * 删除菜单 , 重新缓存
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function destroyCate($id)
	{
		// 当前分类下的所有子分类
		$cateArr = $this->getChilds($id);
		$cateArr[] = $id;
		// return $cateArr;
		$isDel = $this->model->destroy($cateArr);
		if ($isDel) {
			flash('删除分类成功' , 'success');
			return true;
		}
		flash('删除分类失败' , 'failed');
		return false;
	}

	/**
	 * 获取主分类下的所有分类
	 * @param  $id [description]
	 */
	public function getChilds($id)
	{
		$cates = $this->model->all();
		return $this->_getChilds($cates , $id , true);
	}

	/**
	 * 获取主分类下的所有分类
	 * @param  [type]  $cates   [所有分类]
	 * @param  [type]  $pid     [上级分类id]
	 * @param  boolean $isClear [description]
	 * @return [type]           [description]
	 */
	public function _getChilds($cates , $pid , $isClear = false)
	{
		static $cate = [];
		if ($isClear)
			$cate = [];
		foreach ($cates as $k => $v) {
			if ($v['pid'] == $pid) {
				$cate[] = $v['id'];
				$this->_getChilds($cates , $v['id']);
			}
		}
		return $cate;
	}

}