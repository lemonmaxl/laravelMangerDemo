<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            $rules['name'] = 'required|min:2|max:20|unique:roles,name,'.$this->id;
        }else{
            $rules['name'] = 'required|min:2|max:20|unique:roles,name';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '角色名不能为空',
            'name.min' => '角色名最少 2 个字符',
            'name.max' => '角色名不能超过 20 个字符',
            'name.unique' => '角色名已经存在',
            'display_name.required' => '角色显示名不能为空',
            'display_name.min' => '角色显示名最少 2 个字符',
            'display_name.max' => '角色显示名不能超过 20 个字符',
        ];
    }
}
