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
            <label for="sub_remark">备注：
                <input type="text" name="sub_remark">
            </label>
        </div>
        <div>
            <input type="submit" value="确定">
        </div>
    </form>
</div>
<div id="temp">

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
        var content = '<h3 class="par-cate">' + cateName + '</h3>';
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
            pareTr.before('<tr><td>' + pmt + '</td><td>' + dft + '<div id="del'+data+'"class="delete"></td></tr>');
        });
//        alert(category);
//        alert(pmt);
//        alert(dft);
    });
    $(document).on('click','.delete',function(){
        var id=$(this).attr('id').slice(3);
        $(this).parents('tr').remove();
        $.post('ajax_request.php',{del_sc_parm:1,id:id},function(data){
            $(this).parents('tr').remove();
        });

    });

    function getParInf() {
        $('#parameter-edit').empty();
        $.post('ajax_request.php', {get_sc_parm: 1, sc_id: sc_id}, function (data) {
//            alert(data);
            var value = eval('(' + data + ')');
            $.each(value, function (k, v) {
                var content = '<div class="par-category"><h3>' +
                    k +
                    '</h3><table class="par-table">' + '<tr><td>参数名</td><td>默认值</td></tr>';
                $.each(v, function (k2, v2) {

                    var intab = '<tr><td>' + v2.name + '</td><td>' + v2.dft_value + '<div id="del'+v2.id+'" class="delete"></td></tr>';
                    content += intab;
                });
                content += parInputBox;
                content += '</table></div>'
                $('#parameter-edit').append(content);

            });
        })

    }

    $('input').attr('onkeypress', "if(event.keyCode == 13) return false;");


</script>