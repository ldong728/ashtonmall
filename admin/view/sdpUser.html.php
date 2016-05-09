<?php
$levelList=$GLOBALS['levelList'];
$sdpInf=$GLOBALS['sdpInf'];
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
            <th>微信名</th>
            <th>电话</th>
            <th>姓名</th>
            <th>省</th>
            <th>市</th>
            <th>订单数</th>
            <th>微商数</th>
            <th>账户余额</th>
            <th>升级</th>
            <th>操作</th>
        </tr>
        <?php foreach($sdpInf['sdp'] as $row):?>
            <tr class="sdp-content"><td><?php echo $row['nickname']?></td>
                <td><?php echo $row['phone']?></td>
                <td><?php echo $row['name']?></td>
                <td><?php echo $row['province']?></td>
                <td><?php echo $row['city']?></td>
                <td><?php echo $row['order_num']?></td>
                <td><?php echo $row['sub_num']?></td>
                <td><?php echo $row['total_balence']?></td>
                <td>
                    <select class="select update"id="select<?php echo $row['sdp_id']?>">
                        <option value="1">微商</option>
                        <?php foreach($levelList as $lrow):?>
                            <option value="<?php echo $lrow['level_id']?>"><?php echo $lrow['level_name']?></option>
                        <?php endforeach ?>
                    </select>
                </td>
                <td>
                    <a class="inner_btn delSdp"id="del<?php echo $row['sdp_id']?>">取消资格</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
    <aside class="paging">
        <?php for($i=1;$i<$sdpInf['count']/20+1; $i++): ?>
            <a href="index.php?sdp=1&usersdp=1&page=<?php echo $i?>"><?php echo $i?></a>
        <?php endfor ?>
    </aside>
</section>
<div class="space"></div>
<script>
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
    $('.delSdp').click(function(){
       var sdp_id=$(this).attr('id').slice(3);
        if(confirm('确定撤销此微商的资格？')){
            $.post('ajax_request.php',{sdp:1,deleteSdp:1,sdp_id:sdp_id},function(data){
                if(data=='ok'){
                    alert('已撤销此微商资格，请刷新页面')
                }
            })
        }
    });


</script>