<?php
$limit=$GLOBALS['limit'];
$review=$GLOBALS['review'];
?>
<section>
    <h2><strong>评价管理</strong></h2>
    <table class="table">
        <tr>
            <th>订单号</th>
            <th>型号</th>
            <th>评价</th>
            <th>分数</th>
            <th>优先级</th>
            <th>操作</th>
        </tr>
        <?php foreach($review as $row):?>
            <tr>
                <td><?php echo $row['order_id']?></td>
                <td><?php echo $row['produce_id']?></td>
                <td><?php echo $row['review']?></td>
                <td><?php echo $row['score']?></td>
                <td>
                    <select id="pri<?php echo $row['id']?>">
                        <?php for($i=1;$i<10;$i++):?>
                            <option value="<?php echo $i ?>"<?php echo $i==$row['priority']?  'selected="selected"':''?>><?php echo $i ?></option>
                        <?php endfor ?>
                    </select>
<!--                    <input type="tel"id="pri--><?php //echo $row['id']?><!--"value="--><?php //echo $row['priority']?><!--"/>-->
                </td>
                <td><a class="inner_btn butt" id="public<?php echo $row['id']?>">公开</a>
                    <a class="inner_btn butt" id="delete<?php echo $row['id']?>">删除</a></td>
            </tr>
        <?php endforeach?>



    </table>


</section>
<div class="space"></div>
<!--<div class="module-block review-block">-->
<!--    <div class="module-title">-->
<!--        评价管理-->
<!--    </div>-->

<!--    --><?php //foreach($review as $row):?>
<!--        <div class="review-box"id="box--><?php //echo $row['id']?><!--">-->
<!--            <div class="reviews">-->
<!--                --><?php //echo $row['review']?>
<!--            </div>-->
<!--            <div class="score">-->
<!--                评分：--><?php //echo $row['score']?>
<!--            </div>-->
<!--            <div class="priority">-->
<!--                优先级：<input type="tel"id="pri--><?php //echo $row['id']?><!--"value="--><?php //echo $row['priority']?><!--"/>-->
<!--            </div>-->
<!--            <button class="butt" id="public--><?php //echo $row['id']?><!--">公开</button>-->
<!--            <button class="butt" id="delete--><?php //echo $row['id']?><!--">删除</button>-->
<!---->
<!--        </div>-->
<!--    --><?php //endforeach?>
<!--</div>-->
<script>
    $(document).on('click','.butt',function(){
//        alert('haha')
        var mode=$(this).attr('id').slice(0,6);
        var id=$(this).attr('id').slice(6);
        if(mode=='public'){
            var data={manageReview:1,id:id,public:1,priority:$('#pri'+id).val()}

        }else{
           var data={manageReview:1,id:id,public:0,priority:9}
        }
        $.post('ajax_request.php',data,function(data){
            showToast('Done');
//            alert(data);
            $('#box'+id).remove();
        })
    })

</script>