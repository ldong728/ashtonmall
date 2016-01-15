<?php
/**
 * Created by PhpStorm.
 * User: godlee
 * Date: 2015/10/20
 * Time: 11:44
 */
include_once '../includePackage.php';
session_start();


if (!isset($_SESSION['maincate'])) {
    $cate = pdoQuery('category_view', null, null, '');
    $maincate = array();
    foreach ($cate as $caRow) {
        $maincate[$caRow['father_id']] = array('name' => $caRow['father_name'], 'id' => $caRow['father_id']);
    }
    $_SESSION['maincate'] = $maincate;
}
if (isset($_GET['c_id'])) {
    $_SESSION['customerId'] = $_GET['c_id'];
    $inf=pdoQuery('custom_inf_tbl',null,array('openid'=>$_SESSION['customerId']),' limit 1');
    $_SESSION['userInf']=$inf->fetch();
    mylog(getArrayInf($_SESSION['userInf']));
}
$config = getConfig('config/config.json');
$adQuery = pdoQuery('ad_tbl', null, null, '');
foreach ($adQuery as $adRow) {
    $adList[$adRow['category']][] = $adRow;
}

include 'view/index.html.php';