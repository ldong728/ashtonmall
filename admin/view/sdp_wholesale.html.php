<?php
$levelInf=$GLOBALS['levelInf'];
$wholesale=$GLOBALS['wholesale'];
?>

<section>
    <h2>
        <strong><?php echo $levelInf['level_name']?>价格设置</strong>
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
            <th>产品</th>
            <th>标准价</th>
            <th>批发价</th>
            <th>最低售价</th>
            <th>最高售价</th>
            <th>佣金分配</th>
        </tr>
        <?php foreach($wholesale as $row):?>
            <tr class="sdp-content">
                <td id="pid<?php echo $row['g_id']?>"><?php echo $row['produce_id']?></td>
                <td><?php echo $row['sale']?></td>
                <td><input class="wholesale"id="whs<?php echo $row['g_id']?>"value="<?php echo $row['wholesale']?>"/></td>
                <td><input class="wholesale"id="min<?php echo $row['g_id']?>"value="<?php echo $row['min_sell']?>"/></td>
                <td><input class="wholesale"id="max<?php echo $row['g_id']?>"value="<?php echo $row['max_sell']?>"/></td>
                <td><a class="gainshare"id="gsh<?php echo $row['g_id']?>">设置</a></td>
            </tr>
        <?php endforeach ?>
    </table>
<!--    <aside class="paging">-->
<!--        --><?php //for($i=1;$i<$sdpInf['count']/20+1; $i++): ?>
<!--            <a href="index.php?sdp=1&rootsdp=--><?php //echo $_GET['rootsdp']?><!--&page=--><?php //echo $i?><!--">--><?php //echo $i?><!--</a>-->
<!--        --><?php //endfor ?>
<!--    </aside>-->
</section>
<section class="pop_bg"style="display:none">
    <div class="pop_cont">
        <h3 class="pop-title"></h3>
        <div class="pop_cont_input">
            <ul class="gainshare-ul">
            </ul>
        </div>
        <div class="pop_cont_text">

        </div>
        <div class="btm_btn">
            <input type="hidden"id="g_id"/>
            <input type="button"class="input_btn trueBtn"value="确认"/>
            <input type="button"class="input_btn falseBtn"value="关闭"/>
        </div>
    </div>
</section>
<script>
    var level=<?php echo $_GET['setWholesale']?>;
$('.wholesale').change(function(){
    var id=$(this).attr('id').slice(3);
    $.post('ajax_request.php',{sdp:1,alterWholesale:level,g_id:id,wholesale:$('#whs'+id).val(),min:$('#min'+id).val(),max:$('#max'+id).val()},function(data){
        if(data=='ok'){
            showToast('修改成功');
        }
    });
});
    $('.gainshare').click(function(){
       var id=$(this).attr('id').slice(3);
        $('.pop-title').text($('#pid'+id).text());
        $('.gainshare-ul').empty();
        $('#g_id').val(id);
        $.post('ajax_request.php',{sdp:1,getGainshareList:1,root:'root',g_id:id},function(data){
            var list=eval('('+data+')');
            $.each(list,function(id,v){
                var content='<li ><span>'+(id+1)+'级</span><input id="ra'+id+'" type="text"class="textbox gs-value"value="'+ v.value+'"></li>';
               $('.gainshare-ul').append(content);
            });
//            alert('hhee')
            $('.pop_bg').css('display','block');
        });
    });
    $('.trueBtn').click(function(){
        var id=$('#g_id').val();
        var values=new Array();
        $('.gs-value').each(function(){
            var rank=$(this).attr('id').slice(2);
            var value=$(this).val();
            values.push({rank:rank,value:value});
        })
        $.post('ajax_request.php',{sdp:1,altGainshare:1,root:'root',g_id:id,data:values},function(data){
            if(data='ok'){
                showToast('更改成功');
            }
        })
    });
    $('.falseBtn').click(function(){
        $('.pop_bg').css('display','none');
    })

</script>