@include('layouts.iframehead')

<link rel="stylesheet" href="{{ asset('easyUpload/easy-upload.css') }}">

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div class="page-container">
                            <div id="easyContainer"></div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>
        <div class="row" id="excelgoods" style="display: none;">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
						<div class="form-group">
                            <label>文件路径：</label>
                            <input type="text" name="excel_file_path" id="excel_file_path" value="" disabled="disabled" class="form-control">
                            <span class="help-block m-b-none"></span>
                            <button class="btn btn-primary" onclick="saveData()" id="excel_sub" type="submit">导入数据库</button>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
            
        </div>
<!-- end row -->
    </div>


    @include('layouts.iframescript')
    
    <!--  easyUpload -->
    <script type="text/javascript" src="{{ asset('easyUpload/easyUpload.js') }}"></script>
	
    <script type="text/javascript">
     $('#easyContainer').easyUpload({
			allowFileTypes: '*.xls;*.xlsx;*.csv;*.png',//允许上传文件类型，格式';*.doc;*.pdf'
			allowFileSize: 10240,//允许上传文件大小(KB)
			selectText: '选择文件',//选择文件按钮文案
			multi: false,//是否允许多文件上传
			multiNum: 5,//多文件上传时允许的文件数
			showNote: true,//是否展示文件上传说明
			note: '提示：支持格式为xls 、xlsx 、csv',//文件上传说明
			showPreview: false,//是否显示文件预览
			url: "{{url('admin/excelgoods/excel')}}",//上传文件地址
			fileName: 'excel',//文件filename配置参数
			formParam: {
				_token: "{{csrf_token()}}"
				// token: $.cookie('token_cookie')//不需要验证token时可以去掉
			},//文件filename以外的配置参数，格式：{key1:value1,key2:value2}
			timeout: 30000,//请求超时时间
			successFunc: function(res) {
				// console.log(JSON.stringify(res));
				if (res.code == 200) {
					$('#excel_file_path').val(res.excel_path);
					$('#excelgoods').show();
				}
				
			},//上传成功回调函数
			errorFunc: function(res) {
				// console.log(res);
			},//上传失败回调函数
			deleteFunc: function(res) {
				// console.log(res);
			}//删除文件回调函数
		});

     function saveData() {
     	var path = $('#excel_file_path').val();
     	$.ajax({
     		type:'post',
     		url:"{{url('admin/excelgoods/import')}}",
     		data:{_token:"{{csrf_token()}}",path:path},
     		success:function(data) {
     			$('#excel_sub').hide();
     			if (data.code == 200)
     				layer.msg('导入数据成功');
     		},
     		error:function(data) {
     			layer.msg('数据导入失败');
     		}
     	});
     }
    </script>
</body>

</html>
