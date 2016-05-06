<?php
$orderinf=$GLOBALS['orderinf'];
$orderdetail=$GLOBALS['orderdetail'];
$record=$GLOBALS['record'];
$express=$GLOBALS['express'];
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
        <?php if($orderinf['stu']==1):?>
            <div class="od-tr">
                <div class="od-td">
                    <select class="select altValue" id="express_id">
                        <option value="0">选择快递</option>
                        <?php foreach($express as $erow):?>
                            <option value="<?php echo $erow['id']?>"><?php echo $erow['name']?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="od-td"><input type="tel" class="textbox altValue" id="express_order" placeholder="请输入单号"/></div>
                <div class="od-td">
                    <button class="link_btn altOrder" value="onShip">发货</button>
                </div>
            </div>
        <?php endif ?>
        <?php if($orderinf['stu']==2):?>
            <div class="od-tr">
                <div class="od-td">
                    <select class="select altValue" id="express_id">
                        <option value="0">选择快递</option>
                        <?php foreach($express as $erow):?>
                            <option value="<?php echo $erow['id']?>"<?php echo $erow['id']==$orderinf['express_id']?'selected="selected"':''?>><?php echo $erow['name']?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="od-td"><input type="tel" class="textbox altValue" id="express_order" placeholder="请输入单号" value="<?php echo $orderinf['express_order']?>"/></div>
                <div class="od-td">
                    <button class="link_btn altOrder" value="altExpress">修改快递</button>
                </div>
            </div>
        <?php endif ?>
        <?php if($orderinf['stu']==0):?>
            <div class="od-tr">
                <div class="od-td">
                    修改价格：<input type="text"class="textbox altValue" id="totalFee" value="<?php echo $orderinf['total_fee']?>"/>
                    <button class="link_btn altOrder"value="altTotalFee">修改价格</button>
                </div>
            </div>
        <?php endif ?>
    </div>
    <?php if(isset($record[1])):?>
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
    <div class="order-wrap">
        <div class="od-th">
            物流信息
        </div>
        <div class="od-tr">
            <div class="od-td">
                收件人：<?php echo $orderinf['name']?>
            </div>
            <div class="od-td">
                联系电话：<?php echo $orderinf['phone']?>
            </div>
            <div class="od-td">
                地区：<?php echo $orderinf['province'].' '.$orderinf['city'].' '.$orderinf['area']?>
            </div>
        </div>
        <div class="od-tr">
            <div class="od-td">
                详细地址：<?php echo $orderinf['address']?>
            </div>
        </div>
        <?php if($orderinf['stu']==2):?>
            <div class="od-tr">
                <div class="od-td">
                    快递名称：<?php echo $orderinf['express_name']?>
                </div>
                <div class="od-td">
                    快递单号：<?php echo $orderinf['express_order']?>
                </div>
            </div>
        <?php endif ?>
    </div>
    <div class="order-wrap">
        <div class="od-th">
            商品信息
        </div>

            <table class="table">
                <tr>
                    <th>品名</th>
                    <th>型号</th>
                    <th>规格</th>
                    <th>单价</th>
                    <th>数量</th>
                    <th>合计</th>
                </tr>
                <?php foreach($orderdetail as $row):?>
                    <tr>
                    <td><?php echo $row['name']?></td>
                    <td><?php echo $row['produce_id']?></td>
                    <td><?php echo $row['category']?></td>
                    <td><?php echo $row['price']?></td>
                    <td><?php echo $row['number']?></td>
                    <td><?php echo $row['total']?></td>
                    </tr>
                <?php endforeach?>
            </table>
    </div>
    <div class="order-wrap">
        <div class="od-th">
            操作记录
        </div>
        <?php $orderName=array(0=>'订单建立',1=>'付款',2=>'发货',3=>'完成',-1=>'修改价格')?>
        <?php foreach($record as $rrow):?>
        <div class="od-tr">
            <div class="od-td"><?php echo $rrow['event_time']?></div>
            <div class="od-td"><?php echo $orderName[$rrow['event']]?></div>
        </div>
        <?php endforeach ?>
    </div>

    <div class="space"></div>
</section>
<script>
    var orderid='<?php echo $orderinf['id']?>';
    $('.altOrder').click(function(){
        var pValue={}
        var altMode=$(this).val();
        var content=''
        if('onShip'==altMode)content="确认发货？";
        if('altExpress'==altMode)content="此操作将使顾客再次收到发货提醒，确定修改物流？";
        if('altTotalFee'==altMode)content='此操作将删除分销信息，使分销商无法获得收益，确认修改价格？';
        if(confirm(content)){
            $.each($('.altValue'),function(k,v){
                pValue[v.id]= v.value;
            });

            $.post('ajax_request.php',{altOrder:altMode,orderId:orderid,value:pValue},function(data){
                if('ok'==data){
                    showToast('完成');
                }else{
                    alert(data);
//                    alert('发生错误，请稍后再试');
                }
            });
        }
    });
</script>
