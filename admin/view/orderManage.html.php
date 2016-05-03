<?php
$orderList = $GLOBALS['orderQuery'];
$express = $GLOBALS['expressQuery'];
$stu = $_GET['orders'];
$page = $GLOBALS['page'];
$getStr = $GLOBALS['getStr'];
?>
<section>
    <h2>
        订单列表
    </h2>
    <select class="select stuFilter">
        <option value="-1"<?php echo $stu==-1?'selected="selected"':''?>>全部订单</option>
        <option value="0"<?php echo $stu==0?'selected="selected"':''?>>未付款</option>
        <option value="1"<?php echo $stu==1?'selected="selected"':''?>>待发货</option>
        <option value="2"<?php echo $stu==2?'selected="selected"':''?>>已发货</option>
        <option value="3"<?php echo $stu==3?'selected="selected"':''?>>已成交</option>

<!--        <option value="4"--><?php //echo $stu==4?'selected="selected"':''?><!-->已成交</option>-->
<!--        <option value="5"--><?php //echo $stu==5?'selected="selected"':''?><!-->已成交</option>-->
<!--        <option value="6"--><?php //echo $stu==6?'selected="selected"':''?><!-->已成交</option>-->
<!--        <option value="7"--><?php //echo $stu==7?'selected="selected"':''?><!-->已成交</option>-->
<!--        <option value="8"--><?php //echo $stu==8?'selected="selected"':''?><!-->已成交</option>-->
        <option value="9"<?php echo $stu==9?'selected="selected"':''?>>付款中</option>
        <option value="8"<?php echo $stu==8?'selected="selected"':''?>>历史订单</option>
        <option value="7"<?php echo $stu==7?'selected="selected"':''?>>已取消</option>
    </select>
    <table class="table">
        <tr>
            <th>订单号</th>
            <th>状态</th>
            <th>创建时间</th>
            <th>总金额</th>
            <th>收货人</th>
            <th>操作</th>
        </tr>
        <?php foreach ($orderList as $row): ?>
            <tr>
                <td><?php echo $row['id'] ?></td>
                <td><?php echo getOrderStu($row['stu'])?></td>
                <td><?php echo $row['order_time'] ?></td>
                <td><?php echo $row['total_fee'] ?></td>
                <td><?php echo $row['name'] ?></td>
                <td>
                    <a href="index.php?dorder=1&orderDetail=<?php echo $row['id']?>" class="inner_btn">详情</a>
                </td>
            </tr>
        <?php endforeach ?>

    </table>
    <aside class="paging"><?php if($page>0):?><a href="index.php?<?php echo $getStr?>&page=<?php echo $page-1?>">上一页</a><?php endif ?><a href="index.php?<?php echo $getStr?>&page=<?php echo $page+1?>">下一页</a></aside>
</section>
<div class="space"></div>

<script>
$('.stuFilter').change(function(){
    var stu=$(this).val();
    window.location.href='index.php?dorder=1&orders='+stu;
})
</script>