<?php

function VIEW($msg){
//    mylog('it work');

}
function kf_create_session($msg){

}
function kf_close_session($msg){
    updateWechatMode($msg['from'],'normal');
}