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
    $promotion[$row['sc_id']][]=$row;

}
//mylog(getArrayInf($inf));

if (isset($_GET['c_id'])) {
    $_SESSION['customerId'] = $_GET['c_id'];
    $inf=pdoQuery('custom_inf_tbl',null,array('openid'=>$_SESSION['customerId']),' limit 1');

    $_SESSION['userInf']=$inf->fetch();
}
$config = getConfig('config/config.json');
$adQuery = pdoQuery('ad_tbl', null, null, '');
foreach ($adQuery as $adRow) {
    $adList[$adRow['category']][] = $adRow;
}
$indexRmark=pdoQuery('index_remark_tbl',null,null,null);

include 'view/index.html.php';