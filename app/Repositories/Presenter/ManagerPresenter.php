<?php
namespace App\Repositories\Presenter;
use App\Model\Admin;
/**
 * 服务注入
* @inject 命令可以取出 Laravel 服务容器 中的服务。传递给 @inject 
* 的第一个参数为置放该服务的变量名称，而第二个参数为你想要解析的服务的类或是接口的名称
*/
class ManagerPresenter
{
	/**
	 * 管理员列表html
	 * @param  [type] $managers [description]
	 * @return [type]           [description]
	 */
	public function getManagersList($managers)
	{
		if ($managers->total() > 0) {
			$html = '<tr>';
			foreach ($managers as $v) {
				
				$html .= '<td class="project-title"><a href="javascript:;">'.$v['name'].'</a><br/><small>创建于 '.$v['created_at'].'</small></td>';
				$html .= '<td class="project-title"><a href="javascript:;">'.$v['username'].'</a></td>';

				$html .= '<td class="project-title"><a href="javascript:;">'.$this->getManagerRoles($v['id']).'</a></td>';
				$html .= '<td class="project-title"><a href="javascript:;">'.$v['email'].'</a></td>';
				if ($v['status'] == 1) {
					$html .= '<td class="project-status"><span class="label label-primary">启用</span></td>';
				}else{
					$html .= '<td class="project-status"><span class="label label-default">禁用</span></td>';
				}
				$html .= '<td class="project-actions">';
				$html .= $this->getActionButton($v['id']);
				$html .= '</td>';
				$html .= '</tr>';
				
			}
			return $html;

		}
		return '暂无管理员';
	}

	/**
	 * 获取每一个管理员的所属的角色
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getManagerRoles($id)
	{
		$roles = Admin::find($id)->roles()->get()->toArray();
		if (!empty($roles)) {
			foreach ($roles as $k => $role) {
				$roleStr[$k] = $role['display_name'];
			}
			return implode(',', $roleStr);
		}
		return '暂无角色';
	}

	public function getActionButton($id)
	{
		$action = '';
		// if (auth()->user()->can('/admin/managers/info')) {
		// 	$action .= ' <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> 查看 </a>';
		// }
		if (auth()->user()->can('/admin/managers/assign')) {
			$action .= ' <a data-toggle="modal" href="#assign-role" data-id="'.$id.'" class="btn btn-white btn-sm"><i class="fa fa-sun-o"></i> 分配 </a>';
		}
		if (auth()->user()->can('/admin/managers/edit')) {
			$action .= ' <a data-toggle="modal" href="'.url('admin/managers/'.$id.'/edit#edit-form').'" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑 </a>';
		}
		if (auth()->user()->can('/admin/managers/delete')) {
			$action .= ' <a href="javascript:;" data-id="'.$id.'" class="btn btn-white btn-sm destroyBt"><i class="fa fa-trash"></i> 删除 <form action="'.url('admin/managers' ,[$id]).'" method="POST" name="delete_item'.$id.'" style="display:none"><input type="hidden" name="_method" value="delete"><input type="hidden" name="_token" value="'.csrf_token().'"></form></a>';
		}
		return $action;
	}

	

	

}

			