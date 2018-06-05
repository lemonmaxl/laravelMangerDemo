<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'parent_id' => 'required',
            'url' => 'required',
        ];
        if (request('id' , '')) {
            $rules['name'] = 'required|min:2|max:16|unique:menus,name,'.$this->id;
        }else{
            $rules['name'] = 'required|min:2|max:16|unique:menus,name';
        }
        return $rules;
    }

    /**
     * 获取已定义的验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '菜单名称不能为空',
            'name.unique' => '菜单名称已存在',
            'name.min' => '菜单名称最少2个字',
            'name.max' => '菜单名称不能超过16个字',
            'parent_id.required'  => '父级菜单不能为空',
            'url.required'  => '菜单链接不能为空',
        ];
    }
}
