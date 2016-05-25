<?php
$levelList = $GLOBALS['levelList'];
$sdpInf = $GLOBALS['sdpInf'];
$page = $GLOBALS['page'];
$getStr = $GLOBALS['getStr'];
?>

<section>
    <h2>
        <strong>分销商管理</strong>
    </h2>


    <ul class="admin_tab">

        <?php foreach ($levelList as $row): ?>
            <li id="level<?php echo $row['level_id'] ?>">
                <a href="index.php?sdp=1&usersdp=<?php echo $row['level_id'] ?>&rootsdp=1"
                   class="level_select <?php echo $_GET['usersdp'] == $row['level_id'] ? 'active' : '' ?>"><?php echo $row['level_name'] ?></a>
            </li>
        <?php endforeach ?>
    </ul>
    <input type="text" class="textbox textbox_225" id="search" placeholder="请输入昵称，姓名，或电话"/><button class="link_btn search_btn">搜索</button>
    <table class="table">
        <tr>
            <th><input type="checkbox"class="selectAll"value="all"></th>
            <th>微信名</th>
            <th>电话</th>
            <th>姓名</th>
            <th>省</th>
            <th>市</th>
            <th><a href="index.php?sdp=1&rootsdp=1&usersdp=<?php echo $_GET['usersdp']?>&order=order_num&rule=<?php echo isset($_GET['rule'])&&$_GET['rule']=='desc'?'asc':'desc'?>">订单数</a></th>
            <th><a href="index.php?sdp=1&rootsdp=1&usersdp=<?php echo $_GET['usersdp']?>&order=sub_num&rule=<?php echo isset($_GET['rule'])&&$_GET['rule']=='desc'?'asc':'desc'?>">微商数</a></th>
            <th><a href="index.php?sdp=1&rootsdp=1&usersdp=<?php echo $_GET['usersdp']?>&order=total_balence&rule=<?php echo isset($_GET['rule'])&&$_GET['rule']=='desc'?'asc':'desc'?>">账户余额</a></th>
            <th><a href="index.php?sdp=1&rootsdp=1&usersdp=<?php echo $_GET['usersdp']?>&order=total_sell&rule=<?php echo isset($_GET['rule'])&&$_GET['rule']=='desc'?'asc':'desc'?>">销售额</a></th>
            <th>升级</th>
            <th>操作</th>
        </tr>
        <?php foreach ($sdpInf['sdp'] as $row): ?>
            <tr class="sdp-content">
                <td><input type="checkbox" class="batchCon" id="con<?php echo $row['sdp_id']?>" style="width: 15px"/></td>
                <td><?php echo $row['nickname'] ?></td>
                <td><?php echo $row['phone'] ?></td>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['province'] ?></td>
                <td><?php echo $row['city'] ?></td>
                <td><a href="index.php?orders=-1&dorder=1&root=<?php echo $row['sdp_id']?>"><?php echo $row['order_num'] ?></td>
                <td><a href="index.php?sdp=1&usersdp=1&root=<?php echo $row['sdp_id']?>"><?php echo $row['sub_num'] ?></a></td>
                <td><a href="index.php?sdp=1&userAccount=<?php echo $row['sdp_id']?>"><?php echo $row['total_balence'] ?></a></td>
                <td><?php echo $row['total_sell']?></td>
                <td>
                    <select class="select change" id="select<?php echo $row['sdp_id'] ?>">
                        <?php foreach ($levelList as $lrow): ?>
                            <option
                                value="<?php echo $lrow['level_id'] ?>"<?php echo $lrow['level_id'] == $_GET['rootsdp'] ? 'selected="selected"' : '' ?>><?php echo $lrow['level_name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
                <td>
                    <a class="inner_btn downGradeSdp" id="downgr<?php echo $row['sdp_id'] ?>">取消资格</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
    <span>批量操作：</span>
    <select class="select batchChange">
        <option value="1">更改等级</option>
        <?php foreach($levelList as $lrow):?>
            <option value="<?php echo $lrow['level_id']?>"><?php echo $lrow['level_name']?></option>
        <?php endforeach ?>
    </select>
    <button class="link_btn batchDownGrade">取消资格</button>

    <aside class="paging">
        <?php for($i=1;$i<$sdpInf['count']/15+1; $i++): ?>
            <a href="index.php?<?php echo $getStr?>&page=<?php echo $i?>"><?php echo $i?></a>
        <?php endfor ?>
    </aside>
</section>
<div class="space"></div>
<script>
    var sdp_list={};
    $('.change').change(function () {

        var level = $(this).find('option:selected').val();
        var sdp_id = $(this).attr('id').slice(6);
        if (confirm('确认变更等级？')) {
            $.post('ajax_request.php', {sdp: 1, alterSdpLevel: level, sdp_id: sdp_id}, function (data) {
                if (data == 'ok') {
                    showToast('等级已变更')
                }
            });
        } else {
        }
    });
    $('.batchChange').change(function () {

        var level = $(this).find('option:selected').val();
        if (confirm('确认变更等级？')) {
            $.post('ajax_request.php', {sdp: 1, alterSdpLevel: level, sdp_id: sdp_list,batch:1}, function (data) {
                if (data == 'ok') {
                    showToast('等级已变更')
                }
            });
        } else {
        }
    });

    $('.downGradeSdp').click(function () {

        var level = 1;
        var sdp_id = $(this).attr('id').slice(6);
        if (confirm('确认撤销分销商资格？')) {
            $.post('ajax_request.php', {sdp: 1, alterSdpLevel: level, sdp_id: sdp_id}, function (data) {
                if (data == 'ok') {
                    showToast('已撤销，请刷新页面')
                }
            });
        } else {
        }
    });
    $('.batchDownGrade').click(function () {
        var level = 1;
        if (confirm('确认撤销分销商资格？')) {
            $.post('ajax_request.php', {sdp: 1, alterSdpLevel: level, sdp_id: sdp_list,batch:1}, function (data) {
                if (data == 'ok') {
                    showToast('已撤销，请刷新页面')
                }
            });
        } else {
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
    $('.search_btn').click(function(){
        var search=$('#search').val();
        window.location.href='index.php?sdp=1&usersdp=2&search='+search;
    });

</script>