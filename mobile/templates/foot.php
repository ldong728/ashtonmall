<div class="foot">
    <a class="foot-nave no-sub"href="index.php"id="nave-home">
        首页
    </a>
    <a class="foot-nave"id="nave-category">
         商品分类
    </a>
    <a class="foot-nave no-sub"href="controller.php?getCart=1$rand=<?php echo rand(1000,9999)?>"id="nave-cart">
        购物车
    </a>
    <a class="foot-nave"id="nave-user">
        个人中心
    </a>
</div>
<div class="sub-menu foot-cate-sub"style="height: <?php echo $_SESSION['cate']['cateCount']*45?>px">
    <?php foreach($_SESSION['cate']['cateName'] as $row):?>
        <a href="controller.php?getList=1&c_id=<?php echo $row['id']?>"class="foot-cate-name"><?php echo $row['sub_name']?></a>

    <?php endforeach?>
</div>
<div class="sub-menu foot-user-sub">
    <a href="controller.php?customerInf=1"class="foot-cate-name">用户中心</a>
    <a href="#"class="foot-cate-name">我的订单</a>
    <a href="#"class="foot-cate-name">物流查询</a>
    <a href="#"class="foot-cate-name .toKf">联系客服</a>
</div>
<script>
    $('.toKf').click(function(){
//        showToast('hhh');
//        closeWindow('hhhh');
        $.post('ajax.php',{linkKf:1},function(data){

            if(0==data){
                alert('客服已接通，请关闭当前页面以便与客服交流');
            }
            if(1==data){
                alert('客服不在线或者忙碌中，请稍候再试');
            }
            if(2==data){
                alert('当前无在线客服，请稍候再试');
            }

        })

    });
    $('.no-sub').click(function() {
        $('.sub-menu').fadeOut();
    })
    $('#nave-category').click(function(){
        $('.sub-menu').fadeOut('fast',function(){
            $('.foot-cate-sub').fadeIn();
        });

    });
    $('#nave-user').click(function(){
        $('.foot-cate-sub').fadeOut('fast',function(){
            $('.foot-user-sub').fadeIn();
        });

    })
    $(document).scroll(function(){
        $('.sub-menu').fadeOut('fast')
    })

</script>


