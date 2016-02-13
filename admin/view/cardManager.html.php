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
        <input type="hidden"name="importCard"value="1"/>
        输入卡券Id：<input name="card_id"type="text"/>
        <input type="submit">

    </form>


</div>

