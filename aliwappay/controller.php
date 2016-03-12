<?php

include_once '../includePackage.php';
session_start();

//mylog('jump');
if(isset($_GET['createOrder'])){
//    mylog('set');
    $query=pdoQuery('order_tbl',null,array('id'=>$_GET['orderId'],'stu'=>'0'),' limit 1');
    if($orderInf=$query->fetch()){
//        mylog(getArrayInf($orderInf));
//        echo 'ok';
        include 'view/index.html.php';
        exit;

    }else{
        echo 'error';
        exit;

    }
}