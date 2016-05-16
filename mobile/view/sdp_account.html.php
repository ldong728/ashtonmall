<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/sdp.css?v=<?php echo rand(1000, 9999) ?>"/>
    <meta content="YES" name="apple-touch-fullscreen">
    <meta content="yes" name="apple-mobile-web-app-capable">
</head>
<body>
<div class="wrap">
    <div class="main-info">
        <div class="imgbox">
            <img src="../img/account.png">
        </div>
        <div class="title">
            我的账户
        </div>
        <div class="total_balence">
            ￥<?php echo $account['total_balence'] ?>
        </div>
        <a class="feeback-button">
            提现
        </a>

        <div class="account-record">
            <a href="controller.php?sdp=1&accRecord=1">账户明细</a>
        </div>

    </div>


</div>
<div class="hidden-layer">
    <div class="hidden-container">
        <div class="category-name">
            提现金额
        </div>
        <div class="h-slash">
        </div>
        <div class="gslist-block">
            <input type="number"id="amount"placeholder="请输入提现金额"style="
            width: 100%;
            height: 35px;
            line-height: 30px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 2px;
            border: 1px #ddd solid;
            "/>
        </div>
        <div class="gslist-block">
            <button class="button feeback-confirm">提现</button>
        </div>
        <div class="gslist-block">
            <button class="button close" style="background-color: #f13031">关闭</button>
        </div>


    </div>
    <div class="toast"></div>
</div>



<script>
    var minAmount=<?php echo $config['minAmount']?>;
    var maxAmount=<?php echo $config['maxAmount']?>;
    var total=<?php echo $account['total_balence'] ?>;
</script>

<script>

    $('.feeback-button').click(function () {
        $('.hidden-layer').fadeIn('fast');

//    alert('click');

    });
    $('.feeback-confirm').click(function(){
        var amount=$('#amount').val();
        if(amount<=total){
            if(amount<minAmount){
                showToast('最低返佣金额为￥'+minAmount);
            }else if(amount>maxAmount){
                showToast('单次返佣金额最高为￥'+maxAmount);
            }else{
                $.post('feeback.php',{feeback:1,amount:amount},function(data){

                });

            }

        }else{
            showToast('余额不足');
        }
    });
    $('.close').click(function(){
        $('.hidden-layer').fadeOut('fast');
    })
</script>
</body>