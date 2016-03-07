<?php
/**
 * Created by PhpStorm.
 * User: godlee
 * Date: 2016/3/6
 * Time: 23:49
 */
include_once '../includePackage.php';


$query=pdoQuery('user_g_inf_view',array('g_id','produce_id','url','situation'),null,null);
foreach ($query as $row) {
    $url='https://open.weixin.qq.com/connect/oauth2/authorize?'
        .'appid='.APP_ID
        .'&redirect_uri='.urlencode('http://web.gooduo.net/ashton/mobile/controller.php?oauth=1&share='.$row['g_id'].'&part='.$row['situation'])
        .'&response_type=code&scope=snsapi_base'
        .'&state=123#wechat_redirect';
    $urls[]=array('id'=>$row['id'],
    'produce_id'=>$row['produce_id'],
    'img'=>$row['url'],
    'url'=>$url);
}
include 'view/goods_url.html.php';

