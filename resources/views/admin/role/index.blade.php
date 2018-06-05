@include('layouts.iframehead')
<link href="{{ asset('css/plugins/jsTree/style.min.css') }}"" rel="stylesheet">
@inject('role' , 'App\Repositories\Presenter\RolePresenter')
<body class="gray-bg">

    <div class="wrapper wrapper-content animated fadeInRight">
        @include('flash::message')
        <div class="row">
            <div class="col-sm-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>角色列表</h5>
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
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>角色名</th>
                                        <th>角色显示名</th>
                                        <th>状态</th>
                                        <th>创建日期</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                {!! $role->getRolesList($roles) !!}
                                    
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            @permission('/admin/roles/add')
            <div class="col-sm-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>角色操作表单</h5>

                        <div class="ibox-tools">
                            <button type="button" id="loading-example-btn" class="btn btn-white btn-xs"><i class="fa fa-refresh"></i> 刷新</button>
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
                    
                        <form class="form-horizontal m-t" id="roleForm" method="post" action="{{url('admin/roles')}}">
                        {{csrf_field()}}
                            <div class="form-group">
                                <label class="col-sm-3 control-label">角色名：</label>
                                <div class="col-sm-8">
                                    <input id="name" name="name" value="{{old('name')}}" class="form-control" type="text">
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 例如:user</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">角色显示名：</label>
                                <div class="col-sm-8">
                                    <input id="display_name" name="display_name" value="{{old('display_name')}}" class="form-control" type="text" >
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 例如:普通用户</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">功能描述：</label>
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
            @endpermission
        </div>

    </div>
    
    <!-- 分配表单 -->
    <div id="assign-permiss" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" id="assignPreForm" method="post" action="{{url('admin/roles/assign')}}">
                <div class="modal-body">
                
                {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="m-t-none m-b">权限分配</h3>
                            <div class="form-group">
                                <label>角色名：</label>
                                <input type="text" name="rolename" id="rolename" value="" class="form-control" disabled="disabled">
                            </div>
                            <div class="form-group">
                                <label>权限节点：</label>
                                <div class="m-l-lg" style="height: 300px;overflow:  scroll;">
                                    <div id="using_json">
                                        {!! $role->getPermissionsInfo() !!}
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="perId" id="perId" value="">
                    <input type="hidden" name="roleId" id="roleId" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关 闭</button>
                    <button class="btn btn-primary" type="submit">提 交</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    

	@include('layouts.iframescript')
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"> </script>
    <!-- jsTree plugin javascript -->
    <script src="{{ asset('js/plugins/jsTree/jstree.min.js') }}"></script>
<script>
    $(document).ready(function () {
    	$('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        $(".editRole").on('click' , function () {
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
        				$("#roleForm").attr('action' , data.update);
        				var _method = $("#rmethod");
        				var _id = $("input[name=id]");
        				if (_method.length <1) {
        					$("#roleForm").append('<input type="hidden" id="rmethod" name="_method" value="PATCH">');
        				}
        				if (_id.length >0) {
        					_id.val(data.id);
        				}else{
        					$("#roleForm").append('<input type="hidden" name="id" value="'+data.id+'">');
        				}
        				
        			}
        			layer.msg(data.msg);
        		},
        		error:function (data) {
        			
        		}
        	});
        });

        $(".destoryRole").on('click' , function () {
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
        // 模态框
        $('#assign-permiss').on('show.bs.modal', function (e) {
            var _id = e.relatedTarget.getAttribute('data-id');
            
            $.ajax({
                type:'post',
                url:"{{url('admin/roles/get_rinfo')}}",
                data:{id:_id, _token:"{{csrf_token()}}"},
                dataType:'json',

                success:function (data) {
                    // console.log(JSON.stringify(data));
                    $("#rolename").val(data.name);
                    $("#roleId").val(data.id);
                    var instance = $('#using_json').jstree(true);
                    instance.deselect_all();
                    instance.select_node(data.pers);
                    
                },
                error:function (data) {
                    console.log(data);
                }
            });
        });
        // 权限节点树节点
        $('#using_json').jstree({
            "plugins" : ["checkbox"],
            "checkbox": 
                {
                "three_state": false,//父子级别级联选择
            },
        });
        // 树节点选中后的回调
        $('#using_json').on("changed.jstree", function (e, data) {
            $("#perId").val(data.selected);
        });
        
        $('#loading-example-btn').click(function () {
            location.reload();
        });
    });
</script>
</body>

</html>