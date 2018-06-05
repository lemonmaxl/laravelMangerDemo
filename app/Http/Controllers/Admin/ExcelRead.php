<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelRead extends Controller
{
    public function index()
    {
        return view('admin.excel.index');
    }


    public function import(Request $request)
    {
        $inputFileType = 'Xls'; //确定文件类型
        // //    $inputFileType = 'Xlsx';
        // //    $inputFileType = 'Xml';
        // //    $inputFileType = 'Ods';
        // //    $inputFileType = 'Slk';
        // //    $inputFileType = 'Gnumeric';
        // //    $inputFileType = 'Csv';
        $inputFileName = $request->path;//文件地址
        $reader = IOFactory::createReader($inputFileType);// 创建对应类型的阅读器
        $reader->setReadDataOnly(TRUE); // 设置阅读器只读取表格中的数据
        $spreadsheet = $reader->load($inputFileName); // 读取文件
        
        $dataArray = $spreadsheet->getActiveSheet()->toArray();
        // dd($dataArray);
    
        foreach ($dataArray[0] as $kk => $vv) {
            foreach ($dataArray as $k => $v) {
                $data[$k][$vv] = $v[$kk];
            }
        }
        array_shift($data);
        foreach ($data as $k => $v) {
            $goods['cate'] = 'T-shirt';
            $goods['title'] = $v['商品名称'];
            $goods['pic_url'] = $v['商品主图'];
            $goods['price'] = $v['商品价格'];
            $goods['rate'] = $v['收入比率(%)'];
            $goods['link_tui'] = $v['推广链接'];
            DB::table('excel_goods')->insert($goods);
        }
        return response()->json(['code'=>200 , 'msg'=>'success']);

    }


    public function uploadExcel(Request $request)
    {
        $path = $request->file('excel')->storeAs('excel' , time().'.xls');
        return response()->json(['code'=>200,'excel_path'=>public_path('storage/'.$path)]);
    }
    
}
