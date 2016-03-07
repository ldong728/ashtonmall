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
        <a href="controller.php?getList=1&c_id=<?php echo $cate['id']?>"><div class="category-name">
            <?php echo $cate['e_name']?>
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
                    <div class="p-remark-content">
                        认证企业
                    </div>
                    <div class="p-remark-content">
                        免运费
                    </div>
                    <div class="p-remark-content">
                        销量<?php echo $review['num']?>件
                    </div>

                    <div class="price">
                        RMB <?php echo $price = ((isset($default['price'])) ? $default['price'] : $default['sale']) ?>
                    </div>
                </div>
            </div>
            <div class="part module-box">
                <div class="title">
                    <div class="line-number"> 1</div>
                    <div class="title-name">选择套餐:</div>

                </div>
                <div class="scroll-box">
                    <div class="part-box">
                        <?php if(count($parts)>0)foreach ($parts as $r): ?>
                            <div class="partInf">
                                <img class="part-img" src="../<?php echo $r['url'] ?>"/>
                                <input type="hidden" value="<?php echo $r['sale'] ?>"/>
                                <div class="check-box <?php echo $r['dft'] ?>" id="part<?php echo $r['g_id'] ?>"></div>
                                <div class="part-name">
                                    <?php echo $r['name'] ?>
                                </div>
                            </div>
                            <?php if ($r['dft'] == 'checked')$price += $r['sale'] ?>
                        <?php endforeach ?>
                        <?php if(isset($coop))foreach ($coop as $r): ?>
                            <a href="controller.php?goodsdetail=1&g_id=<?php echo $r['g_id'] ?>" >
                                <div class="partInf">
                                    <img class="part-img" src="../<?php echo $r['url'] ?>"/>

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
                    <div class="title-name">选择功能</div>
                </div>
                <div class="param-container">
<!--                    <dl class="clearfix">-->
<!--                        <dt>品牌：</dt>-->
<!--                        <dd>ashton/阿诗顿</dd>-->
<!--                    </dl>-->
                    <?php if(isset($parm['概况']))foreach ($parm['概况'] as $row): ?>
                        <dl style="float: left">
                            <dt><?php echo $row['name']?>：</dt>
                            <dd><?php echo $row['value']?></dd>
                        </dl>
                    <?php endforeach ?>
                    <?php foreach ($parm[''] as $row): ?>
                        <dl style="float: left">
                            <dt><?php echo $row['name']?>：</dt>
                            <dd><?php echo $row['value']?></dd>
                        </dl>
                    <?php endforeach ?>
