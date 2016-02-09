<?php $frontImg=$GLOBALS['frontImg']?>
<script src="js/ajaxfileupload.js"></script>
<div class="module-block front_img_block">
    <div class="module-title">
        <h4>首页图片管理</h4>
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

<script>

    $(document).on('click','.delete-front-img',function(){
        var id=$(this).attr('id');
        $.post('ajax_request.php',{del_front_img:1,id:id},function(data){
//            alert(data);
            $('#'+id).remove();

        })
    })




</script>