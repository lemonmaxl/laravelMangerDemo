<?php
namespace App\Repositories\Presenter;

/**
 * 服务注入
* @inject 命令可以取出 Laravel 服务容器 中的服务。传递给 @inject 
* 的第一个参数为置放该服务的变量名称，而第二个参数为你想要解析的服务的类或是接口的名称
*/
class MenuPresenter
{
	/**
	 * 表单中所有的顶级菜单
	 * @param  [type] $menus [description]
	 * @return [type]        [description]
	 */
	public function getMenu($menus)
	{
		if ($menus) {
			$option = '<option value="0">顶级菜单</option>';
			foreach ($menus as $v) {
				$option .= '<option value="' . $v->id . '">' . $v->name . '</option>';
			}
			return $option;
		}
		return '<option value="0">顶级菜单</option>';
	}

	/**
	 * 菜单列表视图
	 * @param  [type] $menus [description]
	 * @return [type]        [description]
	 */
	public function getMenuList($menus)
	{
		if ($menus) {
			$html = '';
			foreach ($menus as $v) {
				$html .= $this->getNestableFirstMenu($v);
			}
			return $html;
		}
		return '暂无菜单';
	}

	/**
	 * 返回菜单html
	 * @param  [type] $id    [description]
	 * @param  [type] $name  [description]
	 * @param  [type] $child [description]
	 * @return [type]        [description]
	 */
	public function getNestableFirstMenu($menu)
	{
		// 是否有子集
		if ($menu['child']) {
			return $this->getNestableChildMenu($menu['id'] , $menu['name'] , $menu['icon'] , $menu['url'] , $menu['child']);
		}
		// 无子集但为顶级菜单
		if ($menu['parent_id'] == 0) {
			return '<li class="dd-item" data-id="'.$menu['id'].'"><div class="dd-handle dd-nodrag"><span class="pull-right action-buttons"> '.$this->actionButton($menu['id']).' </span><span class="label label-info"><i class="'.$menu['icon'].'"></i></span> '.$menu['name'].' &nbsp;&nbsp;&nbsp;&nbsp; '.$menu['url'].'</div></li>';
		}
		return '<li class="dd-item" data-id="'.$menu['id'].'"><div class="dd-handle dd-nodrag"><span class="pull-right action-buttons"> '.$this->actionButton($menu['id'],false).' </span><span class="label label-info"><i class="'.$menu['icon'].'"></i></span> '.$menu['name'].' &nbsp;&nbsp;&nbsp;&nbsp; '.$menu['url'].'</div></li>';
	}

	/**
	 * 判断是否有子集
	 * @param  [type] $id    [description]
	 * @param  [type] $name  [description]
	 * @param  [type] $child [description]
	 * @return [type]        [description]
	 */
	public function getNestableChildMenu($id , $name , $icon , $url , $child)
	{
		$handle = '<li class="dd-item" data-id="'.$id.'"><div class="dd-handle dd-nodrag"><span class="pull-right action-buttons"> '.$this->actionButton($id).' </span><span class="label label-info"><i class="'.$icon.'"></i></span> '.$name.' &nbsp;&nbsp;&nbsp;&nbsp; '.$url.'</div><ol class="dd-list">';
		foreach ($child as $v) {
			$handle .= $this->getNestableFirstMenu($v);
		}
		$handle .= '</ol></li>';
		return $handle;
	}

	/**
	 * 菜单按钮html代码生成,并检测权限控制显示
	 * @param  [type]  $id   [description]
	 * @param  boolean $bool [description]
	 * @return [type]        [description]
	 */
	public function actionButton($id , $bool = true)
	{
		$action = '';
		if (auth()->user()->can('/admin/menus/add') && $bool) {
			$action .= ' <a href="javascript:;" data-pid="'.$id.'" class="btn btn-xs btn-success createMenu" data-toggle="tooltip" data-original-title="#"  data-placement="top"><i class="fa fa-plus"></i></a> ';
		}
		if (auth()->user()->can('/admin/menus/edit')) {
			$action .= ' <a href="javascript:;" data-href="'.url('admin/menus/'.$id.'/edit').'" class="btn btn-xs btn-warning editMenu" data-toggle="tooltip" data-original-title="#"  data-placement="top"><i class="fa fa-pencil"></i></a> ';
		}
		if (auth()->user()->can('/admin/menus/delete')) {
			$action .= ' <a href="javascript:;" data-id="'.$id.'" class="btn btn-xs btn-danger destroyMenu" data-original-title="##" data-toggle="tooltip"  data-placement="top"><i class="fa fa-trash"></i><form action="'.url('admin/menus' ,[$id]).'" method="POST" name="delete_item'.$id.'" style="display:none"><input type="hidden" name="_method" value="delete"><input type="hidden" name="_token" value="'.csrf_token().'"></form></a> ';
		}
		return $action;
	}

    
	public function getLeftMenusList($menus)
	{
		if ($menus) {
			$html = '';
			foreach ($menus as $v) {
				$html .= $this->leftMenusFirst($v);
			}
			return $html;
		}
		return '暂无菜单';
	}

	public function leftMenusFirst($menu)
	{
		// 是否有子集
		if ($menu['child']) {
			return $this->leftMenusSecond($menu['name'] , $menu['url'] , $menu['icon'] , $menu['child']);
		}
		// 没有子集的顶级菜单
		if ($menu['parent_id'] == 0) {
			if (auth()->user()->can($menu['url'])) {
				return '<li><a href="#"><i class="'.$menu['icon'].'"></i><span class="nav-label">' . $menu['name']. '</span><span class="fa arrow"></span></a></li>';
			}
			
		}
		
	}

	public function leftMenusSecond($name , $url , $icon , $child)
	{
		if (auth()->user()->can($url)) {
			$html = '<li><a href="#"><i class="'.$icon.'"></i><span class="nav-label">' . $name. '</span><span class="fa arrow"></span></a><ul class="nav nav-second-level">';
		
			foreach ($child as $v) {
				if (auth()->user()->can($v['url'])) {
					$html .= '<li><a class="J_menuItem" href="'.$v['url'].'" data-index="0">'.$v['name'].'</a></li>';
				}
				
			}
			$html .= '</ul></li>';
			return $html;
		}
	}


}

			