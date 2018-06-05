@include('layouts.iframehead')
<link href="{{ asset('css/plugins/multiselect/multi-select.css') }}" rel="stylesheet">
@inject('manager' , 'App\Repositories\Presenter\ManagerPresenter')
<body class="gray-bg">

    <div class="wrapper wrapper-content animated fadeInUp">
    	@include('flash::message')
        <div class="row">
            <div class="col-sm-12">

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>管理员列表</h5>
                        <div class="ibox-tools">
                        @permission('/admin/managers/add')
                            <a data-toggle="modal" href="{{url('admin/managers')}}#modal-form" class="btn btn-primary btn-xs">创建管理员</a>
                        @endpermission
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row m-b-sm m-t-sm">
                            <div class="col-md-1">
                                <button type="button" id="loading-example-btn" class="btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
                            </div>
                            <div class="col-md-11">
                            	<form method="get" action="{{url('admin/managers')}}">
                                <div class="input-group">
                                    <input type="text" name="kw" placeholder="请输入管理员名" value="{{$kw}}" class="input-sm form-control"> 
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-primary"> 搜索</button> 
                                    </span>
                                </div>
                                </form>
                            </div>
                        </div>

                        <div class="project-list">

                            <table class="table table-hover">
                                <tbody>
                                	{!! $manager->getManagersList($managers) !!}

                                </tbody>
                            </table>
							{{$managers->appends(['kw' => $kw])->links()}}
                            </div>
                              
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- 表单 -->
		<div id="modal-form" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            	<form role="form" id="managerForm">
                <div class="modal-body">
                {{csrf_field()}}
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="m-t-none m-b">创建管理员</h3>
                            
							<div class="form-group">
                                <label>用户名：</label>
                                <input type="text" name="name" id="name" placeholder="请输入用户名" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>昵称：</label>
                                <input type="text" name="username" id="username" placeholder="请输入昵称" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>E-Mail：</label>
                                <input type="email" name="email" id="email" placeholder="请输入可用的邮箱" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>密码：</label>
                                <input type="password" name="password" id="password" placeholder="请输入密码" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>状态：</label>
                                <div class="m-l-lg">
                                	<div class="radio radio-inline i-checks">
	                                    <label><input type="radio" value="1" name="status" checked>启用</label>
	                                </div>
	                                <div class="radio radio-inline i-checks">
	                                    <label><input type="radio" value="0" name="status">禁用</label>
	                                </div>
                                </div>
                            </div>  
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">关 闭</button>
			        <button class="btn btn-primary" type="submit">提 交</button>
		      	</div>
		      	</form>
            </div>
        </div>
    </div>
    <!-- 表单 -->
	<div id="edit-form" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            	<form role="form" id="editForm" data-action="">
                <div class="modal-body">
                
                {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="m-t-none m-b">编辑管理员</h3>
                            
							<div class="form-group">
                                <label>用户名：</label>
                                <input type="text" name="editname" id="editname" value="" placeholder="请输入用户名" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>昵称：</label>
                                <input type="text" name="editusername" id="editusername" value="" placeholder="请输入昵称" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>E-Mail：</label>
                                <input type="email" name="editemail" id="editemail" value="" placeholder="请输入可用的邮箱" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label>状态：</label>
                                <div class="m-l-lg">
                                	<div class="radio radio-inline i-checks">
	                                    <label><input type="radio" value="1" name="editstatus" checked>启用</label>
	                                </div>
	                                <div class="radio radio-inline i-checks">
	                                    <label><input type="radio" value="0" name="editstatus">禁用</label>
	                                </div>
                                </div>
                            </div>  
                        </div>
                    </div>
					<input type="hidden" name="id" id="editid" value="">
                </div>
                <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">关 闭</button>
			        <button class="btn btn-primary" type="submit">提 交</button>
		      	</div>
		      	</form>
            </div>
        </div>
    </div>
    <!-- 分配表单 -->
	<div id="assign-role" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            	<form role="form" id="assignForm" method="post" action="{{url('admin/managers/assign')}}">
                <div class="modal-body">
                
                {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="m-t-none m-b">管理员分配角色</h3>
                            <div class="form-group">
                                <label>用户名：</label>
                                <input type="text" name="managername" id="managername" value="" class="form-control" disabled="disabled">
                            </div>
                            <div class="form-group">
                            	<label>角色名：</label>
                            	<div class="m-l-lg">
	                            <select class="form-control" multiple="multiple" id="seltectRole" name="roleIds[]">
									
							      
							    </select>
							    </div>	
							</div>
                        </div>
                    </div>
					<input type="hidden" name="managerId" id="managerId" value="">
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
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('js/plugins/validate/messages_zh.min.js')}}"></script>
    <script src="{{ asset('js/plugins/multiselect/jquery.multi-select.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"> </script>
    <script>
        $(document).ready(function(){
        	$('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        	$("#managerForm").validate({
		  		rules: {
			      
					name: {
					required: true,
					minlength: 5
					},
					username: {
					required: true,
					minlength: 5
					},
					email: {
					required: true,
					email:true
					},
					password: {
					required: true,
					minlength: 6,
					maxlength: 20
					},
			    },
			    messages: {
			      
					name: {
					required: "请输入用户名",
					minlength: "用户名大于5个字符"
					},
					username: {
					required: "请输入昵称",
					minlength: "昵称大于5个字符"
					},
					email: {
					required: "请输入可用的邮箱",
					},
					password: {
					required: "请输入密码",
					minlength: "密码长度不能小于 6 个字符",
					maxlength: "密码长度不能超过 20 个字符",
					},
					
			    },
			    
			    onfocusout:false,
			    onkeyup:false,
			    //单条校验失败，后会调用此方法，在此方法中，编写错误消息如何显示 及  校验失败回调方法
			    showErrors : function(errorMap, errorList) {
			        // 遍历错误列表
			        // console.log(errorMap);
			        for(var obj in errorMap) {
			            // 自定义错误提示效果
			            layer.tips(errorMap[obj], '#'+obj , { time:1500, tipsMore: true});   
			        }
			        // 此处注意，一定要调用默认方法，这样保证提示消息的默认效果
			        // this.defaultShowErrors();
			    },
			    submitHandler:function(form) {
			    	
		        	$(form).ajaxSubmit({
		        		type: 'POST', // 提交方式 get/post
		                url: "{{url('admin/managers')}}", // 需要提交的 url
		                
		                success: function (data) {
		                	location.reload();
		                },
		                error: function(data){
		                    var json =JSON.parse(data.responseText);
		                    console.log(json);
		                    // var errors = json.errors;
		                    // for(var obj in errors){
		                    // 	layer.tips(errors[obj], '#'+obj , { time:1500, tipsMore: true});
		                    // }
		                }
		        	});
		    	}

		    });
		    $("#editForm").validate({
		  		rules: {
			      
					editname: {
					required: true,
					minlength: 5
					},
					editusername: {
					required: true,
					minlength: 2
					},
					editemail: {
					required: true,
					email:true
					},
					
			    },
			    messages: {
			      
					editname: {
					required: "请输入用户名",
					minlength: "用户名大于5个字符"
					},
					editusername: {
					required: "请输入昵称",
					minlength: "昵称大于5个字符"
					},
					editemail: {
					required: "请输入可用的邮箱",
					},
					
			    },
			    
			    onfocusout:false,
			    onkeyup:false,
			    //单条校验失败，后会调用此方法，在此方法中，编写错误消息如何显示 及  校验失败回调方法
			    showErrors : function(errorMap, errorList) {
			        // 遍历错误列表
			        // console.log(errorMap);
			        for(var obj in errorMap) {
			            // 自定义错误提示效果
			            layer.tips(errorMap[obj], '#'+obj , { time:1500, tipsMore: true});   
			        }
			        // 此处注意，一定要调用默认方法，这样保证提示消息的默认效果
			        // this.defaultShowErrors();
			    },
			    submitHandler:function(form) {
			    	var url = $("#editForm").attr('data-action');
			    	
		        	$(form).ajaxSubmit({
		        		type: 'POST', // 提交方式 get/post
		                url: url, // 需要提交的 url
		                data:{_token:"{{csrf_token()}}"},
		                success: function (data) {
		                	// alert(JSON.stringify(data));
		                	if (data.mstatus) {
		                		location.reload();
		                	}
		                },
		                error: function(data){
		                    // alert(JSON.stringify(data));
		                    var json =JSON.parse(data.responseText);
		                    var errors = json.errors;
		                    for(var obj in errors){
		                    	layer.tips(errors[obj], '#'+obj , {tipsMore: true});
		                    }
		                }
		        	});
		    	}

		    });
        	// 模态框隐藏后触发
        	$('#modal-form').on('hidden.bs.modal', function (e) {
				$("#name").val('');
				$("#username").val('');
				$("#email").val('');
				$("#password").val('');
			});
        	// 修改模态框
        	$('#edit-form').on('show.bs.modal', function (e) {
				var link = e.relatedTarget.href;
				var uri = link.split("#")[0];
				
				$.ajax({
					url:uri,
					dataType:'json',
					success:function (data) {
						// console.log(JSON.stringify(data));
						$("#editname").val(data.name);
						$("#editusername").val(data.username);
						$("#editemail").val(data.email);
						$("#editid").val(data.id);
						$("#editForm").attr('data-action' , data.update);
						if (data.status == 0) {
							$("input[name=editstatus]:eq(0)").iCheck('uncheck');
                    		$("input[name=editstatus]:eq(1)").iCheck('check');
						}else{
							$("input[name=editstatus]:eq(0)").iCheck('check');
                    		$("input[name=editstatus]:eq(1)").iCheck('uncheck');
						}
					},
					error:function (data) {
						console.log(data);
					}
				});
			});
			// 删除
			$(".destroyBt").on('click' , function () {
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
								$("form[name=delete_item"+_id+"]").submit();
							// }
						});
					}
				});

			});

			// 分配模态框
        	$('#assign-role').on('show.bs.modal', function (e) {
				var _id = e.relatedTarget.getAttribute('data-id');
				
				$.ajax({
					type:'post',
					url:"{{url('admin/managers/get_minfo')}}",
					data:{id:_id, _token:"{{csrf_token()}}"},
					dataType:'json',

					success:function (data) {
						// console.log(JSON.stringify(data));
						$("#managername").val(data.name);
						$("#managerId").val(data.id);
						$("#seltectRole").append(data.optionHtml);
						//  加载option后初始化
						$('#seltectRole').multiSelect();
						
					},
					error:function (data) {
						console.log(data);
					}
				});
			});
        	// 分配模态框隐藏后触发
        	$('#assign-role').on('hidden.bs.modal', function (e) {
        		// 清空option
				$("#seltectRole").empty();
				// 取消所有的选择
				$('#seltectRole').multiSelect('deselect_all');
			});
            $('#loading-example-btn').click(function () {
                location.href="{{url('admin/managers')}}";
            });

            
        });

        
    </script>

    

    </body>
</html>
