<?php
$proList = $GLOBALS['proList'];
$fc = $GLOBALS['fc'];
$readyList=isset($GLOBALS['readyList'])?$GLOBALS['readyList']:array();
?>

<script>
    $(document).ready(function () {
//        reflashPromotion('all');
        $(".filter").change(function () {
//            $('#temp').append('hahahaha');
            $.post('ajax_request.php', {
                filte: 1,
                made_in: $("#country option:selected").val(),
                sc_id: $("#sc_id option:selected").val()
            }, function (data) {
                $('#promotions_tbl').empty();
                $('#promotions_tbl').append('<div class="css_tr"><div class="css_td">品名</div><div class="css_td">规格名</div><div class="css_td">售价</div><div class="css_td">操作</div><div class="css_td">展示图</div></div>');
                var list = eval('(' + data + ')');
                $.each(list, function (id, value) {
                    $('#promotions_tbl').append('<div class="css_tr"><div class="css_td"><a href=index.php?goods-config=1&g_id=' + value['g_id'] + '>' + value['name'] + '</a></div><div class="css_td">'
                    + value['category'] + '</div><div class="css_td">'
                    + value['sale'] + '</div><div class="css_td">'
                    + '<a href="consle.php?start_promotions=1&g_id=' + value['g_id'] + '&d_id=' + value['d_id'] + '">开始展示</a></div></div>');
                });
            });
        });

        $('.time_filter').change(function () {
            reflashPromotion($(this).val());
        });

        $(document).on('change', '.start_time', function () {
            $.post('ajax_request.php', {
                start_time_change: 1,
                id: $(this).attr('id'),
                value: $(this).val()
            }, function (data) {
            });
        });
        $(document).on('change', '.end_time', function () {
            $.post('ajax_request.php', {end_time_change: 1, id: $(this).attr('id'), value: $(this).val()});
        });
        $(document).on('change', '.price', function () {
            $.post('ajax_request.php', {
                price_change: 1,
                id: $(this).attr('id'),
                value: $(this).val()
            }, function (data) {
            });
        });
        $(document).on('change', '.p_name', function () {
            $.post('ajax_request.php', {
                p_name_change: 1,
                id: $(this).attr('id').slice(4),
                value: $(this).val()
            }, function (data) {

            });
        })
        $(document).on('click','.start_promotions',function(){
            var g_id=$(this).attr('id').slice(3);
            var d_id=$('#did'+g_id).val();
            $.post('ajax_request.php',{start_promotions:d_id},function(data){
                if(1==data){
                    location.reload(true);
                }else{
                    showToast(data);
                }
            });
        });
        $(document).on('click', '.pro-img-upload', function () {
            var id = $(this).attr('id').slice(3);
            $('#pro-img-up' + id).click();
        });
        $(document).on('change', '.pro-img-up', function () {
            var id = $(this).attr('id').slice(10);
            $.ajaxFileUpload({
                url: 'upload.php?proImgUp=' + id,
                secureuri: false,
                fileElementId: $(this).attr('id'), //文件上传域的ID
                dataType: 'json', //返回值类型 一般设置为json
                success: function (v, status) {
                    if ('SUCCESS' == v.state) {
                        location.reload(true);
                    } else {
                        showToast(v.state);
                    }
                },//服务器成功响应处理函数
                error: function (d) {
                    alert('error');
                }
            });
        });
    });
