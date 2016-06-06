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
<section>
    <section>
        <div class="page_title"><h2>配件修改</h2></div>
        <select class="select" id="sc_id" style="margin-left: 120px">
            <option value="0">分类</option>
            <option value="-1">未分类</option>
            <?php foreach ($_SESSION['smq'] as $r): ?>
                <option value="<?php echo $r['id'] ?>"><?php htmlout($r['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <select class="select" id="g_name" name="g_name"></select>
        <a href="index.php?goods-config=1">主商品修改</a>
    </section>
    <section id="g_inf" style="display: none">
        <section>
            <div class="page_title">
                <h2>基本信息</h2>
            </div>

            <div class="main-inf">
                <form action="consle.php" method="post">


                    <ul class="ulColumn2">
                        <li class="g-inf-name">
                            <label for="name"><span class="item_name" style="width: 120px"><br/>名称：</span>
                                <input class="textbox textbox_295" id="name" type="text" name="name"/>
                            </label>
                        </li>
                        <li class="g-inf-produce-id">
                            <lable for="produce_id"><span class="item_name" style="width: 120px"><br/>型号：</span>
                                <input class="textbox textbox_225" type="text" id="produce_id" name="produce_id"/>
                            </lable>

                        </li>
                        <li class="g-inf-name">
                            <label><span class="item_name" style="width: 120px"><br/>简介：</span>
                                <textarea class="textarea" id="intro" name="intro" cols="50" rows="6"></textarea>
                            </label>
                        </li>
                        <!--                <button class="link_btn">提交商品信息修改</button>-->

                    </ul>

                    <input type="hidden" name="alter" value="1"/>
                    <input type="hidden"name="is_part"value="1"/>
                    <input type="hidden" name="g_id" id="hidden_g_id" value="<?php echo $_POST['g_id'] ?>"/>

                    <div style="margin-left: 120px">
                        <button class="link_btn">提交商品信息修改</button>
                    </div>
                </form>

            </div>
        </section>
        <section>
            <div class="page_title"><h2>产品规格</h2></div>
            <div id="goods_detail">

            </div>
        </section>
        <section>
            <div class="page_title"><h2>产品图片</h2></div>
            <div id="goods_image">

            </div>
        </section>
        <section>
            <div class="page_title"><h2>对应产品</h2></div>
            <div id="host_set">

            </div>
        </section>
        <section>
            <div class="page_title"><h2>操作</h2></div>
            <div id="changeSituation">

            </div>
        </section>
    </section>
</section>
<div class="space"></div>


<!--<div class="editWrap">-->
<!--    <div class="filter">-->
<!--        <label id="changeCategory" style="display: none">更改分类为-->
<!--            <select id="changeSc">-->
<!--                <option value="-1">未分类</option>-->
<!--                --><?php //foreach ($_SESSION['smq'] as $r): ?>
<!---->
<!--                    <option value="--><?php //echo $r['id'] ?><!--">--><?php //htmlout($r['name']) ?><!--</option>-->
<!--                --><?php //endforeach; ?>
<!--            </select>-->
<!--        </label>-->
<!--    </div>-->
<!--    <div id="g_inf" style="display: none">-->
<!--        <div class="module-title">-->
<!--            <h4>基本信息<h4>-->
<!--        </div>-->
<!--        <div class="main-inf">-->
<!--            <form action="consle.php" method="post">-->
<!--                <div class="g-inf-name">-->
<!--                    <label for="name">名称-->
<!--                        <input id="name" type="text" name="name" value=""/>-->
<!--                    </label>-->
<!--                </div>-->
<!--                <div class="g-inf-produce-id">-->
<!--                    <lable for="produce_id">型号-->
<!--                        <input type="text" id="produce_id"name="produce_id"value=""/>-->
<!--                    </lable>-->
<!---->
<!--                </div>-->
<!---->
<!--                <div class="g-inf-intro">-->
<!--                    <label for="intro">简介-->
<!--                        <textarea id="intro" name="intro"></textarea>-->
<!--                    </label>-->
<!--                </div>-->
<!--                <input type="hidden" name="alter" value="1"/>-->
<!--                <input type="hidden"name="is_part"value="1"/>-->
<!--                <input type="hidden" name="g_id" id="hidden_g_id" value="' . $_POST['g_id'] . '"/>-->
<!--                <button>提交配件信息修改</button>-->
<!--            </form>-->
<!--        </div>-->
<!--        <div id="goods_detail">-->
<!---->
<!--        </div>-->
<!---->
<!--        <div id="goods_image">-->
<!---->
<!--        </div>-->
<!--        <div id="host_set">-->
<!---->
<!--        </div>-->
<!--        <div id="changeSituation">-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<script src="js/partsInfEdit.js"></script>

