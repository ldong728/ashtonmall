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
        if(isset($_SESSION['pms']['add'])){
            printView('admin/view/addgoods.html.php', '添加货品');
            exit;
        }else{
            echo '权限不足';
            exit;
        }

    }
    if (isset($_GET['goods-config'])) {
        if(isset($_SESSION['pms']['edit'])) {
            if (isset($_GET['is_part'])) {
                printView('admin/view/parts_edit.html.php', '配件修改');
                exit;
            }
            printView('admin/view/goods_edit.html.php', '货品修改');
            exit;
        }else{
            echo '权限不足';
            exit;
        }
    }
    if (isset($_GET['category-config'])) {
        if(isset($_SESSION['pms']['cate'])) {
            $category = pdoQuery('category_tbl', null, null, null);
            printView('admin/view/category_config.html.php', '分类修改');
            exit;
        }else{
            echo '权限不足';
            exit;
        }
    }
    if (isset($_GET['promotions'])) {
        if(isset($_SESSION['pms']['index'])) {
            printView('admin/view/promotions.html.php', '首页设置');
            exit;
        }else{
            echo '权限不足';
            exit;
        }
    }
    if (isset($_GET['ad'])) {
        $adQuery = pdoQuery('ad_tbl', null, null, '');
        printView('admin/view/ad.html.php', '广告设置');
        exit;
    }
    if(isset($_GET['orders'])){
        if(isset($_SESSION['pms']['order'])) {
            $query = pdoQuery('express_tbl', null, null, '');
            foreach ($query as $row) {
                $expressQuery[] = $row;
            }
            $orderQuery = pdoQuery('order_view', null, array('stu' => $_GET['orders']), '');
            printView('admin/view/orderManage.html.php', '订单管理');
            exit;
        }else{
            echo '权限不足';
            exit;
        }
    }
    if(isset($_GET['review'])){
        if(isset($_SESSION['pms']['review'])) {
            $limit = isset($_GET['index']) ? ' limit ' . $_GET['index'] . ', 20' : ' limit 20';
            $reviewQuery = pdoQuery('review_tbl', null, array('priority' => '5', 'public' => '0'), $limit);
            foreach ($reviewQuery as $row) {
                $review[] = $row;
            };
            if (null == $review) $review = array();
            printView('admin/view/review.html.php', '评价管理');
            exit;
        }else{
            echo '权限不足';
            exit;
        }
    }
    if(isset($_GET['wechatConfig'])){
        if(isset($_SESSION['pms']['wechat'])) {
            printView('admin/view/wechatConfig.html.php', '微信公众平台');
            exit;
        }else{
            echo '权限不足';
            exit;
        }
    }
    if(isset($_GET['card'])){
        if(isset($_SESSION['pms']['card'])) {
            printView('admin/view/cardManager.html.php', '卡券管理');
            exit;
        }else{
            echo '权限不足';
            exit;
        }
    }
    if(isset($_GET['index'])){
        if(isset($_SESSION['pms']['index'])) {
            $remarkQuery = pdoQuery('index_remark_tbl', null, null, null);
            $frontImg = pdoQuery('ad_tbl', null, array('category' => 'banner'), null);
            printView('admin/view/admin_index.html.php', '阿诗顿官方商城控制台');
            exit;
        }else{
            echo '权限不足';
            exit;
        }
    }
    if(isset($_GET['operator'])){
        if(isset($_SESSION['pms']['operator'])){
            $query=pdoQuery('pms_tbl',null,null,null);
            foreach ($query as $row) {
                $pmsList[$row['key']]=array('value'=>$row['key'],'name'=>$row['name']);
            }
            $query=pdoQuery('pms_view',null,null,null);
            foreach ($query as $row) {
                if(!isset($opList[$row['id']])){
                    $opList[$row['id']]=array(
                        'id'=>$row['id'],
                        'name'=>$row['name'],
                        'pwd'=>$row['pwd'],
                        'pms'=>$pmsList
                    );
//                    $opList[$row['id']]=$pmsList;
                }
                $opList[$row['id']]['pms'][$row['pms']]['checked']='checked';
            }
//            mylog(getArrayInf($opList));
            printView('admin/view/operator.html.php','操作员管理');
            exit;

        }else{
            echo '权限不足';
            exit;
        }
    }
    if(isset($_GET['sdp'])){
        if(isset($_SESSION['pms']['sdp'])){
            if(isset($_GET['level'])){
                $levelQuery=pdoQuery('sdp_level_tbl',null,null,null);
                foreach ($levelQuery as $row) {
                    $levelList[]=$row;
                }
                printView('admin/view/sdpLevel.html.php');
            }


        }else{
            echo '权限不足';
            exit;
        }
    }
    if (isset($_GET['logout'])) {//登出
        session_unset();
        include 'view/login.html.php';
        exit;
    }
    printView('admin/view/blank.html.php','阿诗顿官方商城控制台');
    exit;
} else {
    if (isset($_GET['login'])) {
        $name=$_POST['adminName'];
        $pwd= $_POST['password'];
        if ($_POST['adminName'] . $_POST['password'] == ADMIN.PASSWORD) {
            $_SESSION['login'] = 1;
            $_SESSION['operator_id']=-1;
            $pms=pdoQuery('pms_tbl',null,null,null);
            foreach ($pms as $row) {
                $_SESSION['pms'][$row['key']]=1;
            }
            printView('admin/view/blank.html.php','阿诗顿官方商城控制台');
        }else{
            $query=pdoQuery('operator_tbl',null,array('name'=>$name,'md5'=>md5($pwd)),' limit 1');
            $op_inf=$query->fetch();
            if(!$op_inf){
                include 'view/login.html.php';
                exit;
            }else{
                $_SESSION['login'] = 1;
                $_SESSION['operator_id']=$op_inf['id'];
                $pms=pdoQuery('op_pms_tbl',null,array('o_id'=>$op_inf['id']),null);
                foreach ($pms as $row) {
                    $_SESSION['pms'][$row['pms']]=1;
                }
                printView('admin/view/blank.html.php','阿诗顿官方商城控制台');
                exit;
            }

        }
        exit;
    }
    include 'view/login.html.php';
    exit;
}