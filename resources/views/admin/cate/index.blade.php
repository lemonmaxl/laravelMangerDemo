@include('layouts.iframehead')

<body class="gray-bg">
@inject('cates', 'App\Repositories\Presenter\CatePresenter')
    <div class="wrapper wrapper-content  animated fadeInRight">
    @include('flash::message')
        <div class="row">
            <div class="col-sm-4">
                <div id="nestable-menu">
                    <button type="button" data-action="expand-all" class="btn btn-white btn-sm">展开所有</button>
                    <button type="button" data-action="collapse-all" class="btn btn-white btn-sm">收起所有</button>
                </div>
            </div>
        </div>
        <div class="row">
            
            <div class="col-sm-6">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>分类管理</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            
                        </div>
                    </div>
                    <div class="ibox-content">

                        <!-- <p class="m-b-lg">
                            每个列表可以自定义标准的CSS样式。每个单元响应所以你可以给它添加其他元素来改善功能列表。
                        </p> -->

                        <div class="dd" id="nestable">
                            <ol class="dd-list">
                            
                                {!! $cates->getCateList($cate) !!}
                            </ol>
                        </div>
                        
                    </div>

                </div>
            </div>
            @permission('/admin/menus/add')
			<div class="col-sm-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>分类操作</h5>
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
                        <form class="form-horizontal m-t" id="cateForm" method="post" action="{{url('admin/cates')}}">
                        {{csrf_field()}}
                            <div class="form-group">
                                <label class="col-sm-3 control-label">分类名称：</label>
                                <div class="col-sm-8">
                                    <input id="name" name="name" value="{{old('name')}}" class="form-control" type="text">
                                    <span class="help-block m-b-none"></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">父级分类：</label>
                                <div class="col-sm-8">
                                    <select data-placeholder="选择父级分类" id="pid" name="pid" class="form-control chosen-select" tabindex="-1">
                                    <option></option>
                                        {!! $cates->getCate($cate) !!}   
                                    </select>
                                    <span class="help-block m-b-none"></span>
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

    @include('layouts.iframescript')
    
    <!-- Nestable List -->
    <script src="{{ asset('js/plugins/nestable/jquery.nestable.js') }}"></script>
    <script src="{{ asset('js/cate/cate.js') }}"></script>

    <script>
        $(document).ready(function () {
        	$('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            
            // chosen
	        $('.chosen-select').chosen({
  				no_results_text: '木有找到匹配的项！',
  				allow_single_deselect: true,
  			});
            // 更新默认值
            // $("#parent_id").val(1).trigger("chosen:updated");
            
            // activate Nestable for list 2
            $('#nestable').nestable({
            	group:1,
            	maxDepth:0
            });

            // output initial serialised data
            

            $('#nestable-menu').on('click', function (e) {
                var target = $(e.target),
                    action = target.data('action');
                if (action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }
            });
        });
    </script>
  
</body>

</html>
