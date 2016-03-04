<?php

function VIEW($msg){
//    mylog('it work');

}
function kf_create_session($msg){

}
function kf_close_session($msg){
    updateWechatMode($msg['from'],'normal');
}

function user_get_card($msg){
//    pdoInsert('card_repository_tbl',array('card_id'=>$msg['CardId'],''=>$msg['UserCardCode'],'customer_id'=>$msg['from']),'update');
}
function user_del_card($msg){

    return;
}
function CLICK($msg){
//    mylog('click');
    if($msg['EventKey']=='kf'){
//        mylog('kf');
        sendKFMessage($msg['FromUserName'],'已为您接入人工客服，请稍候');
        $GLOBALS['weixin']->toKFMsg();
    }
    return;
}