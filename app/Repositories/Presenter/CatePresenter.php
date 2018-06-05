<?php
namespace App\Repositories\Presenter;

/**
 * 服务注入
* @inject 命令可以取出 Laravel 服务容器 中的服务。传递给 @inject 
* 的第一个参数为置放该服务的变量名称，而第二个参数为你想要解析的服务的类或是接口的名称
*/
class CatePresenter
{
	/**
	 * 表单中所有的顶级分类
	 * @param  [type] $cates [description]
	 * @return [type]        [description]
	 */
	public function getCate($cates)
	{
		if ($cates) {
			$option = '<option value="0">顶级分类</option>';
			foreach ($cates as $v) {
				$option .= '<option value="' . $v->id . '">' . $v->name . '</option>';
				if ($v->child) {
					foreach ($v->child as $v1) {
						$option .= '<option value="' . $v1->id . '">|____' . $v1->name . '</option>';
						if ($v1->child) {
							foreach ($v1->child as $v2) {
								$option .= '<option disabled value="' . $v2->id . '">|__________' . $v2->name . '</option>';
							}
						}
					}
					
				}
			}
			return $option;
		}
		return '<option value="0">顶级分类</option>';
	}

	/**
	 * 分类列表视图
	 * @param  [type] $cates [description]
	 * @return [type]        [description]
	 */
	public function getCateList($cates)
	{
		if ($cates) {
			$html = '';
			foreach ($cates as $v) {
				$html .= $this->getNestableFirstCate($v);
			}
			return $html;
		}
		return '暂无分类';
	}

	/**
	 * 返回分类html
	 * @param  [type] $id    [description]
	 * @param  [type] $name  [description]
	 * @param  [type] $child [description]
	 * @return [type]        [description]
	 */
	public function getNestableFirstCate($cate)
	{
		// 是否有子集
		if ($cate['child']) {
			return $this->getNestableChildCate($cate['id'] , $cate['name'] , $cate['child']);
		}
		// 无子集但为顶级菜单
		if ($cate['pid'] == 0) {
			return '<li class="dd-item" data-id="'.$cate['id'].'"><div class="dd-handle dd-nodrag"><span class="pull-right action-buttons"> '.$this->actionButton($cate['id']).' </span><span class="label label-info"><i class="fa fa-th-large"></i></span> '.$cate['name'].'</div></li>';
		}
		return '<li class="dd-item" data-id="'.$cate['id'].'"><div class="dd-handle dd-nodrag"><span class="pull-right action-buttons"> '.$this->actionButton($cate['id'],false).' </span><span class="label label-info"><i class="fa fa-th-large"></i></span> '.$cate['name'].'</div></li>';
	}

	/**
	 * 判断是否有子集
	 * @param  [type] $id    [description]
	 * @param  [type] $name  [description]
	 * @param  [type] $child [description]
	 * @return [type]        [description]
	 */
	public function getNestableChildCate($id , $name , $child)
	{
		$handle = '<li class="dd-item" data-id="'.$id.'"><div class="dd-handle dd-nodrag"><span class="pull-right action-buttons"> '.$this->actionButton($id).' </span><span class="label label-info"><i class="fa fa-th-large"></i></span> '.$name.'</div><ol class="dd-list">';
		foreach ($child as $v) {
			$handle .= $this->getNestableFirstCate($v);
		}
		$handle .= '</ol></li>';
		return $handle;
	}

	/**
	 * 分类按钮html代码生成,并检测权限控制显示
	 * @param  [type]  $id   [description]
	 * @param  boolean $bool [description]
	 * @return [type]        [description]
	 */
	public function actionButton($id , $bool = true)
	{
		$action = '';
		if (auth()->user()->can('/admin/cates/add') && $bool) {
			$action .= ' <a href="javascript:;" data-pid="'.$id.'" class="btn btn-xs btn-success createMenu" data-toggle="tooltip" data-original-title="#"  data-placement="top"><i class="fa fa-plus"></i></a> ';
		}
		if (auth()->user()->can('/admin/cates/edit')) {
			$action .= ' <a href="javascript:;" data-href="'.url('admin/cates/'.$id.'/edit').'" class="btn btn-xs btn-warning editMenu" data-toggle="tooltip" data-original-title="#"  data-placement="top"><i class="fa fa-pencil"></i></a> ';
		}
		if (auth()->user()->can('/admin/cates/delete')) {
			$action .= ' <a href="javascript:;" data-id="'.$id.'" class="btn btn-xs btn-danger destroyMenu" data-original-title="##" data-toggle="tooltip"  data-placement="top"><i class="fa fa-trash"></i><form action="'.url('admin/cates' ,[$id]).'" method="POST" name="delete_item'.$id.'" style="display:none"><input type="hidden" name="_method" value="delete"><input type="hidden" name="_token" value="'.csrf_token().'"></form></a> ';
		}
		return $action;
	}

   

}

			