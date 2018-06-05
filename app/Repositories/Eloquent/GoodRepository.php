<?php
namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\Repository;
use App\Model\Good;
use Cache;
/**
* 仓库模式(分类仓库)
*/
class GoodRepository extends Repository
{
	
	public function model()
	{
		// 返回菜单的类名
		
		return Good::class;
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
	 * 修改商品时获取商品数据
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function editGood($id)
	{
		$good = $this->model->find($id)->toArray();
		if ($good) {
			$good['update'] = url('admin/goods/' . $id);
			$good['msg'] = '获取数据成功';
			$good['mstatus'] = true;
			return $good;
		}
		return ['mstatus'=>false , 'msg'=> '获取数据失败'];
	}



	/**
	 *  修改商品动作
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function updateGoods($request)
	{
		// 获取商品实例
		$goods = $this->model->find($request->id);
		if ($goods) {
			$goods_data = $request->all();
			$goods_data['pic'] = ltrim($goods_data['pic'], ',');
			$isUpdate = $goods->update($goods_data);
			if ($isUpdate) {
				
				flash('修改商品成功' , 'success');
				return true;
			}
			flash( '修改商品失败' , 'failed');
			return false;
		}
		abort(404 , '商品数据找不到');
	}

	/**
	 *  删除商品
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function destroyGoods($id)
	{
		$this->model->destroy($id);
		
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