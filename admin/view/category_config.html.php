<?php
$category = $GLOBALS['category'];
$smq = $_SESSION['smq'];
?>
<div class="module-block">
    <div class="module-title">
        <h4>新建主分类</h4>
    </div>
    <form action='consle.php' method="post">

        <div>
            <label for="category">名称：
                <input type="text" name="category">
            </label>
        </div>
        <div>
            <label for="remark">备注：
                <input type="text" name="remark">
            </label>
        </div>
        <div>
            <input type="submit" value="确定">
        </div>
    </form>
</div>

<div class="module-block">
    <div class="module-title">
        <h4>新建子分类</h4>
    </div>
    <form action='consle.php' method="post" class="pose">

        <div>
            <select name="father_cg_id">
                <option value="0">父类</option>
                <?php foreach ($_SESSION['mq'] as $row): ?>
                    <option value="<?php echo $row['id'] ?>"><?php htmlout($row['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <br/>

            <label for="sub_category">名称：
                <input type="text" name="sub_category">
            </label>
        </div>
        <div>
            <label for="e_name">英文名：
                <input type="text" name="e_name">
            </label>
        </div>
        <div>
            <input type="submit" value="确定">
        </div>
    </form>
</div>
<div class="module-block">
    <div class="module-title">
        <h4>分类管理</h4>
    </div>
    <select id="manage_sc_id">
        <option value="-1">选择分类</option>
        <?php foreach ($smq as $r): ?>
            <option value="<?php echo $r['id'] ?>"><?php htmlout($r['name']) ?></option>
        <?php endforeach; ?>

    </select>
    <div class="cate_config"style="display: none">
        名称：<input type="text"id="config-cate-name"placeholder="类型名">
        详细名称：<input type="text"id="config-cate-e-name"placeholder="详细名称">
        <button id="alter_cate">修改</button>
        <button id="delete_cate">删除</button>
    </div>
</div>

<div class="module-block sc-edit">
    <div class="module-title"><h4>参数模板设置</h4></div>
    <select id="sc_id">
        <option value="-1">分类</option>
        <?php foreach ($smq as $r): ?>
            <option value="<?php echo $r['id'] ?>"><?php htmlout($r['name']) ?></option>
        <?php endforeach; ?>
    </select>

    <div id="parameter-edit">


    </div>
    <div class="cate-button" style="display: none">
        <button class="add-par-cate">添加新参数类型</button>
    </div>


</div>
<div class="module-block remark-edit" style="display: none">
    <div class="module-title"><h4>售后条例</h4></div>
    <script type="text/plain" id="uInput" name="cate-remark" style="width:1000px;height:240px;">
                <p>在这里编辑</p>
                        </script>

    <button class="remark-button">提交</button>

</div>

<script>
//    var editWidth=$(document).width()*0.4;
//    var editHeight=600;
</script>
<script>
    var editWidth=$(document).width()*0.8;
    var editHeight=300;
</script>

<script type="text/javascript" charset="utf-8" src="js/cate-remark-umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../uedit/umeditor.min.js"></script>
<script type="text/javascript">
    var um = UM.getEditor('uInput');
</script>
<!--<script src="js/goodsInfEdit.js"></script>-->

<script>
    var cateIndex = 0;
    var sc_id;
    var parInputBox = '<tr class="input-tr">' +
        '<td><input type="text"class="par-name"/></td>' +
        '<td><input type="text"class="par-dft"/>' +
        '<button class="set-par-name">确定</button></td>' +
        '</tr>';
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
    $('#delete_cate').click(function(){
        var del_id= $("#manage_sc_id option:selected").val();
            $.post('ajax_request.php',{delCate:1,sc_id:del_id},function(data){
                window.location='index.php?category-config=1';
            })
    });

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
        var parinput = '<table class="par-table">' + parInputBox +
            '<table>';
        content += parinput
        parent.empty();
        parent.append(content);
    })
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
//        alert(category);
//        alert(pmt);
//        alert(dft);
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
    })

    function getParInf() {
        $('#parameter-edit').empty();
        $.post('ajax_request.php', {get_sc_parm: 1, sc_id: sc_id}, function (data) {
//            alert(data);
            var value = eval('(' + data + ')');
            um.setContent(value.remark);
            $.each(value.parm, function (k, v) {
                var content = '<div class="par-category"><h3><a href="#"class="delCate">' +
                    k +
                    '</a></h3><table class="par-table">' + '<tr><td>参数名</td><td>默认值</td></tr>';
                $.each(v, function (k2, v2) {

                    var intab = '<tr><td><input class="p_alt"id="p_alt'+v2.id+'"value="' + v2.name + '"></td><td>' + v2.dft_value + '<div id="del' + v2.id + '" class="delete"></td></tr>';
                    content += intab;
                });
                content += parInputBox;
                content += '</table></div>'
                $('#parameter-edit').append(content);

            });
        })

    }




</script>