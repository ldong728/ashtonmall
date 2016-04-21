<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/21
 * Time: 13:06
 */
if (isset($_POST['feeback'])) {
//    mylog(getArrayInf($_SERVER));

    $query = pdoQuery('order_tbl', null, array('id' => $_POST['order_id'], 'stu' => '0'), ' limit 1');

    if ($inf = $query->fetch()) {
        if (0 == $inf['stu']) {


            $date = array();
            $date['mch_appid'] = APP_ID;
            $date['mch_id'] = MCH_ID;
            $date['nonce_str'] = getRandStr(32);
            $date['spbill_create_ip'] = $_SERVER['REMOTE_ADDR'];
            $date['out_trade_no'] = $_POST['order_id'];
            $date['total_fee'] = $inf['total_fee'] * 100;
            $date['notify_url'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            $date['trade_type'] = 'JSAPI';
            $date['openid'] = $inf['c_id'];
            $sign = makeSign($date, KEY);
            $date['sign'] = $sign;
            $xml = toXml($date);
            $handler = new interfaceHandler(WEIXIN_ID);
            $data = $handler->postByCurl('https://api.mch.weixin.qq.com/pay/unifiedorder', $xml);
            mylog('feeback:' . $data);
            $dataArray = xmlToArray($data);
            $dataJson = json_encode($dataArray, JSON_UNESCAPED_UNICODE);
//            mylog('formated payInf' . getArrayInf($dataArray));
        }
        if ('SUCCESS' == $dataArray['return_code']) {
            if ('SUCCESS' == $dataArray['result_code']) {
                if (signVerify($dataArray)) {
                    $_SESSION['userKey']['package'] = 'prepay_id=' . $dataArray['prepay_id'];
                    echo 'ok';
                    exit;
                }
            } else {
                echo '支付失败，错误代码' . $dataArray['err_code'] . ':' . $dataArray['err_code'] . $dataArray['err_code_des'];
            }
        } else {
            echo $dataArray['return_msg'];
            exit;
        }

        echo $dataJson;
        exit;
    } else {
        echo getOrderStu($inf['stu']);
    }
}