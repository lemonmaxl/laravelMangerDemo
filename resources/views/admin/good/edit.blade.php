@include('layouts.iframehead')
<link rel="stylesheet" type="text/css" href="{{ asset('css/plugins/simditor/simditor.css') }}" />
<link rel="stylesheet" href="{{ asset('easyUpload/easy-upload.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('jQueryTagsInput/jquery.tagsinput.css') }}" />
<style type="text/css">
.tabs-container .tab-pane .panel-body label{
    line-height: 34px;
}
</style>
@inject('goods', 'App\Repositories\Presenter\GoodPresenter')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>修改商品</h5>
                        <div class="ibox-tools">
                            <a href="{{url('admin/goods')}}" class="btn btn-primary btn-xs">返回上一级</a>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>
        @if (count($errors) > 0)
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif
        <div class="row m-b-lg">
            <div class="col-sm-12">
                <div class="tabs-container">

                    <div class="tabs-left">
                        <ul class="nav nav-tabs" style="width: 19%;background: #fff">
                            <li class="active"><a data-toggle="tab" href="#tab-1"> 信息</a>
                            </li>
                            <li class=""><a data-toggle="tab" href="#tab-2"> 价格</a>
                            </li>
                            <li class=""><a data-toggle="tab" href="#tab-3"> 轮播图</a>
                            </li>
                            <li class=""><a data-toggle="tab" href="#tab-4"> 标签</a>
                            </li>
                            
                        </ul>
                        
                        <form class="form-horizontal" id="editGoodForm" method="post" action="{{$good['update']}}">
                        {{csrf_field()}}
                        {{ method_field('PUT') }}
                        <div class="tab-content ">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                    	<div class="form-group">
			                                <label class="col-sm-2 control-label text-right">选择一个分类：</label>
			                                <div class="col-sm-9">
			                                    <select id="cateid" name="cateid" class="form-control chosen-select" tabindex="-1"> 
			                                     {!! $goods->getCate($cate) !!}      
			                                    </select>
			                                    <span class="help-block m-b-lg"></span>
			                                </div>
			                            </div>
									    <div class="form-group">
									        <label class="col-sm-2 control-label text-right">商品标题：</label>
									        <div class="col-sm-9">
									            <input type="text" name="title" class="form-control" value="{{$good['title']}}" placeholder="">
									            <span class="help-block m-b-lg" style="color: #888">中文按照2个字符计算，最多填写30个汉字（60个字符）。</span>

									        </div>
									    </div>
									    <div class="form-group">
									        <label class="col-sm-2 control-label text-right">短标题(选填)：</label>
									        <div class="col-sm-9">
									            <input type="text" name="short_title" class="form-control" value="{{$good['short_title']}}" placeholder="">
									            <span class="help-block m-b-lg" style="color: #888">字数限制：4-20</span>

									        </div>
									    </div>
									    <div class="form-group">
									        <label class="col-sm-2 control-label text-right">编号：</label>
									        <div class="col-sm-9">
									            <input type="text" name="number" class="form-control" value="{{$good['number']}}" placeholder="">
									            <span class="help-block m-b-lg"></span>

									        </div>
									    </div>
									    <div class="form-group">
									        <label class="col-sm-2 control-label text-right">简短说明：</label>
										    <div class="col-sm-9">
						                        <textarea class="form-control" rows="3" name="short_desc">{{$good['short_desc']}}</textarea>
						                        <span class="help-block m-b-lg"></span>
						                    </div>
										</div>
										<div class="form-group">
									        <label class="col-sm-2 control-label text-right">详情：</label>
										    <div class="col-sm-9">
						                        <textarea id="editor" name="detail" placeholder="这里输入内容" autofocus>{{$good['detail']}}</textarea>
						                    </div>
										</div>
									</div>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <div class="col-md-12">
									    <div class="form-group">
									        <label class="col-sm-2 control-label text-right">市场价：</label>
									        <div class="col-sm-9">
									            <input type="number" name="markt_price" value="{{$good['markt_price']}}" class="form-control" placeholder="">
									            <span class="help-block m-b-lg" style="color: #888"></span>

									        </div>
									    </div>
									    <div class="form-group">
									        <label class="col-sm-2 control-label text-right">本店价：</label>
									        <div class="col-sm-9">
									            <input type="number" name="shop_price" value="{{$good['shop_price']}}" class="form-control" placeholder="">
									            <span class="help-block m-b-lg" style="color: #888"></span>

									        </div>
									    </div>
									    <div class="form-group">
									        <label class="col-sm-2 control-label text-right">促销价：</label>
									        <div class="col-sm-3">
									            <input type="number" name="sale_price" value="{{$good['sale_price']}}" class="form-control" placeholder="">
									            <span class="help-block m-b-lg"></span>
									        </div>
									        <label class="col-sm-1 control-label">促销时间：</label>
	                                        <div class="col-sm-5">
	                                            <input placeholder="开始日期" name="start_time" value="{{$good['start_time']}}" class="form-control layer-date" id="start">
	                                            <input placeholder="结束日期" name="end_time" value="{{$good['end_time']}}" class="form-control layer-date" id="end">
	                                            <span class="help-block m-b-lg"></span>
	                                        </div>
									    </div>
									    
									    
									</div>
                                </div>
                            </div>
                            <div id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                    <div class="page-container">
			                            <div id="easyContainer"></div>
			                        </div>
			                        <input type="hidden" name="pic" value="{{$good['pic']}}" id="img_pic">
			                        @foreach($good['picArr'] as $pic)
										<img src="{{asset($pic)}}" width="10%">
			                        @endforeach
                                </div>
                            </div>
                            <div id="tab-4" class="tab-pane">
                                <div class="panel-body">
                                    <div class="col-md-12">
									    <div class="form-group">
									        <label class="col-sm-2 control-label text-right">标签：</label>
									        <div class="col-sm-9">
									            <input type="text" name="tags" id="tags" value="{{$good['tags']}}" class="form-control" />
									            <span class="help-block m-b-lg" style="color: #888">
									            每个标签输入完后按回车键</span>

									        </div>
									    </div>

									</div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{$good['id']}}" id="goods_id">
                            <div class="ibox-content pull-right" style="width: 80%">
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button class="btn btn-primary" type="submit">保存内容</button>
                                    
                                </div>
                            </div>
                            </div>
				            
					            
					        
                        </div>
						</form>
                    </div>

                </div>
            </div>
            
        </div>
