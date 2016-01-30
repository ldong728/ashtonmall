<head>
    <?php include 'templates/header.php'?>
    <link rel="stylesheet" href="stylesheet/order.css"/>
</head>
<body>
<div class="wrap">

    <div class="orderComfirm">
        <a class="address"href="controller.php?editAddress=1&from=<?php echo $from?>">
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
                                    <p>单价：<span class="cl_red">￥<?php echo $row['price']?></span></p>
                                </div>
                            </dd>
                        </dl>
                    </div>
                    <div class="partBox">
                    <?php foreach($row['parts'] as $prow):?>
                        <div class="part-block">
                        <p><?php echo $prow['part_name']?>:<?php echo $prow['part_produce_id']?></p>
                            <p>数量：<span class="red"><?php echo $prow['part_number']?></span></p>
                            <p>单价：<span class="red">￥<?php echo $prow['part_sale']?></span></p>
                        </div>
                        <div class="vslash"></div>
                    <?php endforeach;?>
                    </div>
                </li>
            <?php endforeach?>
        </ul>
        <div class="orderOther"style="margin-top: 10px">
<!--            <div class="orderMode">-->
<!--                <h3>配送方式：</h3>-->
<!--                <div class="chosen chooseOpen">默认快递</div>-->
<!--                <div class="chooseArea">-->
<!---->
<!---->
<!--                </div>-->
<!--            </div>-->
            <div class="remark">
                <div class="remark-title"><h3>用户留言：</h3></div>
                <textarea rows="2"class="remark_field"></textarea>
            </div>
        </div>
        <div class="ordertotal">
            <span class="realPay">实付款（含运费）：</span>
            <span class="payTotal">
                <span class="cl_red">￥<?php echo $totalPrice?></span>
            </span>
        </div>

        <a class="orderSettle" id="orderConfirm"href="#">订单确认</a>
    </div>
</div>
</body>
<script>
    var from ='<?php echo $from?>';
    var addrId = <?php echo $addr['id']?>
</script>
<script>
    $('.ordersettle').click(function(){
//        alert($('.remark_field').val())
        $.post('ajax.php',{userRemark:1,remark:$('.remark_field').val()},function(data){
            window.location.href='controller.php?orderConfirm=1&addrId='+addrId+'&from='+from;
        })
    });
</script>
