<?php
$levelList=$GLOBALS['levelList'];
$sdpInf=$GLOBALS['sdpInf'];
$page=$GLOBALS['page'];
$getStr=$GLOBALS['getStr'];
?>

<section>
    <h2>
        <strong>微商管理</strong>
    </h2>

<!--    <ul class="admin_tab">-->
<!---->
<!--        --><?php //foreach($levelList as $row):?>
<!--            <li id="level--><?php //echo $row['level_id']?><!--">-->
<!--                <a href="index.php?sdp=1&rootsdp=--><?php //echo $row['level_id']?><!--"  class="level_select --><?php //echo $_GET['rootsdp']==$row['level_id']?'active':''?><!--" >--><?php //echo $row['level_name']?><!--</a>-->
<!--            </li>-->
<!--        --><?php //endforeach?>
<!--    </ul>-->

    <table class="table">
        <tr>
            <th><input type="checkbox"class="selectAll"value="all"></th>
            <th>微信名</th>
            <th>电话</th>
            <th>姓名</th>
            <th>省</th>
            <th>市</th>
            <th><a href="index.php?sdp=1&usersdp=<?php echo $_GET['usersdp']?>&order=order_num&rule=<?php echo isset($_GET['rule'])&&$_GET['rule']=='desc'?'asc':'desc'?>">订单数</a></th>
            <th><a href="index.php?sdp=1&usersdp=<?php echo $_GET['usersdp']?>&order=sub_num&rule=<?php echo isset($_GET['rule'])&&$_GET['rule']=='desc'?'asc':'desc'?>">微商数</a></th>
            <th><a href="index.php?sdp=1&usersdp=<?php echo $_GET['usersdp']?>&order=total_balence&rule=<?php echo isset($_GET['rule'])&&$_GET['rule']=='desc'?'asc':'desc'?>">账户余额</a></th>
            <th><a href="index.php?sdp=1&usersdp=<?php echo $_GET['usersdp']?>&order=total_sell&rule=<?php echo isset($_GET['rule'])&&$_GET['rule']=='desc'?'asc':'desc'?>">销售额</a></th>
            <th>升级</th>
            <th>操作</th>
        </tr>
        <?php foreach($sdpInf['sdp'] as $row):?>
            <tr class="sdp-content">
                <td><input type="checkbox" class="batchCon" id="con<?php echo $row['sdp_id']?>" style="width: 15px"/></td>
                <td><?php echo $row['nickname']?></td>
                <td><?php echo $row['phone']?></td>
                <td><?php echo $row['name']?></td>
                <td><?php echo $row['province']?></td>
                <td><?php echo $row['city']?></td>
                <td><?php echo $row['order_num']?></td>
                <td><?php echo $row['sub_num']?></td>
                <td><?php echo $row['total_balence']?></td>
                <td><?php echo $row['total_sell']?></td>
                <td>
                    <select class="select update"id="select<?php echo $row['sdp_id']?>">
                        <option value="1">微商</option>
                        <?php foreach($levelList as $lrow):?>
                            <option value="<?php echo $lrow['level_id']?>"><?php echo $lrow['level_name']?></option>
                        <?php endforeach ?>
                    </select>
                </td>
                <td>
                    <a class="inner_btn delSdp" id="del<?php echo $row['sdp_id']?>">取消资格</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
    <span>批量操作：</span>
    <select class="select batchUpdate">
        <option value="1">升级为</option>
        <?php foreach($levelList as $lrow):?>
            <option value="<?php echo $lrow['level_id']?>"><?php echo $lrow['level_name']?></option>
        <?php endforeach ?>
    </select>
    <button class="link_btn batchDelSdp">取消资格</button>
    <aside class="paging">
        <?php for($i=1;$i<$sdpInf['count']/20+1; $i++): ?>
            <a href="index.php?<?php echo $getStr?>&page=<?php echo $i?>"><?php echo $i?></a>
        <?php endfor ?>
    </aside>
</section>
<div class="space"></div>
<script>
    var sdp_list={};
    $('.update').change(function(){

        var level=$(this).find('option:selected').val();
        var sdp_id=$(this).attr('id').slice(6);
            if(confirm('确认升级？')){
                $.post('ajax_request.php',{sdp:1,alterSdpLevel:level,sdp_id:sdp_id},function(data){
                    if(data=='ok'){
                        alert('ok');
                    }
                });
            }else{
            }
    });
    $('.batchUpdate').change(function(){
        var level=$(this).find('option:selected').val();
        if(confirm('确认升级？')){
            $.post('ajax_request.php',{sdp:1,alterSdpLevel:level,sdp_id:sdp_list,batch:1},function(data){
                if(data=='ok'){
                    alert('ok');
                }
            });
        }else{
        }
    });

    $('.delSdp').click(function(){
       var sdp_id=$(this).attr('id').slice(3);
        if(confirm('确定撤销此微商的资格？')){
            $.post('ajax_request.php',{sdp:1,deleteSdp:1,sdp_id:sdp_id},function(data){
                if(data=='ok'){
                    alert('已撤销此微商资格，请刷新页面')
                }
            });
        }
    });
    $('.batchDelSdp').click(function(){
        if(confirm('确定撤销此微商的资格？')) {
            $.post('ajax_request.php', {sdp: 1, deleteSdp: 1, sdp_id: sdp_list,batch:1}, function (data) {
                if (data == 'ok') {
                    alert('已撤销此微商资格，请刷新页面')
                }
            })
        }
    });

    $('.selectAll').change(function(){
       var select=$(this).prop('checked');
        if(select){
            $('.batchCon').each(function(k,v){
                sdp_list[v.id.slice(3)]=1;
                v.checked='checked';
            })
        }else{
            $('.batchCon').each(function(k,v){
                sdp_list[v.id.slice(3)]=0;
                v.checked='';
            })

        }

    });
    $('.batchCon').change(function(){
       var select=$(this).prop('checked');
        if(select){
            sdp_list[$(this).attr('id').slice(3)]=1;
        }else{
            sdp_list[$(this).attr('id').slice(3)]=0;
        }
    });




</script>