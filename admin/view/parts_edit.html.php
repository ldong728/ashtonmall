<?php

$g_id = (isset($_GET['g_id']) ? $_GET['g_id'] : -1);
$sc_id = (isset($_GET['sc_id']) ? $_GET['sc_id'] : -1);
$m_i = (isset($_GET['made_in']) ? $_GET['made_in'] : -1);

?>
<script src="js/ajaxfileupload.js"></script>
<script>
    var g_id = <?php echo $g_id?>;
    var sc_id =
        <?php echo $sc_id?>;
    var mi =
        <?php echo '"'.$m_i.'"' ?>;

</script>
<div class="editWrap">


    <div>
        商品修改
    </div>
    <div class="filter">

        <select id="sc_id">
            <option value="0">分类</option>
            <option value="-1">未分类</option>
            <?php foreach ($_SESSION['smq'] as $r): ?>
                <option value="<?php echo $r['id'] ?>"><?php htmlout($r['name']) ?></option>
            <?php endforeach; ?>
        </select>


        <select id="g_name" name="g_name"></select>
        <a href="index.php?goods-config=1">主商品修改</a>

        <label id="changeCategory" style="display: none">更改分类为
            <select id="changeSc">
                <option value="-1">未分类</option>
                <?php foreach ($_SESSION['smq'] as $r): ?>

                    <option value="<?php echo $r['id'] ?>"><?php htmlout($r['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>
    <div id="g_inf" style="display: none">
        <div class="module-title">
            <h4>基本信息<h4>
        </div>
        <div class="main-inf">
            <form action="consle.php" method="post">
                <div class="g-inf-name">
                    <label for="name">名称
                        <input id="name" type="text" name="name" value=""/>
                    </label>
                </div>
                <div clas="g-inf-produce-id">
                    <lable for="produce_id">型号
                        <input type="text" id="produce_id"name="produce_id"value=""/>
                    </lable>

                </div>

                <div class="g-inf-intro">
                    <label for="intro">简介
                        <textarea id="intro" name="intro"></textarea>
                    </label>
                </div>
                <input type="hidden" name="alter" value="1"/>
                <input type="hidden"name="is_part"value="1"/>
                <input type="hidden" name="g_id" id="hidden_g_id" value="' . $_POST['g_id'] . '"/>
                <button>提交配件信息修改</button>
            </form>
        </div>
        <div id="goods_detail">

        </div>

        <div id="goods_image">

        </div>
        <div id="host_set">

        </div>
        <div id="changeSituation">
        </div>
    </div>
</div>
<script src="js/partsInfEdit.js"></script>

