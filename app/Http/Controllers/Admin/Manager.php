<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\ManagerRepository;
use App\Http\Requests\ManagerRequest;
use App\Model\Admin;
use App\Model\Role;
class Manager extends Controller
{
    protected $admin;
    public function __construct(ManagerRepository $admin)
    {
        $this->admin = $admin;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //搜索关键字
        $kw = $request->input('kw');
        //条件分页
        $managers = Admin::where('name', 'like' , '%'.$kw.'%')->paginate(8);
        
        // dd($managers->total());
        return view('admin.manager.index' , ['managers'=>$managers, 'kw'=>$kw]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ManagerRequest $request)
    {
        
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        $res = $this->admin->create($data);
        if ($res) {
            return response()->json(['status'=>0 , 'info'=>'success' , 'msg'=>'创建管理员成功']);
        }else{
            return response()->json(['status'=>1 , 'info'=>'fail' , 'msg'=>'创建管理员失败']);
        }
        
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
        $manager = $this->admin->editManager($id);

        return response()->json($manager);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ManagerRequest $request)
    {
        // 验证逻辑,不使用ManagerRequest
        // $id = $request->id;
        // $this->validate($request, [
        //     'editname' => 'required|min:5|max:20|unique:admins,name,'.$id,
        //     'editusername' => 'required|min:2|max:20|unique:admins,username,'.$id,
        //     'editemail' => 'required|email|unique:admins,email,'.$id,
        // ]);
        $res = $this->admin->updateManager($request);
        return response()->json($res);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->admin->destroyManager($id);
        return redirect('admin/managers');
    }

    public function getManagerInfoById(Request $request)
    {
        // 获取管理员数据
        $id = $request->id;
        $manager = $this->admin->editManager($id);
        //所有角色
        $roles = Role::all()->toArray();
        $manager['optionHtml'] = $this->getAllRoles($roles, $id);
        return response()->json($manager);
    }

    /**
     * 是超级管理员就获取所有的角色 , 不是就过滤掉admin角色
     * @param  [type] $roles [description]
     * @return [type]        [description]
     */
    public function getAllRoles($roles , $id)
    {
        if (!empty($roles)) {
            $option = '';
            if (auth()->user()->hasRole('admin')) {
                
                foreach ($roles as $v) {
                    if (Admin::find($id)->hasRole($v['name'])) {
                        $option .= '<option selected value="'.$v['id'].'">'.$v['name'].'</option>';
                    }else{
                        $option .= '<option value="'.$v['id'].'">'.$v['name'].'</option>';
                    }
                    
                }
                return $option;
            }
            // 过滤掉admin
            $roles = array_filter($roles , function ($v , $k)
            {
                return $v['name'] != 'admin';
            },ARRAY_FILTER_USE_BOTH);
            foreach ($roles as $v) {
                $option .= '<option value="'.$v['id'].'">'.$v['name'].'</option>';
            }
            return $option;
        }
        return '<option value="" disabled>暂无角色</option>';
    }



    public function assignRole(Request $request)
    {
        $manID = $request->managerId;
        $roleIdArr = $request->roleIds;
        // 清空角色
        $this->admin->find($manID)->detachRoles();
        if (!empty($roleIdArr)) {
            
            $this->admin->find($manID)->attachRoles($roleIdArr);
            
            flash('分配角色成功' , 'success');
            
        }
        
        return redirect('admin/managers');
    }
}
