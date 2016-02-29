<head>
    <?php include 'templates/header.php' ?>
    <meta content="YES" name="apple-touch-fullscreen">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <link rel="stylesheet" href="stylesheet/goodinf-swiper.min.css"/>
    <link rel="stylesheet" href="stylesheet/myswiper.css"/>
    <script src="../js/swiper.min.js"></script>
    <!--    <link rel="stylesheet" href="stylesheet/goods_inf.css"/>-->
    <script src="../js/lazyload.js"></script>

</head>
<body>
<div class="wrap">
    <div class="pDetail">
        <a href="controller.php?getList=1&c_id=<?php echo $cate['id']?>"><div class="cate-name">
                <?php echo $cate['name'].' '.$cate['e_name']?> 配件
            </div>
        </a>
        <div class="h-slash">

        </div>
        <div class="baseInfo">
            <div class="pd_info">
                <div class="swiper-container" id="cover_swiper">
                    <div class="swiper-wrapper" style="width: 4368px; height: auto">
                        <?php foreach ($imgQuery as $row): ?>
                            <div class="swiper-slide">
                                <img class="swiper-img swiper-lazy" data-src="../<?php echo $row['url'] ?>"/>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <div class="swiper-pagination" id="ad-pagination"></div>
                </div>
                <div class="swiper-pagination" id="ad-pagination"></div>
                <script>
                    var swiper = new Swiper('#cover_swiper', {
                        pagination: '#ad-pagination',
                        paginationClickable: true,
                        autoplay: 5000,
                        lazyLoading: true,
                        loop: true
                    });
                </script>
                <div class="pName">
                    <span class="pro_name"><?php echo $inf['name'] ?></span>
                </div>
                <div class="inf">
                    立即订购并获得免费送货服务，订购数量有限
                </div>
                <div class="p-remark">
<!--                    <div class="p-remark-content">-->
<!--                        认证企业-->
<!--                    </div>-->
<!--                    <div class="p-remark-content">-->
<!--                        免运费-->
<!--                    </div>-->
<!--                    <div class="p-remark-content">-->
<!--                        销量18件-->
<!--                    </div>-->
<!--                    <div class="p-remark-content">-->
<!--                        库存96件-->
<!--                    </div>-->

                    <div class="price">
                        RMB <?php echo $price= $inf['sale'] ?>
                    </div>
                </div>
            </div>
            <div class="part module-box">
                <div class="title">
                    <div class="line-number"> 1</div>
                    <div class="title-name">适用机型:</div>

                </div>
                <div class="scroll-box">
                    <div class="part-box">
                        <?php foreach ($hostlist as $r): ?>
                        <a href="controller.php?goodsdetail=1&g_id=<?php echo $r['g_id'] ?>" >
                            <div class="partInf">
                                <img class="part-img" src="../<?php echo $r['url'] ?>"/>
                                <input type="hidden" value="<?php echo $r['sale'] ?>"/>

                                <div class="part-name">
                                    <?php echo $r['produce_id'] ?>
                                </div>
                            </div>
                            </a>
                        <?php endforeach ?>
                    </div>
                </div>
                <!--                <div class="partBuy">-->
                <!--                    <button class="part-buy-now">立即购买</button>-->
                <!--                    <button class="part-add-cart">加入购物车</button>-->
                <!--                </div>-->
            </div>
            <div class="param module-box">
                <div class="title">
                    <div class="line-number">2</div>
                    <div class="title-name">参数</div>
                </div>
                <div class="param-container">
                    <dl>
                        <dt>名称：</dt>
                        <dd><?php echo $inf['name'] ?></dd>
                    </dl>
                    <dl>
                        <dt>品牌：</dt>
                        <dd>ashton/阿诗顿</dd>
                    </dl>
                </div>


            </div>

            <div class="detail module-box">

                                <div class="title" id="count-title">
                                        <div class="line-number">3</div>
                                    <div class="title-name">选择数量</div>
                                    <div class="countBox">
                                        <a class="minus number-button" id="minus">-</a>
                                        <input readonly="1" class="count" id="number" value="<?php echo $number ?>" maxlength="3"
                                               type="tel"/>
                                        <a class="plus number-button" id="plus">+</a>
                                    </div>
                                </div>

            </div>

        </div>
    </div>


    <!--    --><?php //include_once 'templates/foot.php' ?>
    <div class="foot">
        <div class="total-price">合计￥<?php echo($price * $number) ?></div>
        <a class="cart"href="controller.php?getCart=1$rand=<?php echo rand(1000,9999)?>"></a>
        <div class="button-box">
            <a class="buttons buy-now">
                立即购买
            </a>
            <a class="buttons add-cart">
                加入购物车
            </a>
        </div>

    </div>
    <div class="toast"></div>

</div>
<script>
    var g_id =<?php echo $inf['g_id']?>;
    var d_id = <?php echo $inf['d_id']?>;
    var realPrice =<?php echo $inf['sale']?>;//保存在js中的价格
    var number = parseInt($('#number').val());
    var parts = new Array();
</script>
<script src="../js/goods-inf.js"></script>
<?php //include 'templates/jssdkIncluder.php'?>
</body>

