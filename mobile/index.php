<?php
/**
 * Created by PhpStorm.
 * User: godlee
 * Date: 2015/10/20
 * Time: 11:44
 */
include_once '../includePackage.php';
session_start();


if (!isset($_SESSION['cate'])) {
    $cate = pdoQuery('category_overview_view', null, null, '');
   $_SESSION['cate']['cateCount']=0;
    foreach ($cate as $caRow) {
        $_SESSION['cate']['cateCount']++;
       $_SESSION['cate']['cateName'][]=$caRow;
    }
}
    $query=pdoQuery('user_promotion_view',null,null,null);
foreach ($query as $row) {
    $row['price']=getSdpPrice($row['id']);
    $promotion[$row['sc_id']][]=$row;
}

if (isset($_GET['c_id'])) {
    $_SESSION['customerId'] = $_GET['c_id'];
    $inf=pdoQuery('custom_inf_tbl',null,array('openid'=>$_SESSION['customerId']),' limit 1');

    $_SESSION['userInf']=$inf->fetch();
}
$state=isset($_SESSION['sdp']['sdp_id'])? $_SESSION['sdp']['sdp_id'] : 'root';
$url='https://open.weixin.qq.com/connect/oauth2/authorize?'
    .'appid='.APP_ID
    .'&redirect_uri='.urlencode('http://'.$_SERVER['HTTP_HOST'].'/'.DOMAIN.'/mobile/controller.php?oauth=1')
    .'&response_type=code&scope=snsapi_base'
    .'&state='.$state.'#wechat_redirect';
//mylog($url);
$config = getConfig('config/config.json');
$adQuery = pdoQuery('ad_tbl', null, null, '');
foreach ($adQuery as $adRow) {
    $adList[$adRow['category']][] = $adRow;
}
$indexRmark=pdoQuery('index_remark_tbl',null,null,null);
$menuid=$_SESSION['sdp']['level']>1?2:$_SESSION['sdp']['level'];
mylog('level:'.$menuid);
$menuQuery=pdoQuery('sdp_menu_tbl',null,null,' where level like "%'.$menuid.'%" limit 5');
foreach ($menuQuery as $row) {
    $menu[]=$row;
}


include 'view/index.html.php';
exit;