<!-- end row -->
    </div>

    @include('layouts.iframescript')
    <!-- layerDate plugin javascript -->
    <script src="{{ asset('js/plugins/layer/laydate/laydate.js') }}"></script>
    <!-- simditor -->
    <script type="text/javascript" src="{{ asset('js/plugins/simditor/module.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/simditor/uploader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/simditor/hotkeys.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/simditor/simditor.js') }}"></script>
    <!--  easyUpload -->
    <script type="text/javascript" src="{{ asset('easyUpload/easyUpload.js') }}"></script>
	<script src="{{ asset('jQueryTagsInput/jquery.tagsinput.js') }}"></script>
    <script type="text/javascript">
    	$(document).ready(function () {
            var editor = new Simditor({
                textarea: $('#editor'),
                defaultImage: "{{ asset('img/a9.jpg') }}"
            });
        });
        
        // tags
        $('#tags').tagsInput();
    	// chosen
        $('.chosen-select').chosen({
				no_results_text: '木有找到匹配的项！',
				allow_single_deselect: true,
			});
	    // 更行下拉框
        $("#cateid").val({{$good['cateid']}}).trigger("chosen:updated");
        //日期范围限制
        var start = {
            elem: '#start',
            format: 'YYYY/MM/DD hh:mm:ss',
            min: laydate.now(), //设定最小日期为当前日期
            max: '2099-06-16 23:59:59', //最大日期
            istime: true,
            istoday: false,
            choose: function (datas) {
                end.min = datas; //开始日选好后，重置结束日的最小日期
                end.start = datas //将结束日的初始值设定为开始日
            }
        };
        var end = {
            elem: '#end',
            format: 'YYYY/MM/DD hh:mm:ss',
            min: laydate.now(),
            max: '2099-06-16 23:59:59',
            istime: true,
            istoday: false,
            choose: function (datas) {
                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };
        laydate(start);
        laydate(end);

       $('#easyContainer').easyUpload({
			allowFileTypes: '*.jpg;*.jpeg;*.png;*.gif',//允许上传文件类型，格式';*.doc;*.pdf'
			allowFileSize: 2048,//允许上传文件大小(KB)
			selectText: '选择文件',//选择文件按钮文案
			multi: true,//是否允许多文件上传
			multiNum: 5,//多文件上传时允许的文件数
			showNote: true,//是否展示文件上传说明
			note: '提示：最多上传5个文件，支持格式为jpg 、png 、jpeg 、gif',//文件上传说明
			showPreview: true,//是否显示文件预览
			url: "{{url('admin/goods/pic')}}",//上传文件地址
			fileName: 'pic',//文件filename配置参数
			formParam: {
				_token: "{{csrf_token()}}"
				// token: $.cookie('token_cookie')//不需要验证token时可以去掉
			},//文件filename以外的配置参数，格式：{key1:value1,key2:value2}
			timeout: 30000,//请求超时时间
			successFunc: function(res) {
				// JSON.stringify(res);
				var len = res.success.length;
				var img = '';
				for (var i = 0; i < len; i++) {
					img += ','+res.success[i]['pic_path'];
				}
				$('#img_pic').val(img);
				
			},//上传成功回调函数
			errorFunc: function(res) {
				console.log(res);
			},//上传失败回调函数
			deleteFunc: function(res) {
				console.log(res);
			}//删除文件回调函数
		});


    </script>
</body>

</html>
