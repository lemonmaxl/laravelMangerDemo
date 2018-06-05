<?php
namespace App\Repositories\Presenter;
use App\Model\Permission;
/**
 * 服务注入
* @inject 命令可以取出 Laravel 服务容器 中的服务。传递给 @inject 
* 的第一个参数为置放该服务的变量名称，而第二个参数为你想要解析的服务的类或是接口的名称
*/
class PermissionPresenter
{
	public function getPermissionsList($permissions)
	{
		if ($permissions) {
			$html = '';
			foreach ($permissions as $k => $v) {
				$html .= '<tr>';
				$html .= '<td>'.$v['name'].'</td>';
				$html .= '<td><span class="pie">'.$v['display_name'].'</span></td>';
				
				if ($v['status'] == 1) {
					$html .= '<td><span class="label label-primary">启用</span></td>';
				}else{
					$html .= '<td><span class="label label-default">禁用</span></td>';
				}
				$html .= '<td>'.$v['created_at'].'</td>';
				$html .= '<td>';
				$html .= $this->getActionButton($v['id']);
				$html .= '</td>';
				$html .= '</tr>';
			}
			return $html;
		}
		return '暂无权限信息';
	}

	public function getActionButton($id)
	{
		$action = '';
		if (auth()->user()->can('/admin/permissions/info')) {
			$action .= ' <a href="table_basic.html#" class="btn btn-xs btn-success infoPermission" title="查看"><i class="fa fa-folder"></i></a>';
		}
		if (auth()->user()->can('/admin/permissions/edit')) {
			$action .= ' <a href="javascript:;" data-href="'.url('admin/permissions/'.$id .'/edit').'" class="btn btn-xs btn-warning editPermission" title="编辑"><i class="fa fa-pencil"></i></a>';
		}
		if (auth()->user()->can('/admin/permissions/delete')) {
			$action .= ' <a href="javascript:;" data-id="'.$id.'" class="btn btn-xs btn-danger destoryPermission" title="删除"><i class="fa fa-trash"></i><form method="post" name="destForm'.$id.'" action="'.url('admin/permissions' , [$id]).'"><input type="hidden" name="_method" value="delete"><input type="hidden" name="_token" value="'.csrf_token().'"></form></a>';
		}
		
		
		return $action;

	}

}