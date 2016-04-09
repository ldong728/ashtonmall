<head>
    <?php include 'templates/header.php'?>
    <link rel="stylesheet" href="stylesheet/customer_inf.css"/>
</head>
<body>
<div class="wrap">
    <div class="memberHome">
        <div class="user_info">
            <p class="username">
                欢迎你，
                <span><?php echo $_SESSION['userInf']['nickname']?></span>
            </p>
<!--            <div class="memberRank mr1"></div>-->
        </div>

        <div class="mymanage">
            <a class="myManage1"href="controller.php?getCart=1">我的购物车
                <i class="iright"></i></a>
            <a class="myManage5">完善用户信息

        </div>

    </div>

</div>
<?php include_once 'templates/foot.php'?>
<script>


</script>
</body>