<?php

include_once '../includePackage.php';
session_start();

if (!isset($_SESSION['mq']) || !isset($_SESSION['smq'])) {
    init();
}
else{
}
if (isset($_SESSION['login'])) {
    if (isset($_GET['add-goods'])) {
        printView('admin/view/addgoods.html.php', '添加货品');
        exit;
    }
    if (isset($_GET['goods-config'])) {
        if(isset($_GET['is_part'])){
            printView('admin/view/parts_edit.html.php', '配件修改');
            exit;
        }
        printView('admin/view/goods_edit.html.php', '货品修改');
        exit;
    }
    if (isset($_GET['category-config'])) {
        $category=pdoQuery('category_tbl',null,null,null);
        printView('admin/view/category_config.html.php', '分类修改');
        exit;
    }
    if (isset($_GET['promotions'])) {

        printView('admin/view/promotions.html.php', '促销设置');
        exit;
    }
    if (isset($_GET['ad'])) {
        $adQuery = pdoQuery('ad_tbl', null, null, '');
        printView('admin/view/ad.html.php', '广告设置');
        exit;
    }
    if(isset($_GET['orders'])){

        $db=new DB(DB_NAME,DB_USER,DB_PSW);
        $query=$db->pdoQuery('express_tbl',null,null,'');
        foreach ($query as $row) {
            $expressQuery[]=$row;
        }

        $orderQuery=$db->pdoQuery('order_view',null,array('stu'=>$_GET['orders']),'');
        printView('admin/view/orderManage.html.php','订单管理');
        exit;
    }
    if(isset($_GET['review'])){
        $limit=isset($_GET['index'])?' limit '.$_GET['index'].', 20':' limit 20';
        $reviewQuery=pdoQuery('review_tbl',null,array('priority'=>'5','public'=>'0'),$limit);
        foreach ($reviewQuery as $row) {
           $review[]=$row;
        };
        if(null==$review)$review=array();

        printView('admin/view/review.html.php','评价管理');
        exit;
    }
    if(isset($_GET['wechatConfig'])){
        printView('admin/view/wechatConfig.html.php','微信公众平台');
        exit;
    }
    if(isset($_GET['card'])){
        printView('admin/view/cardManager.html.php','卡券管理');
        exit;
    }
    if (isset($_GET['logout'])) {//登出
        session_unset();
        include 'view/login.html.php';
        exit;
    }
    $frontImg=pdoQuery('ad_tbl',null,array('category'=>'banner'),null);
    printView('admin/view/admin_index.html.php');
    exit;
} else {
    if (isset($_GET['login'])) {
        if (md5($_POST['adminName']) . md5($_POST['password']) == '9f6c470eab19fdca07401196068f78d554b51a86e539d9f8f711e67826ea60d5') {
            $_SESSION['login'] = 1;
            $frontImg=pdoQuery('ad_tbl',null,array('category'=>'banner'),null);
            printView('admin/view/admin_index.html.php');
        }
        exit;
    }
    include 'view/login.html.php';
    exit;
}