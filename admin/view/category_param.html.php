<section>
    <div class="page_title"><h2>参数模板设置</h2></div>
    <div id="parameter-edit"></div>
</section>
<script>
    var cateIndex = 0;
    var parInputBox = '<tr class="input-tr">' +
        '<td><input type="text"class="par-name"/></td>' +
        '<td><input type="text"class="par-dft"/>' +
        '<button class="set-par-name">确定</button></td>' +
        '</tr>';
    var sc_id='<?php echo $_GET['cate-param']?>';
    getParInf();
    function getParInf() {
        $('#parameter-edit').empty();
        $.post('ajax_request.php', {get_sc_parm: 1, sc_id: sc_id}, function (data) {
//            alert(data);
            var value = eval('(' + data + ')');
//            um.setContent(value.remark);
            $.each(value.parm, function (k, v) {
                var content = '<div class="par-category"><h3><a href="#"class="delCate">' +
                    k +
                    '</a></h3><table class="table par-table">' + '<tr><th>参数名</th><th>默认值</th><th>操作</th></tr>';
                $.each(v, function (k2, v2) {

                    var intab = '<tr><td><input class="p_alt"id="p_alt'+v2.id+'"value="' + v2.name + '"></td><td>' + v2.dft_value + '</td><td><a class="inner_btn delCate" id="del' + v2.id + '" class="delete">删除</a></td></tr>';
                    content += intab;
                });
                content += parInputBox;
                content += '</table></div>'
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
        var pmt = $(this).parents('.input-tr').find('.par-name').val();
        if ('' == pmt)return;
        var category = $(this).parents('.par-category').find('h3').text();
        var dft = $(this).siblings('.par-dft').val();

        var pareTr = $(this).parents('tr');
        $.post('ajax_request.php', {
            add_sc_parm: 1,
            sc_id: sc_id,
            name: pmt,
            par_category: category,
            dft_value: dft
        }, function (data) {
            pareTr.before('<tr><td>' + pmt + '</td><td>' + dft + '<div id="del' + data + '"class="delete"></td></tr>');
        });
    });
    $(document).on('click', '.delete', function () {
        var id = $(this).attr('id').slice(3);
        $(this).parents('tr').remove();
        $.post('ajax_request.php', {del_sc_parm: 1, id: id}, function (data) {
            $(this).parents('tr').remove();

        });

    });
    $(document).on('click', '.delCate', function () {
        var value = $(this).text();
        if (confirm('删除'+value+'这一参数分类？')) {
            $.post('ajax_request.php', {del_parm: 1,sc_id:sc_id,cate: value}, function (data) {
                getParInf();
            })
        }
    });
    $(document).on('change','.p_alt',function(){
        var id=$(this).attr('id').slice(5);
        var value=$(this).val();
        $.post('ajax_request.php',{p_alt_key:id,value:value},function(data){
            if(data=='ok'){
                showToast('已修改')
            }
        })
    })
    $(document).on('click','.remark-button',function(){
        if(sc_id!=null){
            var remark=$('#uInput').html();
            $.post('ajax_request.php',{cateRemark:1,content:remark,sc_id:sc_id},function(data){
                showToast('修改成功')
            });
        }
    });
    $('#sc_id').change(function () {
        sc_id = $("#sc_id option:selected").val();
        getParInf();
        $('.cate-button').css('display', 'block');
        $('.remark-edit').css('display','block');
    });
    $('#manage_sc_id').change(function(){
        var config_id = $("#manage_sc_id option:selected").val();
        $.post('ajax_request.php',{getConfigCate:1,sc_id:config_id},function(data){
            var inf=eval('('+data+')');
            $('#config-cate-name').val(inf.name);
            $('#config-cate-e-name').val(inf.e_name);
            $('.cate_config').show();
        });
    });
    $('#alter_cate').click(function(){
        var alter_id = $("#manage_sc_id option:selected").val();
        var name=$('#config-cate-name').val();
        var e_name=$('#config-cate-e-name').val();
        $.post('ajax_request.php',{configCate:1,sc_id:alter_id,name:name,e_name:e_name},function(data){
//            var inf=eval('('+data+')');
            showToast('修改完成')
        })
    });





</script>