<!--                    <dl style="float: left">-->
<!--                        <dt>a</dt>-->
<!--                        <dd>b</dd>-->
<!--                    </dl>-->
                </div>
            </div>

            <div class="detail module-box">
                <div class="title" id="cate-title">
                    <div class="line-number">3</div>
                    <div class="title-name">选择颜色</div>
                    <div class="select">
                        <div class="background"></div>

                        <div id="select-display"><?php echo $default['category'] ?></div>
                        <select id="category-select">
                            <option id="<?php echo $default['d_id'] ?>" value="<?php echo $default['d_id'] ?>"
                                    selected="selected">
                                <?php echo $default['category'] ?></option>
                            <?php foreach ($detailQuery as $default): ?>
                                <option id="<?php echo $default['d_id'] ?>" value="<?php echo $default['d_id'] ?>">
                                    <?php echo $default['category'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="title" id="count-title">
                    <div class="line-number">4</div>
                    <div class="title-name">选择数量</div>
                    <div class="countBox">
                        <a class="minus number-button" id="minus">-</a>
                        <input readonly="1" class="count" id="number" value="<?php echo $number ?>" maxlength="3"
                               type="tel"/>
                        <a class="plus number-button" id="plus">+</a>
                    </div>
                </div>


            </div>
            <div class="module-box others">
                <div class="others-nav">
                    <div class="others-content" id="detail">
                        <a class="detail-select"href="#detail-content">看详情</a>
                    </div>
                    <div class="others-content"id="remark">
                        <a class="detail-select"href="#detail-review">看评价</a></div>
                    <div class="others-content">
                        <a class="detail-select"id="compare"href="#detail-compare">拼价格</a></div>
<!--                    <div class="others-content">-->
<!--                        <a class="detail-select">晒颜值</a></div>-->

<!--                    <div class="others-content">-->
<!--                        <a class="detail-select">分销加盟</a></div>-->
                </div>
            </div>
            <div class="module-box mult-content">
                <div class="default-content video-container"id="video-content">
                    <video controls="controls" src="../g_img/video/<?php echo $inf['produce_id']?>.mp4" width="90%" height="auto">
<!--                        <source src="../g_img/video/--><?php //echo $inf['produce_id']?><!--.mp4">-->
                    </video>
                </div>
                <div class="hidden-content detail"id="detail-content"style="max-height: 15000px">
                    <?php echo $inf['inf']?>
                </div>
                <div class="hidden-content review"id="detail-review">
                    <?php foreach($review['inf'] as $row):?>
                        <div class="review-content">
                            <div class="nameblock">
                                <p class="name"><?php echo $row['nickname']?></p>
                                <?php for($i=0; $i<$row['score'];$i++):?>
                                    <div class="score"></div>
                                <?php endfor?>
                                <p class="time"><?php echo date('Y-m-d',strtotime($row['review_time']))?></p>
                            </div>
                            <div class="text">
                                <?php echo $row['review']?>
                            </div>
                            <div class="imgbox">
                            </div>
                            <div class="cate">
                                颜色：<?php echo $row['category']?>
                            </div>
                        </div>
                    <?php endforeach?>
                    <div class="more-review">
                        查看全部评价
                    </div>
                </div>
                <div class="hidden-content compare"id="detail-compare">
                    <a href="http://search.jd.com/Search?keyword=阿诗顿%20<?php echo $inf['produce_id']?>&enc=utf-8&wq=%E9%98%BF%E8%AF%97%E9%A1%BF%20<?php echo $inf['produce_id']?>"><img src="../img/jd.jpg"/> </a>
                </div>

            </div>
<!--            <div class="g-detail module-box">-->
<!--                <div class="detail-nav">-->
<!--                    <div class="nav nav-selected"id="nav0">商品介绍</div>-->
<!--                    <div class="slash"></div>-->
<!--                    <div class="nav"id="nav1">参数规格</div>-->
<!--                    <div class="slash"></div>-->
<!--                    <div class="nav"id="nav2">售后保障</div>-->
<!--                </div>-->
<!--                <div class="swiper-container" id="detail_swiper">-->
<!--                    <div class="swiper-wrapper" style="width: 4368px; height: auto">-->
<!--                        <div class="swiper-slide">-->
<!--                            <div class="detail-info">-->
<!--                                --><?php //echo $inf['inf']?>
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="swiper-slide">-->
<!--                            <div class="detail-par">-->
<!--                                <table>-->
<!--                                    --><?php //foreach($parm as $k=>$v):?>
<!--                                        <tr><td colspan="2">--><?php //echo $k?><!--</td></tr>-->
<!--                                        --><?php //foreach($v as $row):?>
<!--                                            <tr><td>--><?php //echo $row['name']?><!--</td><td>--><?php //echo $row['value']?><!--</td></tr>-->
<!--                                        --><?php //endforeach?>
<!---->
<!--                                    --><?php //endforeach ?>
<!--                                </table>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="swiper-slide">-->
<!--                            <div class="detail-after">-->
<!--                                --><?php //echo $remark['remark']?>
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <script>-->
<!--                    var detailSwiper = new Swiper('#detail_swiper', {-->
<!--                        onSlideChangeEnd: function(a){-->
<!--                            $('.nav').removeClass('nav-selected');-->
<!--                            $('#nav'+a.activeIndex).addClass('nav-selected');-->
<!--                        }-->
<!--                    });-->
<!--                </script>-->
<!--            </div>-->
<!--        </div>-->

        </div>
    </div>


    <!--    --><?php //include_once 'templates/foot.php' ?>
    <div class="foot">
        <div class="total-price">合计￥<?php echo($price * $number) ?></div>
        <a class="cart"href="controller.php?getCart=1$rand=<?php echo rand(1000,9999)?>"></a>
<!--        <a class="foot-goods-nave"href="index.php">-->
<!--            首页-->
<!--        </a>-->
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
    var d_id = $('#category-select option:selected').val();
    var realPrice =<?php echo (isset($default['price'])? $default['price'] : $default['sale'])?>;//保存在js中的价格
    var number = parseInt($('#number').val());
    var parts = new Array();
</script>
<script src="../js/goods-inf.js"></script>
<script>
    $('.detail-select').click(function(){
       var id=$(this).attr('id');
        $('default-content').css('display','none');
        $('#'+id+'-content').css('display','block');
    });
</script>
<?php include_once 'templates/jssdkIncluder.php'?>
<script>

</script>
</body>

