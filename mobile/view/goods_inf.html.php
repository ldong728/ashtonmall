<head>
    <?php include 'templates/header.php'?>
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
                    <span class="pro_name"><?php echo $inf['name']?></span>
                </div>
                <dl>
                    <dt class="price">商品售价：</dt>
                    <dd class="cl_red"class="price"id="price">¥<?php echo (isset($default['price'])? $default['price'] : $default['sale'])?></dd>
                    <dd>
                        <del id="sale"><?php echo (isset($default['price'])? '¥'.$default['sale'] : '')?></del>
                    </dd>
                    <dd class="evaluate-count">
                        评价：XX条
                    </dd>
                </dl>
            </div>
            <div class="buy">
                <dl>
                    <dt>颜色：</dt>
                    <dd class="selectBox"id="<?php echo $default['d_id']?>"><?php echo $default['category']?></dd>
                            <?php foreach($detailQuery as $default):?>
                                <dd class="selectBox"id="<?php echo $default['d_id']?>"><?php echo $default['category']?></dd>
                            <?php endforeach?>


                    <dt>数量：</dt>
                    <dd>
                        <div class="countBox">
                            <a class="minus number-button"id="minus">-</a>
                            <input class="count"id="number"value="<?php echo $number?>"maxlength="3"type="tel"/>
                            <a class="plus number-button"id="plus">+</a>
                        </div>
                    </dd>
                </dl>
                <div class="button-box">

                </div>
            </div>
            <div class="shelves_nav">
                <a class="shelvesNav"href="#"id="getGoodsInf">商品介绍</a>
            </div>
        </div>
        <div class="pro_desc"id="goodsInf"style="display: none">
        </div>
        <div class="fixedMenuBox">
            <div class="buttonSet">
                <a class="buyBtn"href="controller.php?settleAccounts=1">去结算</a>
                <a class="cartBtn"id="add-to-cart">放入购物车</a>
                <a class="goCart"href="controller.php?getCart=1"></a>
            </div>
        </div>
        <div class="toast"></div>
    </div>

</div>
<script>
    var g_id=<?php echo $inf['g_id']?>;
    var d_id=$('#category-select option:selected').val();
    var realPrice=<?php echo (isset($default['price'])? $default['price'] : $default['sale'])?>;//保存在js中的价格
    var number=parseInt($('#number').val());
</script>
<script src="../js/goods-inf.js"></script>
<?php include 'templates/jssdkIncluder.php'?>
<script>

</script>
</body>

