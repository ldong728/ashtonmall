<?php

include_once '../includePackage.php';
include_once $GLOBALS['mypath'].'/wechat/interfaceHandler.php';
include_once $GLOBALS['mypath'].'/wechat/wechat.php';
$weixin=new wechat(WEIXIN_ID);
$myHandler=new interfaceHandler(WEIXIN_ID);
$weixin->valid();
$msg=$weixin->receiverFilter();
$random=rand(1000,9999);
mylog(getArrayInf($msg));
$t='您现在访问的是一个演示电商型微网站的公众号，商城内的商品仅供展示，其显示的售价不能作为商品实际价格的参考依据';
$to=$msg['FromUserName'];
if($msg['content']=='网店'){
//        sendTemplateManage($to,'oMhzLlRCMJ_vXQKQL9Yx12DsG8fXlIUzcz0qz4kb9SI','http://www.qq.com',$tmpmsg);
    $myUrl='您的网店入口为http://115.29.202.69/gshop/mobile/?c_id='.$msg['from'].'&#38;rand='.$random.'请勿转发此网址，否则可能导致个人信息泄露';
    $weixin->replytext($myUrl);
}else{
    $weixin->replytext($t);
}





//sendTemplateManage($tempmsg);
//$ttt=json_encode($tmpmsg,JSON_UNESCAPED_UNICODE);
//mylog($ttt);
//$back=$myHandler->postArrayByCurl('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=ACCESS_TOKEN',$tmpmsg);
//mylog($back);
