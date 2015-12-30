<head>
    <?php include 'templates/header.php' ?>
</head>

<body>
<div class="wrap">
    <div class="header">
        <div class="content">
            <div class="left-icon"></div>
            <h3 class="cate-name">厨师机</h3>
        </div>

    </div>
    <div class="content">
        <div class="main-left">
            <div class="title">
                <h3>选购目录</h3>
            </div>
            <div class="produce-list">
                <ul class="sub-category">
                    <?php foreach ($cateList as $row): ?>
                    <li class="cate-ul" id="<?php echo $row['sc_id'] ?>"><h5><?php echo $row['sc_name'] ?></h5>
                        <ul class="sub-ul" id="sub<?php echo $row['sc_id'] ?>">
                            <?php foreach ($produceList[$row['sc_id']] as $prow): ?>
                                <li><?php echo $prow['name'] ?></li>
                            <?php endforeach ?>
                        </ul>
                        <?php endforeach ?>

                </ul>

            </div>
        </div>
        <div class="v-border"></div>

        <div class="main-right">
<!--            <div class="produce-intro">-->
<!--                <div class="produce-img">-->
<!--                    <img src="../g_img/demo.jpg"/>-->
<!--                </div>-->
<!--                <div class="produce-inf name">-->
<!--                    <h3>型号</h3>-->
<!--                </div>-->
<!--                <div class="produce-inf discrib">-->
<!--                    <p>商品信息</p>-->
<!--                </div>-->
<!--                <div class="produce-inf price">-->
<!--                    <h3>RMB 1234</h3>-->
<!--                </div>-->
<!--                <a class="produce-inf buy-button"></a>-->
<!---->
<!--            </div>-->
<!---->
<!--            <div class="h-border"></div>-->

        </div>
    </div>
<?php include_once 'templates/foot.php'?>


</div>



<script>
    $(document).on('click', '.cate-ul', function () {
        var id = $(this).attr('id');
        $('.sub-ul').slideUp('slow');
        $('#sub' + id).slideDown('slow');
    })
</script>
<script>
    getProduceList(1);


    function getProduceList(sc_id){
        $('.main_right').empty();
//        $('.main_right').fadeOut('fast')
        $.post('ajax.php',{getProduceList:1,sc_id:sc_id},function(data){
            var value=eval('('+data+')');
            $.each(value,function(k,v){
                var price= v.price? v.price: v.sale;
                var content='<div class="produce-intro">'+
                    '<div class="produce-img"><img src="../'+ v.url+'"/></div>'+
                '<div class="produce-inf name"><h3>'+ v.name+'</h3></div>'+
                '<div class="produce-inf discrib"><p>'+ v.intro+'</p></div>'+
                '<div class="produce-inf price"><h3>RMB '+price+'</h3></div>'+
                '<a href="controller.php?goodsdetail=1&g_id='+ v.g_id+'" class="produce-inf buy-button"></a>' +
                    '</div>'+
                '<div class="h-border"></div>';
                $('.main-right').append(content);
                $('.main-right').fadeIn('slow');
            });
        });
    }
</script>
</body>

