<div class="foot-nav">
    <div class="category-nav">
<!--        <div class="space"></div>-->
        <?php foreach ($_SESSION['maincate'] as $row): ?>
            <div class="nave-block"id="main<?php echo $row['id'] ?>"onclick="selectCate(this)"><?php echo $row['name'] ?></div>
            <div class="nave-slash"></div>
        <?php endforeach ?>
    </div>
    <div class="con-nav">
        <a href="controller.php?customerInf=1">
        <div class="icon-block">
            <div class="icon user-center">
            </div>
            <p class="icon-name">个人中心</p>
        </div>
        </a>
        <a class="toKf" href="#">
        <div class="icon-block">
            <div class="icon kf"></div>
            <p class="icon-name">在线客服</p>
        </div>
            </a>

    </div>

</div>
<script>
    $('.toKf').click(function(){
//        showToast('hhh');
//        closeWindow('hhhh');
        $.post('ajax.php',{linkKf:1},function(data){

            if(0==data){
                alert('客服已接通，请关闭当前页面以便与客服交流');
            }
            if(1==data){
                alert('客服不在线或者忙碌中，请稍候再试');
            }
            if(2==data){
                alert('当前无在线客服，请稍候再试');
            }

        })

    });

</script>
<a class="toindex" href="index.php"><div class="foot">
    <div class="logo-block">
        <div class="logo flag"></div>
        <div class="logo"></div>
        <div class="name">美国阿诗顿商城</div>

    </div>
</a>

</div>