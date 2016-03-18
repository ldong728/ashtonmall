<?php
$opList=$GLOBALS['opList'];
$pmsList=$GLOBALS['pmsList'];
?>

<div class="op-container">
    <div class="op-block">
        <div class="op-name">
            操作员
        </div>
        <div class="op-psw">
            密码
        </div>
        <div class="op-pms">
            <?php foreach($pmsList as $row):?>
            <div class="op-pms-block">
                <?php echo $row['name']?>
            </div>
            <?php endforeach ?>
        </div>
    </div>

</div>