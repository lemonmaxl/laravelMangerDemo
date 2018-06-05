<?php
namespace App\Repositories\Presenter;

/**
 * 服务注入
* @inject 命令可以取出 Laravel 服务容器 中的服务。传递给 @inject 
* 的第一个参数为置放该服务的变量名称，而第二个参数为你想要解析的服务的类或是接口的名称
*/
class GoodPresenter
{
	/**
	 * 商品添加中的分类信息
	 * @param  [type] $cates [description]
	 * @return [type]        [description]
	 */
	public function getCate($cates)
	{
		if ($cates) {
			$option = '';
			foreach ($cates as $v) {
				$option .= '<option value="' . $v->id . '">' . $v->name . '</option>';
				if ($v->child) {
					foreach ($v->child as $v1) {
						$option .= '<option value="' . $v1->id . '">|____' . $v1->name . '</option>';
						if ($v1->child) {
							foreach ($v1->child as $v2) {
								$option .= '<option disabled value="' . $v2->id . '">|__________' . $v2->name . '</option>';
							}
						}
					}
					
				}
			}
			return $option;
		}
		return '<option value="">暂无分类</option>';
	}

	

   

}
