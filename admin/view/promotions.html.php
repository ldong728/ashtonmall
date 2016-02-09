<script>
    $(document).ready(function () {
//        $('#temp').append('hahahaha');
        reflashPromotion('all');
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
                    $('#promotions_tbl').append('<div class="css_tr"><div class="css_td"><a href=index.php?goods-config=1&g_id='+value['g_id']+'>' + value['name'] + '</a></div><div class="css_td">'
                    + value['category'] + '</div><div class="css_td">'
                    + value['sale'] + '</div><div class="css_td">'
                    +'<a href="consle.php?start_promotions=1&g_id='+value['g_id']+'&d_id='+value['d_id']+'">进行促销</a></div></div>');
                });
            });
        });

        $('.time_filter').change(function(){
            reflashPromotion($(this).val());
        });

        $(document).on('change','.start_time',function(){
            $.post('ajax_request.php',{start_time_change:1,id:$(this).attr('id'),value:$(this).val()},function(data){
            });
        });
        $(document).on('change','.end_time',function(){
            $.post('ajax_request.php',{end_time_change:1,id:$(this).attr('id'),value:$(this).val()});
        });
        $(document).on('change','.price',function(){
            $.post('ajax_request.php',{price_change:1,id:$(this).attr('id'),value:$(this).val()},function(data){
            });
        });
//        $(document).on('click','.start_promotions',function(){
//            $.post('ajax_request.php',{start_promotions:$(this).attr('id')});
//
//        });


    });
    $(document).on('click','.pro-img-upload',function(){
        var id=$(this).attr('id').slice(3);
        $('#pro-img-up'+id).click();
    });
    $(document).on('change','.pro-img-up',function(){
        var id=$(this).attr('id').slice(10);
        $.ajaxFileUpload({
            url:'upload.php?proImgUp='+id,
            secureuri: false,
            fileElementId: $(this).attr('id'), //文件上传域的ID
            dataType: 'json', //返回值类型 一般设置为json
            success: function (v, status){
                if('SUCCESS'== v.state){
                }else{
                    showToast(v.state);
                }
            },//服务器成功响应处理函数
            error:function(d){
                alert('error');
            }
        });
    });
    function reflashPromotion(filteStr){
        $('#on_promotions').empty();
        $('#on_promotions').append('<div class="css_tr"><div class="css_td">品名</div><div class="css_td">规格名</div><div class="css_td">售价</div><div class="css_td">优惠价</div><div class="css_td">开始日期</div><div class="css_td">结束日期</div><div class="css_td">操作</div><div class="css_td">展示图</div></div>');
        $.post('ajax_request.php',{time_filter:filteStr},function(data){
            var list = eval('(' + data + ')');
            $.each(list,function(id,value){
                $('#on_promotions').append(
                    '<div class="css_tr"><div class="css_td"><a class="proGoodsName" href=index.php?goods-config=1&g_id='+value['id']+'>' + value['name'] + '</a></div><div class="css_td">' + value['category'] + '</div><div class="css_td">'+value['sale']+'</div><div class="css_td">'
                    +'<input class="price"id="'+value['id']+'"value="' + value['price'] + '"></div><div class="css_td">'
                    +'<input class="start_time"id="'+value['id']+'" type="datetime-local"value="'+value['start_time']+'"/></div><div class="css_td">'
                    +'<input class="end_time"id="'+value['id']+'" type="datetime-local"value="'+value['end_time']+'"/></div><div class="css_td">'
                    +'<a href="consle.php?delete_promotions=1&d_id='+value['d_id']+'">删除促销</a></div><div class="css_td">'
                    +'<a class="pro-img-upload"id="img'+value.id+'"><img class="pro-img" src="../'+ value.img+'"alt="点击添加图片"></a><input type="file"class="pro-img-up"id="pro-img-up'+value.id+'"name="pro-img-up'+value.id+'"style="display: none"></div></div>'
                );

            });
        });

    }
</script>
<script src="js/ajaxfileupload.js"></script>
<div class="module-block" id="inPromotions">
    <div class="module-title"><h4>促销列表</h4></div>
    <div>
        <input type="radio"name="time_filter" class="time_filter"value="all"checked="true"/>全部
        <input type="radio"name="time_filter" class="time_filter"value="on"/>促销中
        <input type="radio"name="time_filter" class="time_filter"value="after"/>已结束
        <input type="radio"name="time_filter" class="time_filter"value="before"/>未开始
    </div>
    <div class="css_table" id="on_promotions" border="1">

    </div>
</div>


<div id="notInPromotions">
    <h3>未促销商品</h3>

    <select class="filter" id="sc_id">
        <option value="0">分类</option>
        <?php foreach ($_SESSION['smq'] as $r): ?>
            <option value="<?php echo $r['id'] ?>"><?php htmlout($r['name']) ?></option>
        <?php endforeach; ?>
    </select>

    <select class="filter" id="country">
        <option value="none">产地</option>
        <option value="us">美国</option>
        <option value="de">德国</option>
        <option value="jp">日本</option>
    </select>

</div>



<div id="goods_table">
    <div class="css_table" id="promotions_tbl" border="1">
<!--        <div class="css_tr">-->
<!--            <div class="css_td">品名</div>-->
<!--            <div class="css_td">规格名</div>-->
<!--            <div class="css_td">售价</div>-->
<!--            <div class="css_td">优惠价</div>-->
<!--            <div class="css_td">开始日期</div>-->
<!--            <div class="css_td">结束日期</div>-->
<!--            <div class="css_td">操作</div>-->
<!--        </div>-->


    </div>

</div>