<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Home\ExcelGood;
use App\Repositories\Eloquent\CateRepository;

class Index extends Controller
{
	protected $cate;
    public function __construct(CateRepository $cate)
    {
        $this->cate = $cate;
    }
    public function index()
    {
    	// 所有分类
        $cates = $this->cate->all();
        // 递归排序后的分类数组
        $cateBySort = $this->cate->sortCate($cates);
       	// 商品数据
       	$goods = ExcelGood::inRandomOrder()->simplePaginate(16);
    	return view('home.index.index' , ['cates' => $cateBySort , 'goods' => $goods]);
    }

    /**
     * 分类显示数据
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function show($cid)
    {
    	// 所有分类
        $cates = $this->cate->all();
        // 递归排序后的分类数组
        $cateBySort = $this->cate->sortCate($cates);
        // 分类Id的商品数据
       	$goods = ExcelGood::where('c_id' , $cid)->simplePaginate(16);
    	return view('home.index.goods' , ['cates' => $cateBySort , 'goods' => $goods ,'cid'=>$cid]);
    }

    /**
     * 点击喜欢商品
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function click_pick_goods(Request $request)
    {
    	$res = ExcelGood::where('id' , $request->gid)->increment('like',1);
    	if ($res) {
    		return response()->json(['code'=>200,'msg'=>'success']);
    	}
    	return response()->json(['code'=>201,'msg'=>'failed']);
    }

    /**
     * 搜索
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function searchGoods(Request $request)
    {
    	// 所有分类
        $cates = $this->cate->all();
        // 递归排序后的分类数组
        $cateBySort = $this->cate->sortCate($cates);
    	$goods = ExcelGood::where('title' , 'like' , '%'.$request->kw.'%')->simplePaginate(16);
    	// dd($goods);
    	return view('home.index.search' , ['cates' => $cateBySort ,'goods' => $goods , 'kw'=>$request->kw]);
    }
}
