<?php $levelList=$GLOBALS['levelList']?>
<section>
    <div class="page_title">
        <h2 class="fl">经销商等级设置</h2>
    </div>
    <table class="table">
        <tr>
            <th>编号</th>
            <th>级别名称</th>
            <th>折扣率</th>
            <th>最低定价</th>
            <th>最高定价</th>
        </tr>
        <?php foreach($levelList as $row):?>
            <tr>
               <td><?php echo $row['level_id']?></td>
                <td class="ipt-toggle" id="<?php echo $row['level_id']?>" data-tbl="sdp_level_tbl"data-col="level_name" data-index="level_id"><?php echo $row['level_name']?></td>
                <td class="ipt-toggle" id="<?php echo $row['level_id']?>" data-tbl="sdp_level_tbl"data-col="discount" data-index="level_id"><?php echo $row['discount']?></td>
                <td class="ipt-toggle" id="<?php echo $row['level_id']?>" data-tbl="sdp_level_tbl"data-col="min_sell" data-index="level_id"><?php echo $row['min_sell']?></td>
                <td class="ipt-toggle" id="<?php echo $row['level_id']?>" data-tbl="sdp_level_tbl"data-col="max_sell" data-index="level_id"><?php echo $row['max_sell']?></td>
            </tr>
        <?php endforeach;?>
        <?php echo 'hhhhhh'?>
    </table>

</section>