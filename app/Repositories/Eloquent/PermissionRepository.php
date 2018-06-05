<?php
namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\Repository;
use App\Model\Permission;
/**
* 权限仓库
*/
class PermissionRepository extends Repository
{

	public function model()
	{
		return Permission::class;
	}

	public function editPermission($id)
	{
		$permission = $this->model->find($id)->toArray();
		if ($permission) {
			$permission['update'] = url('admin/permissions/' . $id);
			$permission['msg'] = '加载成功';
			$permission['mstatus'] = true;
			return $permission;
		}
		return ['mstatus'=>false , 'msg'=> '加载失败'];
	}

	public function updatePermission($request)
	{
		$permission = $this->model->find($request->id);
		if ($permission) {
			$isUpdate = $permission->update($request->all());
			if ($isUpdate) {
				flash('编辑权限成功' , 'success');
				return true;
			}
			flash('编辑权限失败' , 'failed');
			return false;
		}
		abort(404 , '未找到权限数据');
	}

	public function destroyPermission($id)
	{
		$isDel = $this->model->destroy($id);
		if ($isDel) {
			flash('删除权限成功' , 'success');
			return true;
		}
		flash('删除权限失败' , 'failed');
		return false;
	}


}