<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/mobile-index-swiper.min.css"/>
    <link rel="stylesheet" href="stylesheet/myswiper.css"/>
    <script src="../js/swiper.min.js"></script>
</head>

<body>
<div class="wrap">
    <div class="search-container">
        <input type="text" class="search-box"/>

        <div type="button" class="icon-button"></div>

        <a class="search-button">搜索商品</a>
    </div>

    <div class="swiper-container" id="ad-swiper">
        <div class="swiper-wrapper" style="width: 4368px; height: 240px">
            <?php foreach ($adList['banner'] as $row): ?>
                <div class="swiper-slide">
                    <!--                    <a href="-->
                    <?php //echo isset($row['url']) ? $row['url'] : 'controller.php?goodsdetail=1&g_id=' . $row['g_id'] ?><!--">-->
                    <img class="swiper-img swiper-lazy" data-src="../<?php echo $row['img_url'] ?>"/>
                    <!--                    </a>-->
                </div>
            <?php endforeach ?>
        </div>
        <div class="swiper-pagination" id="ad-pagination"></div>
    </div>
    <div class="hot-sale-container">
        <?php foreach ($promotion as $row): ?>
        <div class="hot-sale-box">
            <div class="hot-sale-blank"></div>
            <div class="hot-sale-content">
                <div class="hot-sale-blank"></div>
                <div class="hot-sale-name">
                    <?php echo $row['name'] ?>
                </div>
                <div class="hot-sale-intro">
                    <?php echo $row['intro'] ?>
                </div>
                <div class="hot-sale-price">
                    RMB:<?php echo $row['price'] ?>
                    <a href="#" class="hot-sale-buy">


                    </a>

                </div>

            </div>
            <div class="hot-sale-image">
                <img src="../<?php echo $row['url'] ?>"/>

            </div>



        </div>
        <?php endforeach ?>
    </div>

    <div class="remark-container">
        <div class="remark-box">
            <div class="imgbox"></div>
            <div class="remark-content">
                <div class="remark-title">
                    官方正品
                </div>
                <div class="remark">
                    阿诗顿官方微商城，不经过任何中间环节，100%原装厂家发货，正品保证
                </div>
            </div>

        </div>
        <div class="remark-box">
            <div class="imgbox"></div>
            <div class="remark-content">
                <div class="remark-title">
                    快递包邮
                </div>
                <div class="remark">
                   本店所有快递均由快递进行配送（特殊活动商品除外）。港澳台及海外地区不支持配送
                </div>
            </div>

        </div>
        <div class="remark-box">
            <div class="imgbox"></div>
            <div class="remark-content">
                <div class="remark-title">
                    无忧售后
                </div>
                <div class="remark">
                   产品一年保修，7天无理由退货，30天质量问题无忧换货
                </div>
            </div>

        </div>
        <div class="remark-box">
            <div class="imgbox"></div>
            <div class="remark-content">
                <div class="remark-title">
                    全国联保
                </div>
                <div class="remark">
                    29000家维修网点，基本覆盖县级以上城市，全国联保，免费服务热线：400-8890-240
                </div>
            </div>

        </div>

    </div>

    <div class="toast"></div>

    <?php include_once 'templates/foot.php' ?>
</div>
<script>
    var swiper = new Swiper('#ad-swiper', {
        pagination: '#ad-pagination',
        paginationClickable: true,
        autoplay: 5000,
        lazyLoading: true,
        loop: true

    });
</script>

<?php //include_once 'templates/jssdkIncluder.php'?>

</body>

