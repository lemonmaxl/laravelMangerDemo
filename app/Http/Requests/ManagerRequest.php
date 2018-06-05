<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        if (request('id' , '')) {
            return [
                'editname' => 'required|min:5|max:20|unique:admins,name,'.$this->id,
                'editusername' => 'required|min:2|max:20|unique:admins,username,'.$this->id,
                'editemail' => 'required|email|unique:admins,email,'.$this->id,
            ];
        }else{
            return [
                'name' => 'required|min:5|max:20|unique:admins,name',
                'username' => 'required|min:2|max:20|unique:admins,username',
                'password' => 'required|min:6|max:20',
                'email' => 'required|email|unique:admins,email',
            ];
        }
        
    }

    /**
     * 获取已定义的验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '用户名不能为空',
            'name.min' => '用户名最少5个字',
            'name.max' => '用户名不能超过20个字',
            'name.unique' => '用户名已存在',
            'username.required'  => '昵称不能为空',
            'username.min'  => '昵称最少2个字',
            'username.max'  => '昵称不能超过20个字',
            'username.unique'  => '昵称已存在',
            'editname.required' => '用户名不能为空',
            'editname.min' => '用户名最少5个字',
            'editname.max' => '用户名不能超过20个字',
            'editname.unique' => '用户名已存在',
            'editusername.required'  => '昵称不能为空',
            'editusername.min'  => '昵称最少2个字',
            'editusername.max'  => '昵称不能超过20个字',
            'editusername.unique'  => '昵称已存在',
            'editemail.required'  => '邮箱不能为空',
            'editemail.email'  => '邮箱格式不正确',
            'editemail.unique'  => '邮箱已存在',    
        ];
    }

    
}
