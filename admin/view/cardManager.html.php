<?php

?>
<script src="js/ajaxfileupload.js"></script>

<div class="module-block">
    <div class="module-title">
        <h4>现有卡券</h4>
    </div>
</div>

<div class="module-block">
    <div class="module-title">
        <h4>创建卡券</h4>
    </div>
    <form action="consle.php"method="post">
        <div class="card-logo">
            <a class="card-img-upload"><img class="card-logo-img"/></a><input type="file"id="card-img-up"name="card-img-up"style="display: none">
            <input type="hidden" name="logoUrl"id="logoUrl">
        </div>




    </form>


</div>
<script>
    $(document).on('click','.card-img-upload',function(){
        $('#card-img-up').click();
    });
    $(document).on('change','#card-img-up',function(){
        $.ajaxFileUpload({
            url:'upload.php',
            secureuri: false,
            fileElementId: $(this).attr('id'), //文件上传域的ID
            dataType: 'json', //返回值类型 一般设置为json
            success: function (v, status){
//                alert(v.logo);
                if('SUCCESS'== v.state){
                    $('#logoUrl').val(v.logo);
                    $('.card-logo-img').attr('src','../'+ v.url);
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
