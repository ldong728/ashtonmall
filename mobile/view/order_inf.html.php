<head>
    <?php include 'templates/header.php'?>
    <link rel="stylesheet" href="stylesheet/order.css"/>
</head>
<body>
<div class="wrap">

        <script src="../js/head.js"></script>
    </header>
    <div class="orderComfirm">
    <div>
        <h1>订单信息</h1>
    </div>
    <div>
        <h5>订单号：<?php echo $orderId?></h5>
        <h6>订单状态：<?php echo getOrderStu($orderStu)?></h6>
    </div>
    <a class="orderSettle" id="wxpay"href="#">微信支付</a>
        <a class="orderSettle" id="alipay"href="#">支付宝支付</a>
    </div>

</div>
</body>

<script>
    var order_id='<?php echo $orderId?>';
    $('#wxpay').click(function(){
//        alert('send pre pay')
        $.post('pay.php',{prePay:1,order_id:order_id},function(data){
            if('ok'==data){
                window.location.href='controller.php?preOrderOK=1';
            }

        });
//        alert('please wait');
    });

    $('#alipay').click(function(){
//        alert('jump');
        window.location.href='controller.php?toalipay=1&orderId='+order_id
    });
</script>