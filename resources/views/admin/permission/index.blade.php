@include('layouts.iframehead')
@inject('permission' , 'App\Repositories\Presenter\permissionPresenter')
<body class="gray-bg">
@permission('/admin/permission*')
    <div class="wrapper wrapper-content animated fadeInRight">
        @include('flash::message')
        <div class="row">
            <div class="col-sm-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>权限列表</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            
                            <div class="col-sm-6" style="margin-left: 200px">
                                <div class="input-group">
                                    <input type="text" placeholder="请输入关键词" class="input-sm form-control"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary"> 搜索</button> </span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" style="height: 600px;overflow: scroll;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>权限地址</th>
                                        <th>权限名</th>
                                        <th>状态</th>
                                        <th>创建日期</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                {!! $permission->getpermissionsList($permissions) !!}
                                    
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>权限操作表单</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            
                        </div>
                    </div>
                    <div class="ibox-content">
                    @if (count($errors) > 0)
					    <div class="alert alert-danger">
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif
                    
                        <form class="form-horizontal m-t" id="permissionForm" method="post" action="{{url('admin/permissions')}}">
                        {{csrf_field()}}
                            <div class="form-group">
                                <label class="col-sm-3 control-label">权限地址：</label>
                                <div class="col-sm-8">
                                    <input id="name" name="name" value="{{old('name')}}" class="form-control" type="text">
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 例如:/admin/goods</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">权限名：</label>
                                <div class="col-sm-8">
                                    <input id="display_name" name="display_name" value="{{old('display_name')}}" class="form-control" type="text" >
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 例如:商品添加权限</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">权限描述：</label>
                                <div class="col-sm-8">
                                    <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">状态：</label>
                                <div class="col-sm-8">
                                	<div class="radio radio-inline i-checks">
	                                    <label><input type="radio" value="1" name="status" id="status1" checked>启用</label>
	                                </div>
	                                <div class="radio radio-inline i-checks">
	                                    <label><input type="radio" value="0" name="status" id="status0">禁用</label>
	                                </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-3">
                                    <button class="btn btn-primary" type="submit">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @else
	<div class="middle-box text-center animated fadeInDown">
        <h3 class="font-bold">没有权限</h3>
    </div>
    @endpermission
	@include('layouts.iframescript')
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"> </script>
<script>
    $(document).ready(function () {
    	$('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        $(".editPermission").on('click' , function () {
        	var uri = $(this).attr('data-href');
        	$.ajax({
        		url:uri,
        		dataType:'json',
        		beforeSend:function () {
        			layer.load(2);
        		},
        		success:function (data) {
        			// alert(JSON.stringify(data));
        			layer.closeAll('loading');
        			if (data.mstatus) {
        				$("#name").val(data.name);
        				$("#display_name").val(data.display_name);
        				$("#description").val(data.description);
        				if (data.status == 0) {
        					$("#status0").iCheck('check');
        					$("#status1").iCheck('uncheck');
        				}else{
        					$("#status0").iCheck('uncheck');
        					$("#status1").iCheck('check');
        				}
        				$("#permissionForm").attr('action' , data.update);
        				var _method = $("#pmethod");
        				var _id = $("input[name=id]");
        				if (_method.length <1) {
        					
        					$("#permissionForm").append('<input type="hidden" id="pmethod" name="_method" value="PATCH">');
        				}
        				
        				if (_id.length >0) {
        					_id.val(data.id);
        				}else{
        					$("#permissionForm").append('<input type="hidden" name="id" value="'+data.id+'">');
        				}
        				
        			}
        			layer.msg(data.msg);
        		},
        		error:function (data) {
        			
        		}
        	});
        });

        $(".destoryPermission").on('click' , function () {
        	var _id = $(this).attr('data-id');
        	swal({
					title: "您确定要删除这条信息吗",
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
								$("form[name=destForm"+_id+"]").submit();
							// }
						});
					}
				});
        });
        
    });
</script>
</body>

</html>
