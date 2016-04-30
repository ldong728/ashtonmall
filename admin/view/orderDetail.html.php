<?php
$orderinf=$GLOBALS['orderinf'];
$orderdetail=$GLOBALS['orderdetail'];
$record=$GLOBALS['record'];
?>

<link href="stylesheet/orderDetail.css" type="text/css" rel="stylesheet">
<style type="text/css">
    .order-tab{padding-bottom:20px;text-align:center;}
    .order-tab .number{line-height:28px;font-size:16px;color:#202020;}
    .order-tab .print{float:right;}
    .order-wrap{padding-bottom:10px;margin-bottom:20px;background:#FFF;border:1px solid #d8d8d8;}
    .order-wrap .od-th{padding:10px 15px;margin-bottom:10px;background:#f8f8f8;border-bottom:1px solid #d8d8d8;font-size:15px;font-weight:bold;}
    .order-wrap .od-td{display:table-cell;vertical-align:middle;padding:6px 15px;line-height:1.2;font-size:12px;}
    .order-wrap .od-td em{display:inline-block;margin:0 10px;color:#CCC;}
    .order-wrap .od-td input[type=text]{padding:0 5px 5px 5px;margin:0 5px;border:none;outline:none;border-bottom:1px dashed #d8d8d8;border-radius:0;}
    .order-wrap .od-td input.weight{padding:5px;border:1px solid #d8d8d8;}
    .order-wrap .od-title{padding-bottom:10px;margin:0 15px 10px 15px;border-bottom:1px dashed #d8d8d8;}
    .order-wrap .od-title .od-td{padding:0 0 0 10px;line-height:1.5;font-size:13px;color:#333;}
    .order-wrap .center{text-align:center;}
    .order-wrap .od-goods{margin:0 15px;}
    .order-wrap .od-goods:hover{background:#fafafa;}
    .order-wrap .od-goods .od-td{padding:5px 0 5px 10px;}
    .order-wrap .od-goods img{display:block;float:left;width:50px;height:50px;padding:5px;margin-right:20px;background:#FFF;border:1px solid #f5f5f5;}
    .order-wrap .od-goods h4{display:table-cell;width:300px;height:62px;line-height:18px;vertical-align:middle;text-align:left;}
    .order-wrap .od-event{font-family:Verdana,sans-serif;}
</style>
<section>
    <h2>
        <strong>订单详情</strong>
    </h2>
    <div class="order-tab">
        <span class="number">
            订单编号：<?php echo $orderinf['id']?>
        </span>
    </div>
    <div class="order-wrap">
        <div class="od-th">订单操作</div>
        <div class="od-tr">
            <div class="od-td">
                订单状态：
                <span style="font-size: 1.5em"><?php echo getOrderStu($orderinf['stu'])?></span>
            </div>
        </div>
        <div class="od-tr wh200">
            <div class="od-td">
                下单时间：<?php echo $orderinf['order_time']?>
            </div>
        </div>
        <div class="od-tr">
            <div class="od-td">
                用户备注：<?php echo $orderinf['remark']?>
            </div>
        </div>
        <div class="od-tr">
            <div class="od-td">
                <select class="select">
                    <option>选择快递</option>
                </select>
            </div>
            <div class="od-td">
                <button class="link_btn">发货</button>
            </div>
        </div>
    </div>
    <?php if(isset($record[1])&&$orderinf['stu']==1):?>
    <div class="order-wrap">
        <div class="od-th">
            付款信息
        </div>
        <div class="od-tr">
            <div class="od-td">
                付款方式：<?php echo $record[1]['pay_mode']==1?'微信支付':'支付宝'?>
            </div>
            <div class="od-td">
                付款时间：<?php echo $record[1]['event_time']?>
            </div>
        </div>
        <div class="od-tr">
            <div class="od-td">
                付款金额：￥<span style="font-size: 1.5em"><?php echo $orderinf['total_fee']?></span>
            </div>
        </div>
    </div>
    <?php endif ?>



</section>