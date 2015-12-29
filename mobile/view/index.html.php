<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/mobile-index-swiper.min.css"/>
    <link rel="stylesheet" href="stylesheet/myswiper.css"/>
    <script src="../js/swiper.min.js"></script>
</head>

<body>
<div class="wrap">

    <div class="swiper-container" id="ad-swiper">
        <div class="swiper-wrapper" style="width: 4368px; height: 91vh">
            <?php foreach ($adList['banner'] as $row): ?>
                <div class="swiper-slide"><a
                        href="<?php echo isset($row['url']) ? $row['url'] : 'controller.php?goodsdetail=1&g_id=' . $row['g_id'] ?>">
                        <img class="swiper-img swiper-lazy" data-src="../<?php echo $row['img_url'] ?>"/></a>
                </div>
            <?php endforeach ?>
        </div>
        <div class="swiper-pagination" id="ad-pagination"></div>
    </div>
    <div class="foot-nav">
        <div class="category-nav">
            <div class="space"></div>
            <?php foreach ($maincate as $row): ?>
                <div class="nave-block"id="<?php echo $row['id'] ?>"onclick="selectCate(this)"><?php echo $row['name'] ?></div>
                <div class="nave-slash"></div>
            <?php endforeach ?>
        </div>
        <div class="con-nav">
            <div class="icon-block">
                <div class="icon user-center">
                </div>
                <p class="icon-name">个人中心</p>
            </div>

            <div class="icon-block">
                <div class="icon kf"></div>
                <p class="icon-name">在线客服</p>
            </div>

        </div>

    </div>
    <div class="foot">


    </div>
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
<script>


</script>

</body>

