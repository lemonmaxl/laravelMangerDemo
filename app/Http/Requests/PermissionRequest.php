<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
        $rules = [

            'display_name' => 'required|min:2|max:20',
            
        ];
        if (request('id' , '')) {
            $rules['name'] = 'required|min:4|max:60|unique:permissions,name,'.$this->id;
        }else{
            $rules['name'] = 'required|min:4|max:60|unique:permissions,name';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '权限地址不能为空',
            'name.min' => '权限地址最少 4 个字符',
            'name.max' => '权限地址不能超过 60 个字符',
            'name.unique' => '权限地址已经存在',
            'display_name.required' => '权限名不能为空',
            'display_name.min' => '权限名最少 2 个字符',
            'display_name.max' => '权限名不能超过 20 个字符',
        ];
    }
}
