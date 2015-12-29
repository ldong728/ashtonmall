<head>
    <?php include 'templates/header.php'?>
    <link rel="stylesheet" href="stylesheet/cart.css"/>
    <link rel="stylesheet" href="stylesheet/swiper.3.2.0.min.css"/>
    <link rel="stylesheet" href="stylesheet/myswiper.css"/>
    <script src="../js/lazyload.js"></script>
    <script src="../js/swiper.min.js"></script>
</head>
<body>
    <div class="wrap">
        <header class="header">
                <a class="back" href="javascript:window.history.go(-1);"></a>
                <p class="hd_tit">我的购物车</p>
                <a class="daohang"href="#"></a>
                <nav class="head_nav">
                    <a class="hn_index"href="index.php">首页</a>
                    <a class="hn_sort"href="controller.php?getSort=1">分类查找</a>
                    <a class="hn_cart"href="controller.php?getCart=1">购物车</a>
                    <a class="hn_memb"href="controller.php?customerInf=1">个人中心</a>
                </nav>
            <script src="../js/head.js"></script>
        </header>
        <div class="myCart">
            <ul class="cartList">
                <?php foreach($cartlist as $row):?>
                <li id="list<?php echo $row['d_id']?>">
                    <dl class="cart_list">
                        <dd>
                            <a class="imgA"href="controller.php?goodsdetail=1&g_id=<?php echo $row['g_id']?>&d_id=<?php echo $row['d_id']?>&number=<?php echo $row['number']?>">
                                <img class="pro_img"src="../<?php echo $row['url']?>"style="width: 48px; height: 48px; border: 1px solid rgb(204, 204, 204); display: block;">
                            </a>
                            <div class="cDetail">
                                <a class="cName"href="controller.php?goodsdetail=1&g_id=<?php echo $row['g_id']?>&d_id=<?php echo $row['d_id']?>&number=<?php echo $row['number']?>"><?php echo $row['name']?></a>
                                <p>规格：<span class="cl_grey"><?php echo $row['category']?></span></p>
                                <div class="cCount">
                                    <div class="countBox">
                                        <a class="minus change-number"id="mins<?php echo $row['d_id']?>">
                                            -
                                        </a>
                                        <input class="count"id="number<?php echo $row['d_id']?>"value="<?php echo $row['number']?>"type="tel"maxlength="3">
                                        <a class="plus change-number"id="plus<?php echo $row['d_id']?>">
                                            +
                                        </a>
                                    </div>
                                    <span class="cPrice">￥</span><span class="cPrice real-price"id="price<?php echo $row['d_id']?>"><?php echo (isset($row['price'])? $row['price']:$row['sale'])?></span>

                                </div>
                            </div>
                            <a class="delete"id="<?php echo $row['d_id']?>"></a>
                        </dd>

                    </dl>
                    <p class="cart_ft">
                        总计：
                        <span class="price sub-total-price" id="<?php echo $row['d_id']?>"></span>
                    </p>
                </li>
                <?php endforeach?>
            </ul>
            <div class="fixedCartMenu">
                <div class="settleBox">
                    <p>合计：<span class="total"id="total-price"></span>
                    （未含邮费）</p>
                    <a class="settleBtn"id="buy-btn"href="controller.php?settleAccounts=1">结算</a>
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function(){
        flushPrice();
        $(document).on('click','.change-number',function(){
           var id=$(this).attr('id');
            var button=id.slice(0,4);
            var d_id=id.slice(4);
            var currentNum = parseInt($('#number'+d_id).val());
            if('mins'==button){
                if(currentNum>1){
                    currentNum--;
                }
            }else{
                currentNum++;
            }
            $('#number'+d_id).val(currentNum);
            $.post('ajax.php', {alterCart: 1, d_id: d_id, number: currentNum},function(){
                flushPrice();
            });
        });
        $(document).on('change','.count',function(){
            var d_id=$(this).attr('id').slice(6);
            $.post('ajax.php', {alterCart: 1, d_id: d_id, number: $(this).val},function(){
                flushPrice();
            });
        });
        $(document).on('click','.delete',function(){
            var d_id=$(this).attr('id');
            $.post('ajax.php',{deleteCart:1,d_id:d_id},function(data){
                $('#list'+d_id).fadeOut('slow',function(){
                    $('#list'+d_id).remove();
                    flushPrice();
                });
            });
        });
    });
    var flushPrice=function(){
        var price=0;
        $('li').each(function(){
            var subTotal=parseInt($(this).find('.real-price').text())*parseInt($(this).find('.count').val());
            $(this).find('.sub-total-price').empty();
            $(this).find('.sub-total-price').append('¥'+subTotal);
            price+=subTotal;
        });
        $('#total-price').empty();
        $('#total-price').append('¥'+price);
        if(price==0){
            $('#buy-btn').attr('onclick','return false');
        }else{
        }

    }

</script>
</body>