<?php
$query=$GLOBALS['query'];
?>

<section>
    <h2><strong>待审核返佣申请</strong></h2>
    <table class="table">
        <tr>
            <th>单号</th>
            <th>金额</th>
            <th>时间</th>
            <th>操作</th>
        </tr>
        <?php foreach($query as $row):?>
        <tr>
            <td><?php echo $row['id']?></td>
            <td><?php echo $row['amount']?></td>
            <td><?php echo date('Y-m-d H:i:s',$row['create_time'] )?></td>
            <td>
                <a class="inner_btn" href="index.php?sdp=1&userAccount=<?php echo $row['sdp_id']?>">账户详情</a>
                <a class="inner-btn confirm-feeback" id="sdp<?php echo $row['id']?>">确认返佣</a>
                <a class="inner-btn" id="chg<?php echo $row['id']?>">修改金额</a>
            </td>
        </tr>
        <?php endforeach ?>
    </table>

</section>

<div class="space"></div>
<script>
    $('.confirm-feeback').click(function(){
        var id=$(this).attr('id').slice(3);
        $.post('ajax_request.php',{feeback_confirm:1,feeback_id:id},function(data){
            if(data=='ok'){
                location.reload(true);
            }else{
                alert(data);
            }

    });
    });
</script>