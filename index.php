<?php

include_once 'includePackage.php';
include_once 'wechat/serveManager.php';
include_once 'wechat/cardManager.php';
session_start();

if(isset($_GET['encrypt_code'])){
    $inf=getCardCode($_GET['encrypt_code']);
    mylog(getArrayInf($inf));
    if($inf['errcode']==0){
        $_SESSION['customerId']=$inf['openid'];
        $_SESSION['userInf'] = getUnionId($inf['openid']);
        $_SESSION['userCards']['card_id']=$inf['card']['card_id'];
        header('location:mobile/index.php?rand=' . rand(1000,9999));
    }else{

    }
    exit;
}


echo '404 notFound';
exit;
?>
