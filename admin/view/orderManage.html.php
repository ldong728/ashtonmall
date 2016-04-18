<?php $orderList = $GLOBALS['orderQuery'] ?>
<?php $express = $GLOBALS['expressQuery'] ?>
<?php $stu = $_GET['orders']?>

<div>
    <input type="radio" name="orderFilter" class="orderFilter" id="chk0" value="0">未付款
    <input type="radio" name="orderFilter" class="orderFilter" id="chk1" value="1">已付款
    <input type="radio" name="orderFilter" class="orderFilter" id="chk2" value="2">已发货
    <input type="radio" name="orderFilter" class="orderFilter" id="chk3" value="3">已成交

</div>

<div class="module-block orderView">
    <div class="module-title" id="name">订单</div>
    <?php foreach ($orderList as $row): ?>
        <div class="orderItem">
            <div class="order-inf" id="<?php echo $row['id'] ?>">
                <div class="order-id" id="id<?php echo $row['id'] ?>">单号：<?php echo $row['id'] ?></div>
                <div class="order-time">创建时间：<?php echo $row['order_time']?></div>
            </div>


            <div class="hiddenContent" id="hidden<?php echo $row['id'] ?>">
                <div class="info">
                    <div class="info-block address">
                        <h4>收货地址</h4>

                        <p><?php echo $row['province'] . '  ' . $row['city'] . '  ' . $row['area'] ?></p>

                        <p><?php echo $row['address'] ?></p>

                        <p>收件人：<?php echo $row['name'] ?></p>
                        <p>电话：<?php echo $row['phone']?></p>
                    </div>
                    <div class="info-block user">
                        <h4>用户信息</h4>
                        <div class="img-block">
                            <img src="<?php echo $row['headimgurl']?>">
                        </div>
                        <div class="name-block">
                            <p><?php echo $row['nickname']?></p>
                        </div>

                    </div>
                    <div class="info-block user-remark">
                        <h4>用户留言</h4>
                        <p><?php echo $row['remark']?></p>
                    </div>
                    <div class="info-block">
                        <h4>总金额</h4>
                        <p>￥<?php echo $row['total_fee'] ?></p>
                    </div>

                </div>
                <div class="orderDetail" id="content<?php echo $row['id'] ?>">


                </div>
                <form action="consle.php" method="post">
                    <select name="express"style="display: <?php echo ($stu==1||$stu==2)? 'block':'none'?>">
                        <?php foreach ($express as $expresrow): ?>
                            <option
                                value="<?php echo $expresrow['id'] ?>"<?php echo $expresrow['id'] == $row['express_id'] ? 'selected="selected"' : '' ?>>
                                <?php echo $expresrow['name'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <input type="hidden" name="filtOrder" value="<?php echo $row['id'] ?>">
                    <input name="expressNumber" type="text"
                           placeholder="输入单号"<?php echo $row['express_order'] != 0 ? 'value="' . $row['express_order'] . '"' : '' ?>style="display: <?php echo ($stu==1||$stu==2)? 'block':'none'?>">
                    <div style="display: <?php echo $stu==0? 'block':'none'?>">价格：<input name="total_fee" type="text" value="<?php echo $row['total_fee'] ?>"></div>
                    <input type="hidden" name="stu" value="2">
                    <?php if($stu==0)echo '<input type="submit" id="submit'.$row['id'].'" value="修改">'?>
                    <?php if($stu==1)echo '<input type="submit" id="submit'.$row['id'].'" value="发货">'?>
                    <?php if($stu==2)echo '<input type="submit" id="submit'.$row['id'].'" value="修改">'?>
                </form>
            </div>
        </div>


    <?php endforeach ?>


</div>
<script>
    var chkid =<?php echo $_GET['orders']?>;
    //    var id=chkid==null?chkid:1
    $('#chk' + chkid).attr('checked', 'checked');
    $('.order-inf').click(function () {
        var o_id = $(this).attr('id');
        $('.hiddenContent').slideUp('slow', function () {
            $.post('ajax_request.php', {getOrderDetail: 1, o_id: o_id}, function (data) {
                var v = eval('(' + data + ')');
                var content = '<div class="order-line"><div class="order-detail-block">型号</div><div class="order-detail-block">规格</div><div class="order-detail-block">数量</div></div>';
                $.each(v.orderInf, function (key, value) {
                    content +='<div class="order-line"><div class="order-detail-block">'+value.produce_id+'</div><div class="order-detail-block">'+value.category+'</div><div class="order-detail-block">'+ value.number+'</div></div>';
                });
                $('#content' + o_id).html(content);
                $('#hidden' + o_id).slideDown('slow');
                if (chkid == 3)$('#submit' + o_id).remove();
            });
        });
    });
    $('.orderFilter').click(function () {
        window.location.href = 'index.php?orders=' + $(this).val();
    })
</script>