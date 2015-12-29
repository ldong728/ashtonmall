<?php
include_once '../includePackage.php';
include_once $GLOBALS['mypath'] . 'wechat/interfaceHandler.php';
session_start();

//include 'view/wxpay.html.php';


if (isset($_post['prePay'])) {
    $query = pdoQuery('order_tbl', null, array('id' => $_POST['order_id'], 'stu' => 0), ' limit 1');
    if ($inf = $query->fetch()) {
        $date = array();
        $date['appid'] = APP_ID;
        $date['mch_id'] = MCH_ID;
        $date['nonce_str'] = getRandStr(32);
        $date['body'] = 'gshopPay';
        $date['spbill_create_ip'] = $_POST['thisIp'];
        $date['out_trade_no'] = $_POST['order_id'];
        $date['total_fee'] =$inf['total_fee']*100;
        $date['notify_url']="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        $date['trade_type']='JSAPI';
        $date['openid']=$inf['c_id'];
        $sign=makeSign($date,KEY);
        $date['sign']=$sign;
        $xml=toXml($date);

    }


}