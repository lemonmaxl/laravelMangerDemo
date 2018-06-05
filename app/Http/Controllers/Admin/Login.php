<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class Login extends Controller
{
	
    //
    public function index()
    {
    	if (!Auth::guard('admin')->check()) {
    		return view('admin.login.index');
    	}else{
    		return redirect('admin/index');
    	}
    	
    }

    /**
     * 登录处理
     * @return [type] [description]
     */
    public function login(Request $request)
    {
    	// 使用request验证表单
    	$this->validate($request, [
	        'username' => 'required|max:24',
	        'password' => 'required',
	        'captcha' => 'required|captcha',
	    ]);
	    // 使用auth指定守卫器找到模型进行数据验证,返回Boolean
    	$status = Auth::guard('admin')->attempt([
    			'username' => $request->input('username'),
    			'password' => $request->input('password'),
    		]);

    	if ($status) {
    		return response()->json(['status'=>0 , 'info'=>'success' , 'msg'=>'登录成功']);
    	}else{
    		return response()->json(['status'=>1 , 'info'=>'fail' , 'msg'=>'用户名或密码错误']);
    	}
    }

    /**
     * 退出
     */
    public function logout()
    {
    	Auth::guard('admin')->logout();

    	return redirect('admin/sign_in');
    }

}
