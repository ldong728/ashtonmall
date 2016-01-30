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
                <div class="swiper-slide">
<!--                    <a href="--><?php //echo isset($row['url']) ? $row['url'] : 'controller.php?goodsdetail=1&g_id=' . $row['g_id'] ?><!--">-->
                        <img class="swiper-img swiper-lazy" data-src="../<?php echo $row['img_url'] ?>"/>
<!--                    </a>-->
                </div>
            <?php endforeach ?>
        </div>
        <div class="swiper-pagination" id="ad-pagination"></div>
    </div>
    <div class="toast"></div>
    <?php include_once 'templates/foot.php'?>
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

