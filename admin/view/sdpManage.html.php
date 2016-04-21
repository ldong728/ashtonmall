<?php
    $levelList=$GLOBALS['levelList'];
    $sdpInf=$GLOBALS['sdpInf'];
?>

<section>
    <h2>
        <strong>分销商管理</strong>
    </h2>

<ul class="admin_tab">

    <?php foreach($levelList as $row):?>
        <li id="level<?php echo $row['level_id']?>">
            <a href="index.php?sdp=1&rootsdp=<?php echo $row['level_id']?>"  class="level_select <?php echo $_GET['rootsdp']==$row['level_id']?'active':''?>" ><?php echo $row['level_name']?></a>
        </li>
    <?php endforeach?>
</ul>
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
                    <select class="select change"id="select<?php echo $row['sdp_id']?>">
                    <?php foreach($levelList as $lrow):?>
                        <option value="<?php echo $lrow['level_id']?>"<?php echo $lrow['level_id']==$_GET['rootsdp']?'selected="selected"':''?>><?php echo $lrow['level_name']?></option>
                    <?php endforeach ?>
                    </select>
                </td>
                <td>
                    <a class="inner_btn downGradeSdp"id="downgr<?php echo $row['sdp_id']?>">取消资格</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
    <aside class="paging">
        <?php for($i=1;$i<$sdpInf['count']/20+1; $i++): ?>
        <a href="index.php?sdp=1&rootsdp=<?php echo $_GET['rootsdp']?>&page=<?php echo $i?>"><?php echo $i?></a>
        <?php endfor ?>
    </aside>
</section>
<script>
    $('.change').change(function(){

        var level=$(this).find('option:selected').val();
        var sdp_id=$(this).attr('id').slice(6);
        if(confirm('确认变更等级？')){
            $.post('ajax_request.php',{sdp:1,alterSdpLevel:level,sdp_id:sdp_id},function(data){
                if(data=='ok'){
                    showToast('等级已变更')
                }
            });
        }else{
        }
    });
    $('.downGradeSdp').click(function(){

        var level=1;
        var sdp_id=$(this).attr('id').slice(6);
        if(confirm('确认撤销分销商资格？')){
            $.post('ajax_request.php',{sdp:1,alterSdpLevel:level,sdp_id:sdp_id},function(data){
                if(data=='ok'){
                    showToast('已撤销，请刷新页面')
                }
            });
        }else{
        }
    });

</script>