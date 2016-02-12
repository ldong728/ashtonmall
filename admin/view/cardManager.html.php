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
        <a class="card-img-upload"></a><input type="file"id="card-img-up"name="card-img-up"style="display: none">



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
//                if('SUCCESS'== v.state){
                    alert(v.url)
//                    var content = '<a href="#"class="delete-front-img"id="'+ v.id+'"><img src="../'+ v.url+'"/></a>';
//                    $('.front-img-upload').before(content);
//                }else{
////                    showToast(v.state);
//                }
            },//服务器成功响应处理函数
            error:function(d){
                alert('error');
            }
        });
    });
</script>
