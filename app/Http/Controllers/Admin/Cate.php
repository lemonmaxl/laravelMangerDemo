<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\CateRepository;
use App\Http\Requests\CateRequest;

class Cate extends Controller
{

    protected $cate;
    public function __construct(CateRepository $cate)
    {
        $this->cate = $cate;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 所有分类
        $cates = $this->cate->all();
        // 递归排序后的分类数组
        $cateBySort = $this->cate->sortCate($cates);
        // dd($cateBySortArr);
        return view('admin.cate.index' , ['cate' => $cateBySort]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CateRequest $request)
    {
        // 获取数据,并保存
        $res = $this->cate->create($request->all());
        if ($res) {
            flash('添加分类成功' , 'success');
        }else{
            flash('添加分类失败' , 'failed');
        }
        return redirect('admin/cates');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 获取选中Id的数据
        $cate = $this->cate->editCate($id);
        return response()->json($cate);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CateRequest $request)
    {
        $this->cate->updateCate($request);
        return redirect('admin/cates');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->cate->destroyCate($id);
        return redirect('admin/cates');
    }
}
