<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CateRequest extends FormRequest
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
            $rules['name'] = 'required|unique:cates,name,'.$this->id;
        }else{
            $rules['name'] = 'required|unique:cates,name';
        }
        
        $rules = [
            'pid' => 'required',
        ];
        return $rules;
    }


    /**
     * [FunctionName description]
     * @param string $value [description]
     */
    public function messages()
    {
        return [
            'name.required' => '分类名称不能为空',
            'name.unique' => '分类名称已经存在',
            'pid.required' => '请选择上级分类',
        ];
    }
}
