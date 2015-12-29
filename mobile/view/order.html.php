<head>
    <?php include 'templates/header.php'?>
    <link rel="stylesheet" href="stylesheet/order.css"/>
</head>
<body>
<div class="wrap">
    <header class="header">
        <a class="back" href="javascript:window.history.go(-1);"></a>
        <p class="hd_tit">订单确认</p>
        <a class="daohang"href="#"></a>
        <nav class="head_nav">
            <a class="hn_index"href="index.php">首页</a>
            <a class="hn_sort"href="controller.php?getSort=1">分类查找</a>
            <a class="hn_cart"href="controller.php?getCart=1">购物车</a>
            <a class="hn_memb"href="controller.php?customerInf=1">个人中心</a>
        </nav>
        <script src="../js/head.js"></script>
    </header>
    <div class="orderComfirm">
        <a class="address"href="controller.php?editAddress=1">
            <i class="iCar"></i>
            <div class="adInfo">
               <p><?php echo $addr['province'].'  '.$addr['city'].'   '.$addr['area']?></p>
                <p><?php echo $addr['address']?></p>
                <p><?php echo $addr['name']?><span class="recPhone"><?php echo $addr['phone']?></span></p>
            </div>
        </a>
        <ul class="odList">
            <?php foreach($goodsList as $row):?>
                <li>
                    <div class="orderBox">
                        <dl>
                            <dd>
                                <div class="op_detail">
                                    <h3>
                                        <?php echo $row['name']?>
                                    </h3>
                                    <p>规格：<?php echo $row['category']?></p>
                                    <p>数量：<span class="cl_red"><?php echo $row['number']?></span></p>
                                    <p>总价：<span class="cl_red">￥<?php echo $row['total']?></span></p>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </li>
            <?php endforeach?>
        </ul>
        <div class="orderOther"style="margin-top: 10px">
            <div class="orderMode">
                <h3>配送方式：</h3>
                <div class="chosen chooseOpen">默认快递</div>
                <div class="chooseArea">


                </div>
            </div>
        </div>
        <div class="ordertotal">
            <span class="realPay">实付款（含运费）：</span>
            <span class="payTotal">
                <span class="cl_red">￥<?php echo $totalPrice?></span>
            </span>
        </div>
        <a class="orderSettle" id="orderConfirm"href="controller.php?orderConfirm=1&addrId=<?php echo $addr['id']?>">订单确认</a>
    </div>
</div>
</body>
