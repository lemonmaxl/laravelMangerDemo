<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\RoleRepository;
use App\Http\Requests\RoleRequest;

class Role extends Controller
{
    protected $role;
    public function __construct(RoleRepository $role)
    {
        $this->role = $role;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $roles = $this->role->all()->toarray();
        // dd($roles);
        return view('admin.role.index' , ['roles'=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $res = $this->role->create($request->all());
        if ($res) {
            flash('创建角色成功' , 'success');
        }else{
            flash('创建角色失败' , 'failed');
        }
        return redirect('admin/roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = $this->role->editRole($id);
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request)
    {
        $this->role->updateRole($request);
        return redirect('admin/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->role->destroyRole($id);
        return redirect('admin/roles');
    }

    /**
     * 分配表单获得角色信息 , 并且获取已有的权限id
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getRoleInfoById(Request $request)
    {
        $roleId = $request->id;
        // 调用仓库方法
        $role = $this->role->editRole($roleId);
        // 获取角色权限
        $role['pers'] = $this->role->getRoleAllPermissions($roleId);


        return response()->json($role);
    }

    /**
     * 给角色分配权限
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function assignPermiss(Request $request)
    {
        
        $role_id = $request->roleId; // 角色id
        // 删除所有的权限
        $this->role->find($role_id)->detachPermissions();

        if ($request->perId) {
            $perIdArry = explode(',',  $request->perId);// 权限Id数组
            
            // 分配权限
            $this->role->find($role_id)->attachPermissions($perIdArry);
           
            flash('分配权限成功' , 'success');
            
            return redirect('admin/roles');
        }
        return redirect('admin/roles');
        
    }

    

}
