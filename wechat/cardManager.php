<?php
//session_start();
include_once  $GLOBALS['mypath']. '/wechat/interfaceHandler.php';
//$mInterface=new interfaceHandler(WEIXIN_ID);


function createCard(array $cardInf){
    $sInterFace=new interfaceHandler(WEIXIN_ID);



}

function uploadLogo($file)
{
    $sInterFace=new interfaceHandler(WEIXIN_ID);
    $back = $sInterFace->uploadFileByCurl('https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=ACCESS_TOKEN', $file,'buffer');
    $backArray=json_decode($back,true);
    if(isset($backArray['url'])){
        return $backArray['url'];
    }else{
        return 'error';
    }

}