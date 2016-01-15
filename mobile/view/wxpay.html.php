<head>
    <?php include 'templates/header.php'?>
    <link rel="stylesheet" href="stylesheet/order.css"/>
</head>
<body>
<div class="wrap">
<!--    <div class="orderComfirm">-->
<!---->
<!--        <a class="orderSettle" id="readyToPay"href="#">付款</a>-->
<!--    </div>-->
</div>
<?php include_once 'templates/jssdkIncluder.php'?>
<script>
    wx.ready(function(){
        wx.hideOptionMenu();
        wx.chooseWXPay({
            timestamp: <?php echo $preSign['timeStamp']?>,//这里是timestamp 要小写，妈的
            nonceStr: '<?php echo $preSign['nonceStr']?>',
            package: '<?php echo $preSign['package']?>',
            signType: '<?php echo $preSign['signType']?>',
            paySign: '<?php echo $preSign['paySign']?>',
            success: function (res) {
                if('get_brand_wcpay_request:ok'==res.err_msg){
                    alert('pay succes')
                }else{
                    alert('false:'+res.err_msg);
                }
                // 支付成功后的回调函数
            }
        });


    })

</script>
</body>