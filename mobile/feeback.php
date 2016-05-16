<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/21
 * Time: 13:06
 */
include_once '../includePackage.php';;
session_start();
if(isset($_SESSION['customerId'])&&isset($_SESSION['sdp_id'])){
    if (isset($_POST['feeback'])) {
        $feebackConfig=getConfig('config/feebackCon.config');
        $amount=$_POST['amount'];
        $minAmount=$feebackConfig['minAmount'];
        $maxAmount=$feebackConfig['maxAmount'];
        if($amount<$minAmount||$amount>$maxAmount){
            echo "金额错误";
            exit;
        }
        $openid=$_SESSION['customerId'];
        $sdp_id=$_SESSION['sdp_id'];
        $infQuery=pdoQuery('sdp_user_tbl',null,array('sdp_id'=>$sdp_id,'open_id'=>$openid),' limit 1');
        $inf=$infQuery->fetch();
        if(!inf){
            echo '账户异常';
            exit;
        }
        $totalBalence=verifyAccount($sdp_id);
        $total_count=pdoQuery('sdp_record_tbl',array('sum(fee) as total_count'),array('sdp_id'=>$sdp_id),null);
        $total_count=$total_count->fetch();
        $query=pdoQuery('sdp_feeback_tbl',null,array('sdp_id'=>$sdp_id,stu=>'0'),'limit 1');
        if($feebackUnhandle=$query->fetch()){//有尚未处理的返佣订单
            echo '返佣申请已提交';
            exit;
        }
        $feeback_id='fb'.time().rand(1000,9999);
        pdoInsert('sdp_feeback_tbl',array('id'=>$sdp_id,'sdp_id'=>$sdp_id,'amount'=>$amount,'create_time'=>time(),));

        if(!$totalBalence||$total_count['total_count']!=$totalBalence){
            pdoUpdate('sdp_feeback',array('account_stu'=>'0'),array('id'=>$feeback_id));
            echo "返佣申请已提交";
            exit;
        }
        $date = array();
        $date['mch_appid'] = APP_ID;
        $date['mchid'] = MCH_ID;
        $date['nonce_str'] = getRandStr(32);
        $date['spbill_create_ip'] = $_SERVER['REMOTE_ADDR'];
        $date['partner_trade_no'] = $feeback_id;
        $date['check_name'] = 'OPTION_CHECK';
        $date['re_user_name'] = $inf['name'];
        $date['amount'] = $amount*100;
        $date['desc'] = '返佣';
        $date['openid'] = $openid;
        $sign = makeSign($date, KEY);
        $date['sign'] = $sign;
        $xml = toXml($date);
        $url='https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $return=curl_post_ssl($url,$xml);
        $return =json_decode($return,true);

        echo 'ok';

        exit;

    }
}

