<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoodRequest extends FormRequest
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
        return [
            'cateid' => 'required',
            'title' => 'required|max:60',
            'short_title' => 'max:20',
            'short_desc' => 'max:200',
            'detail' => 'required',
            'markt_price' => 'required',
            'shop_price' => 'required',
            'pic' => 'required',
        ];
    }

    /**
     * 返回的错误信息
     * @return [type] [description]
     */
    public function messages()
    {
        return [
            'cateid.required' => '请选择一个分类',
            'title.required' => '商品标题不能为空',
            'title.max' => '商品标题最多60个字符',
            'short_title.min' => '短标题最小4个字符',
            'short_title.max' => '短标题最大10个字符',
            'short_desc.max' => '简短说明最多200个字符',
            'detail.required' => '商品详情不能为空',
            'markt_price.required' => '市场价不能为空',
            'shop_price.required' => '店铺价不能为空',
            'pic.required' => '轮播图不能为空',
        ];
    }


}
