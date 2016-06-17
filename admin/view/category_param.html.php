<section>
    <div class="page_title"><h2><?php echo $sc_name?>参数模板设置</h2></div>
    <section id="parameter-edit"></section>
    <section id="parmeter-add">
        <div class="page_title"><h2>新建参数</h2></div>
        <input type="text" class="textbox" id="par-cate-name" placeholder="请输入参数类型（可选）"/><button class="link_btn set-par-name" id="par-cate-btn" data-name="">新建</button>
    </section>
</section>
<div class="space"></div>
<script>
    var cateIndex = 0;

    var sc_id='<?php echo $_GET['cate-param']?>';
    getParInf();
    function getParInf() {
        $('#parameter-edit').empty();
        $.post('ajax_request.php', {get_sc_parm: 1, sc_id: sc_id}, function (data) {
            var value = eval('(' + data + ')');
//            um.setContent(value.remark);
            $.each(value.parm, function (k, v) {
                var content = '<section class="par_cate" style="margin-bottom: 10px"><table class="table par-table">' +
                    '<tr><th colspan="2">'+k+'</th><td><a class="inner_btn delCate" data-name="'+k+'">删除全部</a></td></tr>'
                    +'<tr><th>参数名</th><th>默认值</th><th>操作</th></tr>';
                $.each(v, function (k2, v2) {

                    var intab = '<tr><td><input class="textbox p_alt"id="p_alt'+v2.id+'"value="' + v2.name + '"></td><td><textarea cols="20" rows="2" class="p_dft" id="p_dft'+v2.id+'">' + v2.dft_value + '</textarea></td><td><a class="inner_btn delete" id="del' + v2.id + '">删除</a></td></tr>';
                    content += intab;
                });
                var parInputBox = '<tr class="input-tr">' +
                    '<td colspan="3"><a class="inner_btn set-par-name" data-name="'+k+'">添加参数</a></td>' +
                    '</tr>';
                content += parInputBox;
                content += '</table></section>';
                $('#parameter-edit').append(content);

            });
        })
    }
</script>
<script>
    $('.add-par-cate').click(function () {
        var newCate =
                '<div class="par-category">' +
                '参数类型名：<input id="cate-name" type="text"/>' +
                '<button class="set-cat-name">确定</button>' +
                '</div>'
            ;
        $('#parameter-edit').append(newCate);
    });
    $(document).on('click', '.set-cat-name', function () {
        var parent = $(this).parent();
        var cateName = $('#cate-name').val();
        var content = '';
        var content = '<h3 class="par-cate"><a href="#"class="delCate">' + cateName + '</a></h3>';
        var parinput = '<table class="table par-table">' + parInputBox +
            '<table>';
        content += parinput;
        parent.empty();
        parent.append(content);
    });
    $(document).on('click', '.set-par-name', function () {
        var pmt = '新建参数'
        var category = $(this).data('name');
        var dft = '';
//        var pareTr = $(this).parents('tr');
        loading();
        $.post('ajax_request.php', {
            add_sc_parm: 1,
            sc_id: sc_id,
            name: pmt,
            par_category: category,
            dft_value: dft
        }, function (data) {
            stopLoading();
            location.reload(true);
//            pareTr.before('<tr><td><input' + pmt + '</td><td>' + dft + '<div id="del' + data + '"class="delete"></td></tr>');
        });
    });
    $(document).on('click', '.delete', function () {
        var id = $(this).attr('id').slice(3);
//        $(this).parents('tr').remove();
        loading();
        $.post('ajax_request.php', {del_sc_parm: 1, id: id}, function (data) {
            stopLoading();
            location.reload(true);
        });

    });
    $(document).on('click', '.delCate', function () {
        var value = $(this).data('name');
        if(value!=''){
            if (confirm('删除'+value+'这一参数分类？')) {
                loading()
                $.post('ajax_request.php', {del_parm: 1,sc_id:sc_id,cate: value}, function (data) {
                    stopLoading();
                    getParInf();
                })
            }
        }else{
            alert('请逐个删除表中的参数');
        }

    });
    $(document).on('change','.p_alt',function(){
        var id=$(this).attr('id').slice(5);
        var value=$(this).val();
        loading();
        $.post('ajax_request.php',{p_alt_key:id,value:value},function(data){
            stopLoading();
            if(data=='ok'){
                showToast('已修改')
            }
        })
    });
    $(document).on('change','.p_dft',function(){
        var id=$(this).attr('id').slice(5);
        var value=$(this).val();
        loading();
        $.post('ajax_request.php',{p_alt_dft:id,value:value},function(data){
            stopLoading();
            if(data=='ok'){
                showToast('已修改')
            }
        })
    });
    $(document).on('change','#par-cate-name',function(){
        $('#par-cate-btn').data('name',$(this).val());
    });
//    $(document).on('click','.remark-button',function(){
//        if(sc_id!=null){
//            var remark=$('#uInput').html();
//            $.post('ajax_request.php',{cateRemark:1,content:remark,sc_id:sc_id},function(data){
//                showToast('修改成功')
//            });
//        }
//    });
//    $('#sc_id').change(function () {
//        sc_id = $("#sc_id option:selected").val();
//        getParInf();
//        $('.cate-button').css('display', 'block');
//        $('.remark-edit').css('display','block');
//    });
//    $('#manage_sc_id').change(function(){
//        var config_id = $("#manage_sc_id option:selected").val();
//        $.post('ajax_request.php',{getConfigCate:1,sc_id:config_id},function(data){
//            var inf=eval('('+data+')');
//            $('#config-cate-name').val(inf.name);
//            $('#config-cate-e-name').val(inf.e_name);
//            $('.cate_config').show();
//        });
//    });
//    $('#alter_cate').click(function(){
//        var alter_id = $("#manage_sc_id option:selected").val();
//        var name=$('#config-cate-name').val();
//        var e_name=$('#config-cate-e-name').val();
//        $.post('ajax_request.php',{configCate:1,sc_id:alter_id,name:name,e_name:e_name},function(data){
//            showToast('修改完成')
//        })
//    });





</script>