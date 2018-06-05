<?php
namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\Repository;
use App\Model\Admin;
/**
* 管理员仓库
*/
class ManagerRepository extends Repository
{
	
	public function model()
	{
		// 返回Admin的类名
		
		return Admin::class;
	}

	public function editManager($id)
	{
		$manager = $this->model->find($id)->toArray();
		if ($manager) {
			$manager['update'] = url('admin/managers/' . $id);
			$manager['msg'] = '加载成功';
			$manager['mstatus'] = true;
			return $manager;
		}
		return ['mstatus'=>false , 'msg'=> '加载失败'];
	}

	public function updateManager($request)
	{
		$manager = $this->model->find($request->id);
		if ($manager) {
			$isUpdate = $manager->update([
											'id'=>$request->id,
											'name'=>$request->editname,
											'username'=>$request->editusername,
											'email'=>$request->editemail,
											'status'=>$request->editstatus,
										]);
			if ($isUpdate) {
				return ['mstatus'=>true , 'msg'=> '编辑成功'];
			}
			return ['mstatus'=>false , 'msg'=> '编辑失败'];
		}
		abort(404 , '未找到管理员数据');
	}

	public function destroyManager($id)
	{
		$this->model->destroy($id);
	}

}