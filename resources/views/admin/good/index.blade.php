@include('layouts.iframehead')
	<!-- Data Tables -->
    <link href="{{ asset('css/plugins/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
     @include('flash::message')
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>商品列表<button type="button" id="loading-btn" class="m-l-lg btn btn-white btn-xs"><i class="fa fa-refresh"></i> 刷新</button></h5>
                        
                        <div class="ibox-tools">
                            
                            @permission('/admin/goods/add')
                            <a href="{{url('admin/goods/create')}}" class="btn btn-primary btn-xs">创建商品</a>
                        	@endpermission
                            
                        </div>
                    </div>
                    <div class="ibox-content">

                        <table class="table table-striped table-bordered table-hover dataTables">
                            <thead>
                                <tr>
                                    <th class="text-center">标题</th>
                                    <th class="text-center">分类</th>
                                    <th class="text-center">编号</th>
                                    <th class="text-center">市场价</th>
                                    <th class="text-center">店铺价</th>
                                    <th class="text-center">是否上架</th>
                                    <th class="text-center">是否新品</th>
                                    <th class="text-center">是否推荐</th>
                                    <th class="text-center">是否热卖</th>
                                    <th class="text-center">创建时间</th>
                                    <th class="text-center">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($goods as $good)
                                <tr>
                                    <td class="text-center">{{$good->title}}</td>
                                    <td class="text-center">
                                    @foreach($cates as $cate)
	                                    @if($good->cateid == $cate->id)
	                                    	{{$cate->name}}
	                                    @endif
                                    @endforeach
                                    </td>
                                    <td class="text-center">{{$good->number}}</td>
                                    <td class="text-center">{{$good->markt_price}}</td>
                                    <td class="text-center">{{$good->shop_price}}</td>
                                    <td class="text-center" id="is_on_sale_{{$good->id}}">
	                                    @if($good->is_on_sale == 1)
	                                    	<a class="btn btn-success btn-rounded" onclick="setStatus('sale', {{$good->id}} , 1)" href="javascript:void(0)">是</a>
	                                    	@else
	                                    	<a class="btn btn-default btn-rounded" onclick="setStatus('sale', {{$good->id}} , 2)" href="javascript:void(0)">否</a>
	                                    @endif
                                    </td>
                                    <td class="text-center" id="is_new_{{$good->id}}">
                                    	@if($good->is_new == 1)
	                                    	<a class="btn btn-success btn-rounded" onclick="setStatus('new', {{$good->id}} , 1)" href="javascript:void(0)">是</a>
	                                    	@else
	                                    	<a class="btn btn-default btn-rounded" onclick="setStatus('new', {{$good->id}} , 2)" href="javascript:void(0)">否</a>
	                                    @endif
                                    
                                    </td>
                                    <td class="text-center" id="is_rec_{{$good->id}}">
                                    	@if($good->is_rec == 1)
	                                    	<a class="btn btn-success btn-rounded" onclick="setStatus('rec', {{$good->id}} , 1)" href="javascript:void(0)">是</a>
	                                    	@else
	                                    	<a class="btn btn-default btn-rounded" onclick="setStatus('rec', {{$good->id}} , 2)" href="javascript:void(0)">否</a>
	                                    @endif
                                    
                                    </td>
                                    <td class="text-center" id="is_hot_{{$good->id}}">
                                    	@if($good->is_hot == 1)
	                                    	<a class="btn btn-success btn-rounded" onclick="setStatus('hot', {{$good->id}} , 1)" href="javascript:void(0)">是</a>
	                                    	@else
	                                    	<a class="btn btn-default btn-rounded" onclick="setStatus('hot', {{$good->id}} , 2)" href="javascript:void(0)">否</a>
	                                    @endif
                                    
                                    </td>
                                    <td class="text-center">{{$good->created_at}}</td>
                                    <td class="text-center">
                                    	<a class="btn btn-info" href="/admin/goods/{{$good->id}}/edit">修改</a>
										<a data-id="{{$good->id}}" class="btn btn-info stockBt" href="javascript:void(0)">库存</a>
										<a data-id="{{$good->id}}" class="btn btn-info destroyBt" href="javascript:void(0)">删除<form action="/admin/goods/{{$good->id}}" method="POST" name="delete_goods{{$good->id}}" style="display:none"><input type="hidden" name="_method" value="delete"><input type="hidden" name="_token" value="{{csrf_token()}}"></form></a>
                                    </td>
                                </tr>
								@endforeach  
                            </tbody>
                            
                        </table>

                    </div>
                </div>
            </div>
        </div>
        
    </div>

    @include('layouts.iframescript')

    <!-- Data Tables -->
    <script src="{{ asset('js/plugins/dataTables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap.js') }}"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"> </script>
    
    
    <script>
        $(document).ready(function () {
            $('.dataTables').dataTable({
            	"lengthMenu": [10,15],
            	"ordering": false

            });
        });

        function setStatus(kw , gid , status) {
        	$.ajax({
        		type : 'post',
        		url : "{{url('admin/goods/setSomeThing')}}",
        		data : {
        			kw : kw,
        			gid : gid,
        			status : status,
        			_token : "{{csrf_token()}}"
        		},
        		success:function(data) {
        			//console.log(data.code);
        			if (data.code == 200) {
        				if (kw == 'sale') {
        					if (status == 1) {
        						$('#is_on_sale_'+gid).html('<a class="btn btn-default btn-rounded" onclick="setStatus('+'\'sale\','+gid+',2)" href="javascript:void(0)">否</a>');
        					}else{
        						$('#is_on_sale_'+gid).html('<a class="btn btn-success btn-rounded" onclick="setStatus('+'\'sale\','+gid+',1)" href="javascript:void(0)">是</a>');
        					}
        				}else if(kw == 'new'){
        					if (status == 1) {
        						$('#is_new_'+gid).html('<a class="btn btn-default btn-rounded" onclick="setStatus('+'\'new\','+gid+',2)" href="javascript:void(0)">否</a>');
        					}else{
        						$('#is_new_'+gid).html('<a class="btn btn-success btn-rounded" onclick="setStatus('+'\'new\','+gid+',1)" href="javascript:void(0)">是</a>');
        					}
        				}else if(kw == 'rec'){
        					if (status == 1) {
        						$('#is_rec_'+gid).html('<a class="btn btn-default btn-rounded" onclick="setStatus('+'\'rec\','+gid+',2)" href="javascript:void(0)">否</a>');
        					}else{
        						$('#is_rec_'+gid).html('<a class="btn btn-success btn-rounded" onclick="setStatus('+'\'rec\','+gid+',1)" href="javascript:void(0)">是</a>');
        					}
        				}else if(kw == 'hot'){
        					if (status == 1) {
        						$('#is_hot_'+gid).html('<a class="btn btn-default btn-rounded" onclick="setStatus('+'\'hot\','+gid+',2)" href="javascript:void(0)">否</a>');
        					}else{
        						$('#is_hot_'+gid).html('<a class="btn btn-success btn-rounded" onclick="setStatus('+'\'hot\','+gid+',1)" href="javascript:void(0)">是</a>');
        					}
        				}
        			}
        		},
        		error:function(data) {
        			
        		}
        	});
        }
       
       // 删除
			$(".destroyBt").on('click' , function () {
				var _id = $(this).attr('data-id');
				
			    swal({
					title: "您确定要删除商品信息吗",
					text: "删除后将无法恢复，请谨慎操作！",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						swal("删除成功！", {
						  	icon: "success",
						}).then((willSure)=>{
							// if (willSure) {
								$("form[name=delete_goods"+_id+"]").submit();
							// }
						});
					}
				});

			});
		$(".stockBt").on('click' , function() {
			var _id = $(this).attr('data-id');
			var url = "{{url('admin/goods')}}"+'/'+_id;
			layer.open({
				type: 2,
				title:false,
				area: ['700px', '450px'], //宽高
				content: url
			});
		});
		
		function setStockMsg() {
			layer.msg('库存修改成功');
		}
        $('#loading-btn').click(function () {
            	location.href="{{url('admin/goods')}}";
        	});
    </script>

   
</body>

</html>
