// 按钮功能
$(".createMenu").on('click' , function(e) {
    $("#method").remove();
    $("input[name=id]").remove();
    $("#menuForm").attr('action' , '/admin/menus');
    $("#menuForm input.form-control").val('');
    var pid = $(this).attr('data-pid');
    // 更新默认值
    $("#parent_id").val(pid).trigger("chosen:updated");
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
                $("#icon").val(data.icon);
                // 顶级菜单禁止选中
                if (data.parent_id ==0) {
                    $("#parent_id option").each(function () {
                        if ($(this).val() == data.id) {
                            $(this).attr("disabled" , 'disabled');
                        }else{
                            $(this).removeAttr("disabled");
                        }
                    });
                    // $("#parent_id option[value='"+data.id+"']").attr("disabled" , 'disabled');
                }else{
                    $("#parent_id option").each(function () {
                        $(this).removeAttr("disabled");    
                    });
                    // $("#parent_id option[value='"+data.parent_id+"']").removeAttr("disabled");
                }
                // 更行下拉框
                $("#parent_id").val(data.parent_id).trigger("chosen:updated");

                $("#url").val(data.url);
                $("#sort").val(data.sort);
                if (data.status == 0) {
                    $("input[name=status]:eq(0)").iCheck('uncheck');
                    $("input[name=status]:eq(1)").iCheck('check');
                }else{
                    $("input[name=status]:eq(0)").iCheck('check');
                    $("input[name=status]:eq(1)").iCheck('uncheck');
                }
                $('#menuForm').attr('action' , data.update);
                var _method = $("#method");
                if (_method.length < 1) {
                    $('#menuForm').append('<input type="hidden" id="method" name="_method" value="PATCH">');
                }
                var _id = $('input[name=id]');
                if (_id.length > 0) {
                    _id.val(data.id);
                }else{
                    $('#menuForm').append('<input type="hidden" name="id" value="'+data.id+'">');
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