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


    <div class="page_title">
        <h2>商品修改</h2>
    </div>
    <select class="select" id="sc_id" style="margin-left: 120px">
        <option value="0">分类</option>
        <option value="-1">未分类</option>
        <?php foreach ($_SESSION['smq'] as $r): ?>
            <option value="<?php echo $r['id'] ?>"><?php htmlout($r['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <select class="select" id="g_name" name="g_name">
        <option></option>
    </select>
    <a href="index.php?goods-config=1&is_part=1">配件修改</a>

    <!--        <label id="changeCategory" style="display: none">更改分类为-->
    <!--            <select id="changeSc">-->
    <!--                <option value="-1">未分类</option>-->
    <!--                --><?php //foreach ($_SESSION['smq'] as $r): ?>
    <!---->
    <!--                    <option value="--><?php //echo $r['id'] ?><!--">-->
    <?php //htmlout($r['name']) ?><!--</option>-->
    <!--                --><?php //endforeach; ?>
    <!--            </select>-->
    <!--        </label>-->
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
                        <li class="g-inf-name">
                            <label for="s_name"><span class="item_name" style="width: 120px"><br/>短名称：</span>
                                <input class="textbox textbox_225" id="s_name" type="text" name="s_name"/>
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
                        <li class="g-inf-name">
                            <label for="inf"><span class="item_name" style="width: 120px"><br/>图文信息：</span>

                                <div style="display: inline-block">
                                    <script type="text/plain" id="uInput" name="g_inf">
                <p>在这里编辑商品信息</p>


                                    </script>
                                </div>

                            </label>
                        </li>
                        <li class="g-inf-name">
                            <labelfor
                            ="inf"><span class="item_name" style="width: 120px">售后条款：</span>

                            <div style="display: inline-block">
                                <script type="text/plain" id="afterInfInput" name="after_inf">
                <p>在这里编辑售后条款</p>


                                </script>
                            </div>
                            </label>
                        </li>
                    </ul>

                    <input type="hidden" name="alter" value="1"/>
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



        <div class="parm-set">
            <div class="module-title">
                <h4>参数设置</h4>
            </div>
        </div>
        <div id="host_set">

        </div>
        <div id="coop_set">

        </div>
        <div id="changeSituation">
        </div>
    </section>


</section>
<script>
    var editWidth = $(document).width() * 0.4;
    var editHeight = 400;
</script>
<script type="text/javascript" charset="utf-8" src="../uedit/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../uedit/umeditor.min.js"></script>
<script type="text/javascript">
    var um = UM.getEditor('uInput');
    var afterEdit = UM.getEditor('afterInfInput', {
        toolbar: [
            'source | undo redo | bold italic underline strikethrough | superscript subscript | forecolor backcolor | removeformat |',
            'insertorderedlist insertunorderedlist | selectall cleardoc paragraph | fontfamily fontsize',
            '| justifyleft justifycenter justifyright justifyjustify |',
            'link unlink ',
            '| horizontal '
        ]
    })
</script>
<script src="js/goodsInfEdit.js"></script>

