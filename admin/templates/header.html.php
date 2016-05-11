<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title><?php echo $title ?></title>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="stylesheet/style.css?v=<?php echo rand(1000, 9999) ?>">
    <link href="../uedit/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="stylesheet/style2.css?v=<?php echo rand(1000, 9999) ?>">
<!--    <script src="js/html5.js"></script>-->
    <!--    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>-->
    <!--    <script>-->
    <!--        (function ($) {-->
    <!--            $(window).load(function () {-->
    <!--                $("a[rel='load-content']").click(function (e) {-->
    <!--                    e.preventDefault();-->
    <!--                    var url = $(this).attr("href");-->
    <!--                    $.get(url, function (data) {-->
    <!--                        $(".content .mCSB_container").append(data); //load new content inside .mCSB_container-->
    <!--                        //scroll-to appended content-->
    <!--                        $(".content").mCustomScrollbar("scrollTo", "h2:last");-->
    <!--                    });-->
    <!--                });-->
    <!---->
    <!--                $(".content").delegate("a[href='top']", "click", function (e) {-->
    <!--                    e.preventDefault();-->
    <!--                    $(".content").mCustomScrollbar("scrollTo", $(this).attr("href"));-->
    <!--                });-->
    <!---->
    <!--            });-->
    <!--        })(jQuery);-->
    <!--    </script>-->
</head>

<header>
    <h1><img src="logo/logo.png"/></h1>
    <ul class="rt_nav">
        <li><a href="#" target="_blank" class="website_icon">站点首页</a></li>
        <li><a href="index.php?logout=1" class="quit_icon">安全退出</a></li>
    </ul>
</header>

<body>
<div class="toast"></div>
<aside class="lt_aside_nav content mCustomScrollbar">
    <h2><a href="index.php">起始页</a></h2>
    <ul>
        <li>
            <dl class="main-menu">
                <dt>首页管理</dt>
                <?php if (isset($_SESSION['pms']['index'])): ?>
                <dd style="display: <?php echo isset($_GET['dindex']) ? 'block' : 'none' ?>"><a
                            href="index.php?dindex=1&index=1">首页编辑</a></dd><?php endif ?>
                <?php if (isset($_SESSION['pms']['index'])): ?>
                <dd style="display: <?php echo isset($_GET['dindex']) ? 'block' : 'none' ?>"><a
                            href="index.php?dindex=1&promotions=1">首页商品</a></dd><?php endif ?>
            </dl>
        </li>
        <li>
            <dl class="main-menu">
                <dt>商品信息</dt>
                <!--当前链接则添加class:active-->
                <?php if (isset($_SESSION['pms']['add'])): ?>
                <dd style="display: <?php echo isset($_GET['dgoods']) ? 'block' : 'none' ?>"><a
                            href="index.php?add-goods=1&dgoods=1" >新增商品</a></dd><?php endif ?>
                <?php if (isset($_SESSION['pms']['edit'])): ?>
                <dd style="display: <?php echo isset($_GET['dgoods']) ? 'block' : 'none' ?>"><a
                            href="index.php?goods-config=1&dgoods=1">商品属性</a></dd><?php endif ?>
                <?php if (isset($_SESSION['pms']['cate'])): ?>
                <dd style="display: <?php echo isset($_GET['dgoods']) ? 'block' : 'none' ?>"><a
                            href="index.php?category-config=1&dgoods=1">类别管理</a></dd><?php endif ?>
            </dl>
        </li>
        <li>
            <dl class="main-menu">
                <dt>订单管理</dt>
                <?php if (isset($_SESSION['pms']['order'])): ?>
                <dd style="display: <?php echo isset($_GET['dorder']) ? 'block' : 'none' ?>"><a
                            href="index.php?orders=1&dorder=1">待发货订单</a></dd><?php endif ?>
                <?php if (isset($_SESSION['pms']['order'])): ?>
                <dd style="display: <?php echo isset($_GET['dorder']) ? 'block' : 'none' ?>"><a
                            href="index.php?orders=2&dorder=1">已发货订单</a></dd><?php endif ?>
                <?php if (isset($_SESSION['pms']['order'])): ?>
                <dd style="display: <?php echo isset($_GET['dorder']) ? 'block' : 'none' ?>"><a
                            href="index.php?orders=0&dorder=1">未付款订单</a></dd><?php endif ?>
                <?php if (isset($_SESSION['pms']['order'])): ?>
                <dd style="display: <?php echo isset($_GET['dorder']) ? 'block' : 'none' ?>"><a
                            href="index.php?orders=-1&dorder=1">全部订单</a></dd><?php endif ?>

            </dl>
        </li>

        <li>
            <dl class="main-menu">
                <dt>评价管理</dt>
                <?php if (isset($_SESSION['pms']['review'])): ?>
                <dd style="display: <?php echo isset($_GET['dreview']) ? 'block' : 'none' ?>"><a
                            href="index.php?review=1&dreview=1">查看评价</a></dd><?php endif ?>
            </dl>
        </li>
        <?php if (isset($_SESSION['pms']['review'])): ?>
            <li>
                <dl class="main-menu">
                    <dt>分销系统</dt>
                    <dd style="display: <?php echo isset($_GET['sdp']) ? 'block' : 'none' ?>"><a
                            href="index.php?sdp=1&level=1">等级管理</a></dd>
                    <dd style="display: <?php echo isset($_GET['sdp']) ? 'block' : 'none' ?>"><a
                            href="index.php?sdp=1&usersdp=2&rootsdp=2">分销商管理</a></dd>
                    <dd style="display: <?php echo isset($_GET['sdp']) ? 'block' : 'none' ?>"><a
                            href="index.php?sdp=1&usersdp=1">微商管理</a></dd>
                    <dd style="display: <?php echo isset($_GET['sdp']) ? 'block' : 'none' ?>"><a
                            href="index.php?sdp=1&sdpInf=1">数据分析</a></dd>
                </dl>
            </li>
        <?php endif ?>
        <li>
            <dl class="main-menu">
                <dt>管理员</dt>
                <?php if (isset($_SESSION['pms']['operator'])): ?>
                    <dd><a href="index.php?wechatConfig=1">微信公众号</a></dd>
                    <dd><a href="index.php?operator=1">管理员信息</a></dd><?php endif ?>
            </dl>
        </li>

        <li>
            <p class="btm_infor">© 谷多网络 版权所有</p>
        </li>
    </ul>
</aside>
<script>
    $('dt').click(function () {
        $(this).nextAll('dd').slideToggle('fast');
    });
</script>
<section class="rt_wrap content mCustomScrollbar">
    <div cla="rt_content">


        <!--        --><?php //echo isset($_SESSION['pms']['card'])? '<li><a href="index.php?card=1">优惠券</a></li>':''?>

