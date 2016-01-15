<div class="foot-nav">
    <div class="category-nav">
        <div class="space"></div>
        <?php foreach ($_SESSION['maincate'] as $row): ?>
            <div class="nave-block"id="<?php echo $row['id'] ?>"onclick="selectCate(this)"><?php echo $row['name'] ?></div>
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

        <div class="icon-block">
            <div class="icon kf"></div>
            <p class="icon-name">在线客服</p>
        </div>

    </div>

</div>
<div class="foot">


</div>