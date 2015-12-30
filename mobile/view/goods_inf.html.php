<head>
    <?php include 'templates/header.php' ?>
    <meta content="YES" name="apple-touch-fullscreen">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <link rel="stylesheet" href="stylesheet/goodinf-swiper.min.css"/>
    <link rel="stylesheet" href="stylesheet/myswiper.css"/>
    <script src="../js/swiper.min.js"></script>
    <link rel="stylesheet" href="stylesheet/goods_inf.css"/>
    <script src="../js/lazyload.js"></script>

</head>
<body>
<div class="wrap">
    <div class="pDetail">
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
                <dl>
                    <dt class="price">商品售价：</dt>
                    <dd class="cl_red" class="price" id="price">
                        ¥<?php echo(isset($default['price']) ? $default['price'] : $default['sale']) ?></dd>
                    <dd>
                        <del id="sale"><?php echo(isset($default['price']) ? '¥' . $default['sale'] : '') ?></del>
                    </dd>
                    <dd class="evaluate-count">
                        评价：XX条
                    </dd>
                </dl>
            </div>
            <div class="buy module-box">
                <dl>
                    <dt>颜色：</dt>
                    <dd class="selectBox" id="<?php echo $default['d_id'] ?>"><?php echo $default['category'] ?></dd>
                    <?php foreach ($detailQuery as $default): ?>
                        <dd class="selectBox"
                            id="<?php echo $default['d_id'] ?>"><?php echo $default['category'] ?></dd>
                    <?php endforeach ?>


                    <dt>数量：</dt>
                    <dd>
                        <div class="countBox">
                            <a class="minus number-button" id="minus">-</a>
                            <input class="count" id="number" value="<?php echo $number ?>" maxlength="3" type="tel"/>
                            <a class="plus number-button" id="plus">+</a>
                        </div>
                    </dd>
                </dl>
                <div class="button-box">
                    <!--                    <dt style="visibility: hidden">数量：</dt>-->
                    <button class="buy-now">立即购买</button>
                    <button class="add-cart">加入购物车</button>
                </div>
            </div>
            <!--            <div class="shelves_nav">-->
            <!--                <a class="shelvesNav"href="#"id="getGoodsInf">商品介绍</a>-->
            <!--            </div>-->
            <div class="part module-box">
                <div class="title">
                    配件:
                </div>
                <div class="partInf">
                    <div class="check-box checked"></div>
                    <div class="partDetail">
                        <img src="../g_img/demo2.png"/>
                        <dl>
                            <dt>名称：</dt>
                            <dd>刀组</dd>
                            <dt class="detail">产品详细：</dt>
                            <dd>改款刀组采用双十字结构，很大程度上提高其性能</dd>
                            <dt>价格：</dt>
                            <dd class="price">￥60</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="evaluate module-box">

            </div>
            <div class="g-detail module-box">
                <ul class="detail-nav">
                    <li>商品介绍</li>
                    <li>参数规格</li>
                    <li>售后保障</li>
                </ul>
                <div class="swiper-container" id="detail_swiper">
                    <div class="swiper-wrapper" style="width: 4368px; height: auto">
                        <div class="swiper-slide">
                            <div class="detail-info">

                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="detail-par">

                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="detail-after">

                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    var detailSwiper = new Swiper('#detail_swiper', {
//                            paginationClickable: true,
//                            autoplay: 5000,
//                            lazyLoading: true,
//                            loop: true
                    });
                </script>
            </div>
        </div>

        <?php include_once 'templates/foot.php' ?>
        <div class="toast"></div>
    </div>

</div>
<script>
    var g_id =<?php echo $inf['g_id']?>;
    var d_id = $('#category-select option:selected').val();
    var realPrice =<?php echo (isset($default['price'])? $default['price'] : $default['sale'])?>;//保存在js中的价格
    var number = parseInt($('#number').val());
</script>
<script src="../js/goods-inf.js"></script>
<?php //include 'templates/jssdkIncluder.php'?>
<script>

</script>
</body>

