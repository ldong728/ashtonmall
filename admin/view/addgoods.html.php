<?php
$smq=$_SESSION['smq'];
?>


<section>
    <h2><strong>新建商品</strong></h2>
    <form action="consle.php" method="post">
        <ul class="ulColumn2">
            <li>
                <label><span class="item_name" style="width: 150px">请选择商品分类：</span>
                    <select name="sc_id" class="select">
                    <option value="-1">选择分类</option>
                    <?php foreach ($smq as $r): ?>
                        <option value="<?php echo $r['id'] ?>"><?php htmlout($r['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                </label>
            </li>
            <li>
                <label for="g_name"><span class="item_name" style="width: 150px">名称：</span>
                    <input type="text" class="textbox textbox_295" name="g_name"/>
                </label>
            </li>
            <li>
                <label for="produce_id"><span class="item_name" style="width: 150px">型号：</span>
                    <input type="text" class="textbox" name="produce_id"/>
                </label>
            </li>
            <li>
                <label for="sale"><span class="item_name" style="width: 150px">销售价：</span>
                    <input type="number" class="textbox" name="sale">
                </label>
            </li>
            <li>
                <span class="item_name" style="width: 150px"></span><input type="checkbox"name="is_part"value="1"/>作为配件添加
            </li>
            <li>
                <input type="hidden" name="insert" value="true">
                <span class="item_name" style="width: 150px"></span><input type="submit" class="link_btn" value="确定">
            </li>
        </ul>

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

</section>