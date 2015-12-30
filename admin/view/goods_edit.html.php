<?php

$g_id=(isset($_GET['g_id'])? $_GET['g_id'] : -1);
$sc_id=(isset($_GET['sc_id'])? $_GET['sc_id'] : -1);
$m_i=(isset($_GET['made_in'])? $_GET['made_in']:-1);

?>
<script src="js/ajaxfileupload.js"></script>
<script>
    var g_id = <?php echo $g_id?>;
    var sc_id=
        <?php echo $sc_id?>;
    var mi=
        <?php echo '"'.$m_i.'"' ?>;
</script>
<div class="editWrap">


    <div>
        商品修改
    </div>
    <div class="filter">

        <select id = "sc_id">
            <option value = "0">分类</option>
            <option value = "-1">未分类</option>
            <?php foreach ($_SESSION['smq'] as $r): ?>
                <option value = "<?php echo $r['id'] ?>"><?php  htmlout($r['name']) ?></option>
            <?php endforeach; ?>
        </select>


        <select id = "g_name" name = "g_name"></select>

        <label id ="changeCategory"style="display: none">更改分类为
            <select id="changeSc">
                <option value = "-1">未分类</option>
                <?php foreach ($_SESSION['smq'] as $r): ?>

                    <option value = "<?php echo $r['id'] ?>"><?php  htmlout($r['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>
    <div id = "g_inf"style="display: none">


        <form action="consle.php" method="post">
            <div>
                <label for ="name">名称
                    <input id = "name" type = "text" name="name" value =""/>
                </label>
            </div>
            <div>
                <label for="intro">简介
                    <textarea id="intro" name="intro"></textarea>
                </label>
            </div>
            <div>
                <label for = "inf">介绍：
                    <script type="text/plain" id = "uInput" name = "g_inf" style="width:1000px;height:240px;">
                <p>在这里编辑商品信息</p>
                </script>
                </label>
            </div>
            <input type="hidden"name="alter"value="1"/>
            <input type="hidden"name="g_id"id="hidden_g_id"value="' . $_POST['g_id'] . '"/>
            <button>提交修改信息</button>
        </form>
        <div id="goods_detail">
        </div>
        <div class="divButton"><p id="add_category">添加规格</p></div>
        <div id="goods_image">
        </div>
        <form name="upfile" action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="spic[]" id="v1" /><br/>
            <input type="file" name="spic[]" id="v2" /><br/>
            <input type="file" name="spic[]" id="v3" /><br/>
            <input type="file" name="spic[]" id="v4" /><br/>
            <input type="hidden" name="g_id" id="g_id_img" value="<?php echo $g_id?>"/>
            <input type="submit" name="sub" value="上传图片" onclick="return Check()" />
            <input type="reset" name="res" value="重填" />
        </form>
        <div id="changeSituation">

        </div>

    </div>

    <div class="img-upload">
    <input type="file"id="tmp"name="tmp"style="display: none">
        <input id="upbutton" type="button"value="上传">

    </div>
    <script>
        $('#upbutton').click(function(){
            $('#tmp').click();
        })
        $('#tmp').change(function(){
            $.ajaxFileUpload({
                url:'upload.php?g_id='+g_id,
                secureuri: false,
                fileElementId: 'tmp', //文件上传域的ID
                dataType: 'json', //返回值类型 一般设置为json
                success: function (data, status){}  //服务器成功响应处理函数


            })
        })

    </script>
</div>
<script type="text/javascript" charset="utf-8" src="../uedit/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../uedit/umeditor.min.js"></script>
<script type="text/javascript">
    var um = UM.getEditor('uInput');

</script>
<script src="js/goodsInfEdit.js"></script>

