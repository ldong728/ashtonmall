<?php $frontImg=$GLOBALS['frontImg']?>
<?php $remarkQuery=$GLOBALS['remarkQuery']?>
<script src="js/ajaxfileupload.js"></script>
<div class="module-block front_img_block">
    <div class="module-title">
        <h4>首页图片</h4>
    </div>
    <?php foreach($frontImg as $row):?>

            <a href="#"class="delete-front-img"id="<?php echo $row['id']?>">
                <img src="../<?php echo $row['img_url']?>"/>
            </a>

    <?php endforeach?>

    <a class="front-img-upload"></a><input type="file"id="front-img-up"name="front-img-up"style="display: none">

    <script>
        $(document).on('click','.front-img-upload',function(){
            $('#front-img-up').click();
        });
        $(document).on('change','#front-img-up',function(){
            $.ajaxFileUpload({
                url:'upload.php',
                secureuri: false,
                fileElementId: $(this).attr('id'), //文件上传域的ID
                dataType: 'json', //返回值类型 一般设置为json
                success: function (v, status){
                    if('SUCCESS'== v.state){
                        var content = '<a href="#"class="delete-front-img"id="'+ v.id+'"><img src="../'+ v.url+'"/></a>';
                        $('.front-img-upload').before(content);
                    }else{
                        showToast(v.state);
                    }
                },//服务器成功响应处理函数
                error:function(d){
                    alert('error');
                }
            });
        });
    </script>

</div>
<div class="module-block index-remark">
    <div class="module-title"><h4>首页文字</h4></div>
    <?php foreach($remarkQuery as $row):?>
        <div class="remark-box">
            <div class="img-box"id="">
                <a href="#"class="index-remark-img-upload"id="upbtn<?php echo $row['id']?>">
                    <img id="img<?php echo $row['id']?>" src="../<?php echo $row['img']?>"/></a>
                <input type="file"class="index-remark-img-up"id="img-up<?php echo $row['id']?>"name="img-up<?php echo $row['id']?>"style="display: none">
            </div>
            <input class="title-input" type="text"id="title<?php echo $row['id']?>"value="<?php echo $row['title']?>"/>
            <textarea class="remark-input" id="remark<?php echo $row['id']?>"rows="5"cols="20"><?php echo $row['remark']?></textarea>
            <div class="remark-button-area">
                <button class="remark-alter" id="alter<?php echo $row['id']?>">修改</button>
                <button class="remark-del" id="del<?php echo $row['id']?>">删除</button>
            </div>

        </div>

    <?php endforeach?>

<!--    <a class="index-remark-img-upload"></a><input type="file"id="index-remark-img-up"name="front-img-up"style="display: none">-->

    <script>
        $(document).on('click','.index-remark-img-upload',function(){
            var id=$(this).attr('id').slice(5);
            $('#img-up'+id).click();
        });
        $(document).on('change','.index-remark-img-up',function(){
            var  id=$(this).attr('id').slice(6);
//            alert(id);
            $.ajaxFileUpload({
                url:'upload.php?index_remark_img='+id,
                secureuri: false,
                fileElementId: $(this).attr('id'), //文件上传域的ID
                dataType: 'json', //返回值类型 一般设置为json
                success: function (v, status){
                    if('SUCCESS'== v.state){
                        window.location='index.php';

                    }else{
                        showToast(v.state);
                    }
                },//服务器成功响应处理函数
                error:function(d){
                    alert('error');
                }
            });
        });
        $(document).on('click','.remark-alter',function(){
            var id=$(this).attr('id').slice(5);
            var title=$('#title'+id).val();
            var remark=$('#remark'+id).val();
            $.post('ajax_request.php',{remarkAlter:1,id:id,title:title,remark:remark},function(data){
                window.location='index.php';

            });

        });
        $(document).on('click','.remark-del',function(){
            var id=$(this).attr('id').slice(3);

        });
    </script>

</div>

<script>

    $(document).on('click','.delete-front-img',function(){
        var id=$(this).attr('id');
        $.post('ajax_request.php',{del_front_img:1,id:id},function(data){
//            alert(data);
            $('#'+id).remove();

        })
    })




</script>