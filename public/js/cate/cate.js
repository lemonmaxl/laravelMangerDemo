// 按钮功能
$(".createMenu").on('click' , function(e) {
    $("#method").remove();
    $("input[name=id]").remove();
    $("#menuForm").attr('action' , '/admin/cates');
    $("#menuForm input.form-control").val('');
    var pid = $(this).attr('data-pid');
    // 更新默认值
    $("#pid").val(pid).trigger("chosen:updated");
});
$(".editMenu").on('click' , function(e) {
    var uri = $(this).attr('data-href');
    //alert(uri);
    $.ajax({
        url : uri,
        dataType : 'json',
        beforeSend: function () {
            layer.load(2);
        },
        success: function(data) {
            layer.closeAll('loading');
            if (data.mstatus) {
                $("#name").val(data.name);
                
                // 顶级菜单禁止选中
                if (data.pid ==0) {
                    $("#pid option").each(function () {
                        if ($(this).val() > data.pid) {
                            $(this).attr("disabled" , 'disabled');
                        }
                    });
                    // $("#parent_id option[value='"+data.id+"']").attr("disabled" , 'disabled');
                }else{
                    $("#pid option").each(function () {
                    	if ( $(this).val() == data.id) {
                    		$(this).attr("disabled" , 'disabled');
                    	}
                            
                    });
                    // $("#parent_id option[value='"+data.parent_id+"']").removeAttr("disabled");
                }
                // 更行下拉框
                $("#pid").val(data.pid).trigger("chosen:updated");

                $('#cateForm').attr('action' , data.update);
                var _method = $("#method");
                if (_method.length < 1) {
                    $('#cateForm').append('<input type="hidden" id="method" name="_method" value="PATCH">');
                }
                var _id = $('input[name=id]');
                if (_id.length > 0) {
                    _id.val(data.id);
                }else{
                    $('#cateForm').append('<input type="hidden" name="id" value="'+data.id+'">');
                }
                
            }
            
            layer.msg(data.msg);
        },
        error: function (data) {
            alert(data);
        }

    });
});
$(".destroyMenu").on('click' , function () {
    var _id = $(this).attr('data-id');
    
    layer.confirm('<span style="color:red">危险操作,删除后将不能恢复</span>', {
        btn: ['确定','取消'] //按钮
    }, function(){
        $("form[name=delete_item"+_id+"]").submit();
    });
});