<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title><?php echo $title?></title>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="stylesheet/style.css">
    <link href="../uedit/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<!--    <script type="text/javascript" src="../uedit/third-party/jquery.min.js"></script>-->
<!--    <script type="text/javascript" charset="utf-8" src="../uedit/umeditor.config.js"></script>-->
<!--    <script type="text/javascript" charset="utf-8" src="../uedit/umeditor.min.js"></script>-->
<!--    <script type="text/javascript" src="../uedit/lang/zh-cn/zh-cn.js"></script>-->
</head>

<body>
<div class="toast"></div>

<nav align="center">
    <ul>
        <?php echo isset($_SESSION['pms']['index'])? '<li><a href="index.php?index=1">首页编辑</a></li>':''?>
        <?php echo isset($_SESSION['pms']['add'])? '<li><a href="index.php?add-goods=1">新增商品</a></li>':''?>
        <?php echo isset($_SESSION['pms']['edit'])? '<li><a href="index.php?goods-config=1">商品修改</a> </li>':''?>
        <?php echo isset($_SESSION['pms']['cate'])? '<li><a href="index.php?category-config=1">分类管理</a></li>':''?>
        <?php echo isset($_SESSION['pms']['index'])? '<li><a href="index.php?promotions=1">首页展示</a></li>':''?>
        <?php echo isset($_SESSION['pms']['order'])? '<li><a href="index.php?orders=1">订单管理</a></li>':''?>
        <?php echo isset($_SESSION['pms']['review'])? '<li><a href="index.php?review=1">评价管理</a></li>':''?>
        <?php echo isset($_SESSION['pms']['card'])? '<li><a href="index.php?card=1">优惠券</a></li>':''?>
        <?php echo isset($_SESSION['pms']['wechat'])? '<li><a href="index.php?wechatConfig=1">微信公众号</a></li>':''?>
        <?php echo isset($_SESSION['pms']['operator'])? '<li><a href="index.php?operator=1">操作员管理</a></li>':''?>
        <li><a href="index.php?logout=1">退出</a></li>

    </ul>
</nav>