<?php
$levelList=$GLOBALS['levelList'];
$gainShare=$GLOBALS['gainShare'];
$config=$GLOBALS['config'];
?>
<section>
    <div class="page_title">
        <h2 class="fl">经销商等级设置</h2>
    </div>
    <table class="table">
        <tr>
            <th>编号</th>
            <th>级别名称</th>
            <th>拿货折扣</th>
            <th>最低定价</th>
            <th>最高定价</th>
        </tr>
        <?php foreach($levelList as $row):?>
            <tr>
               <td><?php echo $row['level_id']?></td>
                <td class="ipt-toggle" id="<?php echo $row['level_id']?>" data-tbl="sdp_level_tbl"data-col="level_name" data-index="level_id"><a href="consle.php?sdp=1&setWholesale=<?php echo $row['level_id']?>"><?php echo $row['level_name']?></a></td>
                <td class="ipt-toggle" id="<?php echo $row['level_id']?>" data-tbl="sdp_level_tbl"data-col="discount" data-index="level_id"><?php echo $row['discount']?></td>
                <td class="ipt-toggle" id="<?php echo $row['level_id']?>" data-tbl="sdp_level_tbl"data-col="min_sell" data-index="level_id"><?php echo $row['min_sell']?></td>
                <td class="ipt-toggle" id="<?php echo $row['level_id']?>" data-tbl="sdp_level_tbl"data-col="max_sell" data-index="level_id"><?php echo $row['max_sell']?></td>
            </tr>
        <?php endforeach;?>
    </table>
    <button class="link_btn add-level">新建等级</button>
    <div class="page_title">
        <h2>默认佣金设置</h2>
    </div>
    <table class="table">
        <tr>
            <th>等级</th>
            <th>佣金比例</th>
        </tr>
        <?php foreach($gainShare as $gainrow):?>
            <tr>
                <td><?php echo $gainrow['rank']?></td>
                <td class="ipt-toggle" id="<?php echo $gainrow['id']?>" data-tbl="sdp_gainshare_tbl"data-col="value" data-index="id"><?php echo $gainrow['value']?></td>
            </tr>
        <?php endforeach ?>
    </table>
    <div class="page_title">
        <h2>佣金提现设置</h2>
    </div>
    <ul class="ulcolumn2">
        <li><span class="item_name" style="width: 120px;text-align: right">最低提现额：</span><input class="feeback_con textbox textbox_295" type="number"id="minAmount"value="<?php echo $config['minAmount']?>"/> </li>
        <li><span class="item_name" style="width: 120px;text-align: right">单笔最高提现额：</span><input class="feeback_con textbox textbox_295" type="number"id="maxAmount"value="<?php echo $config['maxAmount']?>"/> </li>

    </ul>


</section>
<div class="space"></div>
<script>
    $(document).on('change','.feeback_con',function(){
        alert('ok');
        var key=$(this).attr('id');
        var value=$(this).val();
        $.post('ajax_request.php',{sdp:1,altFeebackCon:1,key:key,value:value},function(data){
            if(data=='ok')showToast('修改成功');
        })
    });
    $('.add-level').click(function(){
        $.post('ajax_request.php',{sdp:1,addSdpLevel:1},function(data){
            if(data>0){
                location.reload(true);
            }
        })
    });
</script>