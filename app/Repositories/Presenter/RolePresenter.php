<?php
namespace App\Repositories\Presenter;
use App\Model\Role;
use App\Model\Permission;
/**
 * 服务注入
* @inject 命令可以取出 Laravel 服务容器 中的服务。传递给 @inject 
* 的第一个参数为置放该服务的变量名称，而第二个参数为你想要解析的服务的类或是接口的名称
*/
class RolePresenter
{
	public function getRolesList($roles)
	{
		if ($roles) {
			$html = '';
			foreach ($roles as $k => $v) {
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
		return '暂无角色';
	}

	public function getActionButton($id)
	{
		$action = '';
		// if (auth()->user()->can('/admin/roles/info')) {
		// 	$action .= '<a href="table_basic.html#" class="btn btn-xs btn-success infoRole" title="查看"><i class="fa fa-folder"></i></a>';
		// }
		if (auth()->user()->can('/admin/roles/assign')) {
			$action .= ' <a data-toggle="modal" href="#assign-permiss" data-id="'.$id.'" class="btn btn-xs btn-success" title="分配"><i class="fa fa-sun-o"></i></a>';
		}
		if (auth()->user()->can('/admin/roles/edit')) {
			$action .= ' <a href="javascript:;" data-href="'.url('admin/roles/'.$id.'/edit').'" class="btn btn-xs btn-warning editRole" title="编辑"><i class="fa fa-pencil"></i></a>';
		}
		if (auth()->user()->can('/admin/roles/delete')) {
			$action .= ' <a href="javascript:;" data-id="'.$id.'" class="btn btn-xs btn-danger destoryRole" title="删除"><i class="fa fa-trash"></i><form method="post" name="destForm'.$id.'" action="'.url('admin/roles' , [$id]).'"><input type="hidden" name="_method" value="delete"><input type="hidden" name="_token" value="'.csrf_token().'"></form></a>';
		}
		return $action;
	}

	/**
	 * 获取所有权限的树形节点
	 * @return [type] [description]
	 */
	public function getPermissionsInfo()
    {
        $pers = Permission::select('id','name','display_name')->get()->toarray();
        if (!empty($pers)) {
        	
	        // 二维数组变为一维数组
	        $perss = array_dot($pers);
	        // 分为两个数组,一个父数组,一个子数组
	        for ($i=0; $i <count($pers) ; $i++) { 
	            $perss[$i.'.'.'name'] = explode('/', ltrim($perss[$i.'.'.'name'] , '/') );
	            if (count($perss[$i.'.'.'name']) == 2) {
	                $pers1[$i]['id'] = $perss[$i.'.'.'id'];
	                $pers1[$i]['name'] = $perss[$i.'.'.'name'];
	                $pers1[$i]['text'] = $perss[$i.'.'.'display_name'];
	            }else{
	                $pers2[$i]['id'] = $perss[$i.'.'.'id'];
	                $pers2[$i]['name'] = $perss[$i.'.'.'name'];
	                $pers2[$i]['text'] = $perss[$i.'.'.'display_name'];
	            }
	        }

	        foreach ($pers1 as $k1 => $v1) {
	            foreach ($pers2 as $k2 => $v2) {
	                // 获得连个 name属性数组的交集
	                if ($v1['name'] == array_intersect($v1['name'], $v2['name'])) {

	                    $pers1[$k1]['children'][$k2] = $pers2[$k2];
	                    unset($pers1[$k1]['children'][$k2]['name']);
	                    unset($pers1[$k1]['name']);
	                }
	            }
	        }

	        return $this->permissionsInfoToHtml($pers1);
	    }
	    return '暂无权限数据';
    }

    public function permissionsInfoToHtml($pers)
    {
    	
    	$html = '<ul>';
    	foreach ($pers as $k => $v) {
    		$html .= '<li id="'.$v['id'].'">'.$v['text'];
    		if (!empty($v['children'])) {
    			$html .= '<ul>';
    			foreach ($v['children'] as $k1 => $v1) {
    				$html .= '<li id="'.$v1['id'].'">'.$v1['text'].'</li>';
    			}
    			$html .= '</ul>';
    		}
    		$html .= '</li>';
    	}
    	$html .= '</ul>';
    	return $html;
    }


}