<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css?v=4.4.0') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>
        if (window.top !== window.self) {
            window.top.location = window.location;
        }
    </script>

</head>

<body class="signin">
    <div class="signinpanel">
        <div class="row">
            <div class="col-sm-7">
                <div class="signin-info">
                    <div class="logopanel m-b">
                        <h1>[ H+ ]</h1>
                    </div>
                    <div class="m-b"></div>
                    <h4>欢迎使用 <strong>H+ 后台主题UI框架</strong></h4>
                    <ul class="m-b">
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势一</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势二</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势三</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势四</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势五</li>
                    </ul>
                    
                    <!-- <strong>还没有账号？ <a href="#">立即注册&raquo;</a></strong> -->
                </div>
            </div>
            <div class="col-sm-5">
                <form  class="form-horizontal" id="amdin-login">
                
                    <h4 class="no-margins">登录：</h4>
                    
                    <p class="m-t-md">H+是一个很棒的后台UI框架</p>
                    
                    
                    <input type="text" name="username" class="form-control uname" id="username" placeholder="用户名" />
                    <input type="password" name="password" class="form-control pword m-b" id="password" placeholder="密码" />
                    <input type="text" name="captcha" class="form-control captch m-b" id="captcha" style="width: 40%" placeholder="验证码" />
                    
                    <span>
                        <img style="position: absolute;left: 48%;top: 57%;" class="" src="{{captcha_src()}}" onclick="this.src='{{captcha_src()}}'+Math.random()">
                    </span>
                    
                    
                    <a href="{{url('/password/reset')}}">忘记密码了？</a>
                    <button class="btn btn-success btn-block">登录</button>
                    <!-- <input type="submit" class="btn btn-success btn-block" value="登录"> -->
                </form>
            </div>
        </div>
        <div class="signup-footer">
            <div class="pull-left">
                &copy; 2015 All Rights Reserved. H+
            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery.min.js?v=2.1.4') }}"></script>
    <script src="{{ asset('js/jquery.form.js') }}"></script>
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('js/plugins/validate/messages_zh.min.js')}}"></script>
    <script src="{{ asset('js/plugins/layer/layer.min.js') }}"></script>
</body>
</html>
<script type="text/javascript">
$(function() {
// 在键盘按下并释放及提交后验证提交表单
	
  	$("#amdin-login").validate({
  		rules: {
	      
			username: {
			required: true,
			minlength: 2
			},
			password: {
			required: true,
			minlength: 6
			},
			captcha: {
			required: true,
			minlength: 4,
			maxlength: 4
			},
	    },
	    messages: {
	      
			username: {
			required: "请输入用户名",
			minlength: "用户名大于两个字符"
			},
			password: {
			required: "请输入密码",
			minlength: "密码长度不能小于 6 个字符"
			},
			captcha: {
			required: "请输入验证码",
			minlength: "验证码长度为4个字符",
			maxlength: "验证码长度为4个字符"
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
	            layer.tips(errorMap[obj], '#'+obj , {tipsMore: true});   
	        }
	        // 此处注意，一定要调用默认方法，这样保证提示消息的默认效果
	        // this.defaultShowErrors();
	    },
	    submitHandler:function(form) {
	    	
        	$(form).ajaxSubmit({
        		type: 'POST', // 提交方式 get/post
                url: "{{url('admin/sign_in')}}", // 需要提交的 url
                data: {	
                },
                headers: {
        			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    			},
                success: function (data) { // data 保存提交后返回的数据，一般为 json 数据
                    // 此处可对 data 作相关处理
                        // console.log(data);return false;
                    // alert(JSON.stringify(data));
                    if (data.status == 0) {
                    	// layer.msg(data.msg);
                    	var index = layer.load();
                    	setTimeout(function() {
                    		location.href = "{{url('admin/index')}}";
                    	} , 1000);
                    }else{
                    	layer.msg(data.msg);
                    }

                },
                error: function(data){
                    var json =JSON.parse(data.responseText);
                    var errors = json.errors;
                    for(var obj in errors){
                    	layer.tips(errors[obj], '#'+obj , {tipsMore: true});
                    }
                }
        	});
    	}

    })
});
</script>