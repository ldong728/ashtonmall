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
    <div class="inf">
        立即订购并获得免费送货服务，订购数量有限
    </div>
    <div class="p-remark">
        <div class="p-remark-content">
            认证企业
        </div>
        <div class="p-remark-content">
            免运费
        </div>
        <div class="p-remark-content">
            销量18件
        </div>
        <div class="p-remark-content">
            库存96件
        </div>

        <div class="price">
            RMB <?php echo((isset($default['price'])) ? $default['price'] : $default['sale']) ?>
        </div>
    </div>
    <!--                <dl>-->
    <!--                    <dt class="price">商品售价：</dt>-->
    <!--                    <dd class="cl_red" class="price" id="price">-->
    <!--                        ¥-->
    <?php //echo(isset($default['price']) ? $default['price'] : $default['sale']) ?><!--</dd>-->
    <!--                    <dd>-->
    <!--                        <del id="sale">-->
    <?php //echo(isset($default['price']) ? '¥' . $default['sale'] : '') ?><!--</del>-->
    <!--                    </dd>-->
    <!--                    <dd class="evaluate-count">-->
    <!--                        评价：--><?php //echo $review['num']?><!--条-->
    <!--                    </dd>-->
    <!--                </dl>-->
</div>
<div class="part module-box">
    <div class="title">
        <div class="line-number"> 1</div>
        <div class="title-name">选择套餐:</div>

    </div>
    <div class="scroll-box">
        <div class="part-box">
            <?php foreach ($parts as $r): ?>
                <div class="partInf">
                    <img class="part-img" src="../<?php echo $r['url'] ?>"/>

                    <div class="check-box <?php echo $r['dft'] ?>" id="part<?php echo $r['g_id'] ?>"></div>
                    <div class="part-name">
                        <?php echo $r['name'] ?>
                    </div>
                </div>
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
        <div class="title-name">选择功能</div>
    </div>
    
</div>
<div class="buy module-box">
    <dl>
        <dt>颜色：</dt>
        <dd class="selectBox detail-selected"
            id="dtl<?php echo $default['d_id'] ?>"><?php echo $default['category'] ?></dd>
        <?php foreach ($detailQuery as $default): ?>
            <dd class="selectBox"
                id="dtl<?php echo $default['d_id'] ?>"><?php echo $default['category'] ?></dd>
        <?php endforeach ?>


        <dt>数量：</dt>
        <dd>
            <div class="countBox">
                <a class="minus number-button" id="minus">-</a>
                <input readonly="1" class="count" id="number" value="<?php echo $number ?>" maxlength="3" type="tel"/>
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

<div class="review module-box">
    <div class="title">
        <p class="titleName">评价：</p>

        <p class="reviewCount">共<?php echo $review['num'] ?>条评价</p>
    </div>
    <div class="horizonborder"></div>
    <div class="keyword-block">

    </div>

    <?php foreach ($review['inf'] as $row): ?>
        <div class="review-content">
            <div class="nameblock">
                <p class="name"><?php echo $row['nickname'] ?></p>
                <?php for ($i = 0; $i < $row['score']; $i++): ?>
                    <div class="score"></div>
                <?php endfor ?>
                <p class="time"><?php echo date('Y-m-d', strtotime($row['review_time'])) ?></p>
            </div>
            <div class="text">
                <?php echo $row['review'] ?>
            </div>
            <div class="imgbox">

            </div>
            <div class="cate">
                颜色：<?php echo $row['category'] ?>
            </div>


        </div>
    <?php endforeach ?>

    <div class="more-review">
        查看全部评价
    </div>

</div>
<div class="g-detail module-box">
    <div class="detail-nav">
        <div class="nav nav-selected" id="nav0">商品介绍</div>
        <div class="slash"></div>
        <div class="nav" id="nav1">参数规格</div>
        <div class="slash"></div>
        <div class="nav" id="nav2">售后保障</div>
    </div>
    <div class="swiper-container" id="detail_swiper">
        <div class="swiper-wrapper" style="width: 4368px; height: auto">
            <div class="swiper-slide">
                <div class="detail-info">
                    <?php echo $inf['inf'] ?>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="detail-par">
                    <table>
                        <?php foreach ($parm as $k => $v): ?>
                            <tr>
                                <td colspan="2"><?php echo $k ?></td>
                            </tr>
                            <?php foreach ($v as $row): ?>
                                <tr>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['value'] ?></td>
                                </tr>
                            <?php endforeach ?>

                        <?php endforeach ?>
                    </table>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="detail-after">
                    <?php echo $remark['remark'] ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        var detailSwiper = new Swiper('#detail_swiper', {
            onSlideChangeEnd: function (a) {

                $('.nav').removeClass('nav-selected');
                $('#nav' + a.activeIndex).addClass('nav-selected');
            }
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
    var d_id = $('.detail-selected').attr('id').slice(3);
    var realPrice =<?php echo (isset($default['price'])? $default['price'] : $default['sale'])?>;//保存在js中的价格
    var number = parseInt($('#number').val());
    var parts = new Array();
</script>
<script src="../js/goods-inf.js"></script>
<?php //include 'templates/jssdkIncluder.php'?>
<script>

</script>
</body>

