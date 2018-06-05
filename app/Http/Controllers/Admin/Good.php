<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\GoodRepository;
use App\Http\Requests\GoodRequest;
use App\Model\Cate;
class Good extends Controller
{
    protected $good;
    public function __construct(GoodRepository $good)
    {
        $this->good = $good;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 所有商品
        $goods = $this->good->all();
        // 所有分类
        $cates = Cate::all();
        return view('admin.good.index' , ['goods'=>$goods , 'cates'=>$cates]);
    }

    /**
     * 创建商品页
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cates = Cate::all();//获取分类集合
        $cateBySort = $this->good->sortCate($cates);//进行递归排序
        return view('admin.good.add' , ['cate'=>$cateBySort]);
    }

    /**
     * 添加商品到数据库
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GoodRequest $request)
    {
        // 获取数据.存入数据库
        $good = $request->all();
        // 去除图片左边的,
        $good['pic'] = ltrim($good['pic'], ',');
        $res = $this->good->create($good);
        if ($res) {
            flash('添加商品成功' , 'success');
        }else{
            flash('添加商品失败' , 'failed');
        }
        return redirect('admin/goods');
    }

    /**
     * 商品库存页
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stock = $this->good->find($id , ['id' , 'stock'])->toArray();
        return view('admin.good.stock' , ['stock'=>$stock]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cates = Cate::all();//获取分类集合
        $cateBySort = $this->good->sortCate($cates);//进行递归排序
        // 根据Id获取商品
        $goods = $this->good->editGood($id);
        $goods['picArr'] = explode(',', $goods['pic']);
        
        return view('admin.good.edit' , ['cate'=>$cateBySort , 'good'=>$goods]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GoodRequest $request)
    {
        $this->good->updateGoods($request);
        return redirect('admin/goods');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->good->destroyGoods($id);
        return redirect('admin/goods');
    }

    /**
     * 上传图片
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function uploadPic(Request $request)
    {
        $path = $request->file('pic')->store('goods');
        return response()->json(['code'=>200,'pic_path'=>'storage/'.$path]);
    }

    /**
     * 获取图片列表API
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getPicList(Request $request)
    {
        $request = $request->all();
        $pic = $this->good->find($request['gid'] , ['pic'])->toArray();
        $pic['pic'] = explode(',', $pic['pic']);
        return response()->json($pic['pic']);
    }

    /**
     * 设置商品的上架,新品等属性状态
     * @param Request $request [description]
     */
    public function setGoodsStatus(Request $request)
    {
        if ($request->kw == 'sale') {
            //上架
            if ($request->status == 1) {
                $this->good->update(['is_on_sale'=> 2] , $request->gid);
            }else{
                $this->good->update(['is_on_sale'=> 1] , $request->gid);
            }
        }elseif ($request->kw == 'new') {
            // 新品
            if ($request->status == 1) {
                $this->good->update(['is_new'=> 2] , $request->gid);
            }else{
                $this->good->update(['is_new'=> 1] , $request->gid);
            }
        }elseif ($request->kw == 'rec') {
            // 推荐
            if ($request->status == 1) {
                $this->good->update(['is_rec'=> 2] , $request->gid);
            }else{
                $this->good->update(['is_rec'=> 1] , $request->gid);
            }
        }elseif ($request->kw == 'hot'){
            // 热卖
            if ($request->status == 1) {
                $this->good->update(['is_hot'=> 2] , $request->gid);
            }else{
                $this->good->update(['is_hot'=> 1] , $request->gid);
            }
        }
        return response()->json(['code'=>200 , 'msg' => 'success']);
    }

    /**
     * 库存设置
     * @param Request $request [description]
     */
    public function setStock(Request $request)
    {
        // 跟新库存字段值
        $this->good->update(['stock' => $request->stock] , $request->id);
        return response()->json(['code' =>200 ,'msg' => 'success' ]);
    }
}
