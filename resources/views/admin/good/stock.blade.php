@include('layouts.iframehead')

<body class="gray-bg">

    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            @permission('/admin/goods/edit')
			<div class="col-sm-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>库存操作</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            
                        </div>
                    </div>

                    <div class="ibox-content">
                        <form class="form-horizontal m-t" id="stockForm">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">库存数量：</label>
                                <div class="col-sm-8">
                                    <input id="stock" name="stock" value="{{$stock['stock']}}" class="form-control" type="number">
                                    <span class="help-block m-b-none"></span>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{$stock['id']}}">
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-3">
                                    <button class="btn btn-primary" type="submit" onclick="stock_sub()">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endpermission
        </div>
    </div>

    @include('layouts.iframescript')

    <script>
    function stock_sub() {
        $('#stockForm').ajaxSubmit({
            type: 'post', // 提交方式 get/post
            url: "{{url('admin/goods/stock')}}", // 需要提交的 url
            data: {
            	_token : "{{csrf_token()}}"
            },
            success: function (data) { // data 保存提交后返回的数据，一般为 json 数据
                // 此处可对 data 作相关处理
                    // console.log(data);return false;
                // alert(JSON.stringify(data));
                if (data.code == 200) {
                	window.parent.setStockMsg();
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);

                }
            },
            error: function(data){
                alert(JSON.stringify(data));
            }

        });
    }
    </script>
  
</body>

</html>
