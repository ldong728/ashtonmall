<?php
$smq=$_SESSION['smq'];
?>


<div>
    <form action="consle.php" method="post">
        <div>
            <p>
                新商品登录
            </p>
            <select name="sc_id">
                <option value="-1">分类</option>
                <?php foreach ($smq as $r): ?>
                    <option value="<?php echo $r['id'] ?>"><?php htmlout($r['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <br/>
            <label for="g_name">名称：
                <input type="text" name="g_name">
            </label>
        </div>
        <div>
        </div>
        <div>
            <label for="sale">销售价：
                <input type="text" name="sale">
            </label>
            <label for="wholesale">批发价：
                <input type="text" name="wholesale">
            </label>
        </div>
        <div>


        </div>


        <div>
            <input type="hidden" name="insert" value="true">
            <input type="submit" value="确定">
        </div>

    </form>

    <!--style给定宽度可以影响编辑器的最终宽度-->
<!--    <link href="../uedit/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">-->
<!--    <script type="text/javascript" charset="utf-8" src="../uedit/umeditor.config.js"></script>-->
<!--    <script type="text/javascript" charset="utf-8" src="../uedit/umeditor.min.js"></script>-->
<!---->
<!--    <script type="text/javascript">-->
<!--        var um = UM.getEditor('myEditor');-->
<!---->
<!--    </script>-->

</div>