//    function reflashPromotion(filteStr) {
//        $('#on_promotions').empty();
//        $('#on_promotions').append('<div class="css_tr"><div class="css_td">品名</div><div class="css_td">规格名</div><div class="css_td">售价</div><div class="css_td">优惠价</div><div class="css_td">开始日期</div><div class="css_td">结束日期</div><div class="css_td">操作</div><div class="css_td">展示图</div></div>');
//        $.post('ajax_request.php', {time_filter: filteStr}, function (data) {
////            alert(data);
//            var list = eval('(' + data + ')');
//            $.each(list, function (id, value) {
//                $('#on_promotions').append(
//                    '<div class="css_tr"><div class="css_td"><input class="p_name"type="text"id="name' + value['id'] + '"value="' + value['p_name'] + '"/></div><div class="css_td">' + value['category'] + '</div><div class="css_td">' + value['sale'] + '</div><div class="css_td">'
//                    + '<input class="price"id="' + value['id'] + '"value="' + value['price'] + '"></div><div class="css_td">'
//                    + '<input class="start_time"id="' + value['id'] + '" type="datetime-local"value="' + value['start_time'] + '"/></div><div class="css_td">'
//                    + '<input class="end_time"id="' + value['id'] + '" type="datetime-local"value="' + value['end_time'] + '"/></div><div class="css_td">'
//                    + '<a href="consle.php?delete_promotions=1&d_id=' + value['d_id'] + '">从首页删除</a></div><div class="css_td">'
//                    + '<a class="pro-img-upload"id="img' + value.id + '"><img class="pro-img" src="../' + value.img + '"alt="点击添加图片"></a><input type="file"class="pro-img-up"id="pro-img-up' + value.id + '"name="pro-img-up' + value.id + '"style="display: none"></div></div>'
//                );
//            });
//        });
//    }
</script>
<script src="js/ajaxfileupload.js"></script>
<section>
    <div class="page_title"><h2>首页商品</h2></div>
    <section>
        <ul class="admin_tab">
            <?php foreach ($fc as $row): ?>
                <li>
                    <a href="?dindex=1&promotions=1&f_id=<?php echo $row['id'] ?>" <?php echo $_GET['f_id'] == $row['id'] ? ' class="active"' : '' ?>><?php echo $row['name'] ?></a>
                </li>
            <?php endforeach ?>
        </ul>
    </section>
    <table class="table">
        <tr>
            <th>品名</th>
            <th>规格</th>
            <th>售价</th>
            <th>优惠价</th>
            <th>开始时间</th>
            <th>结束时间</th>
            <th>预览图</th>
            <th>操作</th>
        </tr>
        <?php foreach ($proList as $row): ?>
            <tr>
                <td style="padding: auto 0"><input class="textbox p_name" type="text" id="name<?php echo $row['id'] ?>"
                                                   value="<?php echo $row['p_name'] ?>"/></td>
                <td><?php echo $row['category'] ?></td>
                <td><?php echo number_format($row['sale'], 2, '.', '') ?></td>
                <td><input type="number" class="textbox price" id="<?php echo $row['id'] ?>"
                           value="<?php echo $row['price'] ?>"/></td>
                <td><input type="datetime-local" class="textbox start_time" id="<?php echo $row['id'] ?>"
                           value="<?php echo date("Y-m-d\TH:i:s", strtotime($row['start_time'])) ?>"/></td>
                <td><input type="datetime-local" class="textbox end_time" id="<?php echo $row['id'] ?>"
                           value="<?php echo date("Y-m-d\TH:i:s", strtotime($row['end_time'])) ?>"/></td>
                <td><a class="pro-img-upload" id="img<?php echo $row['id'] ?>"><img class="pro-img"
                                                                                    src="../<?php echo $row['img'] ?>"
                                                                                    alt="点击添加图片"></a><input type="file"
                                                                                                            class="pro-img-up"
                                                                                                            id="pro-img-up<?php echo $row['id'] ?>"
                                                                                                            name="pro-img-up<?php echo $row['id'] ?>"
                                                                                                            style="display: none">
                </td>
                <td><a class="inner_btn" href="consle.php?delete_promotions=1&d_id=<?php echo $row['id'] ?>">删除</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
    <?php if (isset($_GET['f_id'])): ?>
        <section>
            <div class="page_title">
                <h2>待选商品</h2>
            </div>
            <table class="table">
                <tr>
                    <th>品名</th>
                    <th>规格</th>
                    <th>操作</th>
                </tr>
                <?php foreach($readyList as $row):?>
                <tr>
                    <td><?php echo $row['name']?></td>
                    <td>
                        <select class="select" id="did<?php echo $row['g_id']?>">
                            <?php foreach($row['type'] as $type):?>
                                <option value="<?php echo $type['d_id']?>"><?php echo $type['name']?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                    <td><a class="inner_btn start_promotions" id="add<?php echo $row['g_id']?>">加入首页</a></td>
                </tr>
                <?php endforeach ?>
            </table>
        </section>
    <?php endif ?>
</section>

<div class="space"></div>


