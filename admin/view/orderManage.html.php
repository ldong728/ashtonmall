<?php $orderList=$GLOBALS['orderQuery']?>
<?php $express=$GLOBALS['expressQuery']?>

<div>
 <input type="radio"name="orderFilter"class="orderFilter"id="chk0"value="0">未付款
    <input type="radio"name="orderFilter"class="orderFilter"id="chk1"value="1">已付款
    <input type="radio"name="orderFilter"class="orderFilter"id="chk2"value="2">已发货
    <input type="radio"name="orderFilter"class="orderFilter"id="chk3"value="3">已成交

</div>

<div class="module-block orderView">
    <div class="module-title"id="name">订单</div>
<?php foreach ($orderList as $row):?>
    <div class="orderItem">
        <form action="consle.php"method="post">
            <div class="orderNumber"id="<?php echo $row['id']?>">单号：<?php echo $row['id']?></div>
            <div class="hiddenContent"id="hidden<?php echo $row['id']?>">
                <div class="orderDetail"id="content<?php echo $row['id']?>">


                </div>
                <div class="address">
                    <h4>收货地址</h4>
                    <p><?php echo $row['province'].'  '.$row['city'].'  '.$row['area']?></p>
                    <p><?php echo $row['address']?></p>
                    <p><?php echo $row['name'].'  '.$row['phone']?></p>
                </div>
                <select name="express">
                    <?php foreach($express as $expresrow):?>
                    <option value="<?php echo $expresrow['id']?>"<?php echo $expresrow['id']==$row['express_id']?'selected="selected"':''?>>
                        <?php echo $expresrow['name']?>
                    </option>
                    <?php endforeach?>
                </select>
                <input type="hidden"name="filtOrder"value="<?php echo $row['id']?>">
                <input name="expressNumber"type="text"placeholder="输入单号"<?php echo $row['express_order']!=0?'value="'.$row['express_order'].'"':''?>>
                <input type="hidden" name="stu"value="2">
                <input type="submit"id="submit<?php echo $row['id']?>"value="发货/修改">
            </div>

        </form>
    </div>


<?php endforeach?>


</div>
<script>
    var chkid=<?php echo $_GET['orders']?>;
//    var id=chkid==null?chkid:1
    $('#chk'+chkid).attr('checked','checked');
    $('.orderNumber').click(function(){
        var o_id=$(this).attr('id');
        $('.hiddenContent').slideUp('slow',function(){
            $.post('ajax_request.php',{getOrderDetail:1,o_id:o_id},function(data){
                var v=eval('('+data+')');
                $('#content'+o_id).empty();
                $.each(v,function(key,value){
                    $('#content'+o_id).append('<p>'+value.name+'  '+value.category+'   '+'数量：'+value.number+'</p>');
                });
                $('#hidden'+o_id).slideDown('slow');
                if(chkid==3)$('#submit'+o_id).remove();
            });
        });
    });
    $('.orderFilter').click(function(){
        window.location.href='index.php?orders='+$(this).val();
    })
</script>