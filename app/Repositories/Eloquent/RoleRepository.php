<?php
namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\Repository;
use App\Model\Role;
/**
* 管理员仓库
*/
class RoleRepository extends Repository
{
	
	public function model()
	{
		// 返回Admin的类名
		
		return Role::class;
	}

	public function editRole($id)
	{
		$role = $this->model->find($id)->toArray();
		if ($role) {
			$role['update'] = url('admin/roles/' . $id);
			$role['msg'] = '加载成功';
			$role['mstatus'] = true;
			return $role;
		}
		return ['mstatus'=>false , 'msg'=> '加载失败'];
	}

	public function updateRole($request)
	{
		$role = $this->model->find($request->id);
		if ($role) {
			$isUpdate = $role->update($request->all());
			if ($isUpdate) {
				flash('编辑角色成功' , 'success');
				return true;
			}
			flash('编辑角色失败' , 'failed');
			return false;
		}
		abort(404 , '未找到角色数据');
	}

	public function destroyRole($id)
	{
		$isDel = $this->model->destroy($id);
		if ($isDel) {
			flash('删除角色成功' , 'success');
			return true;
		}
		flash('删除角色失败' , 'failed');
		return false;
	}

	/**
	 * 获取角色所有的权限
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getRoleAllPermissions($id)
	{
		$role = $this->model->find($id);

        foreach ($role->perms as $k => $p) {
            $perStr[$k] = $p->pivot->permission_id;
        }
        return empty($perStr)? '':$perStr;
	}

}