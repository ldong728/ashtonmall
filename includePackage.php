<?php



//以下为阿诗顿官方商城专用
define('ADMIN','ashton');
define('PASSWORD','ashton626123');
define('APP_ID','wx95e53b5f53dcda07');
define('APP_SECRET','942547013c401e4e9cd5caa6f99b9849');
define('WEIXIN_ID','gh_731c5a4a679e');
define('MCH_ID','null');
define('KEY','null');
define("TOKEN", "ashtonmall20160223");
define('DOMAIN',"ashton");
define('NOTIFY_URL',"now is null");
define('DB_IP','121.40.162.180');
define("DB_NAME","web_ashton");
define("DB_USER","web_ashton");
define("DB_PSW","JzcMrB2016");
$mypath = $_SERVER['DOCUMENT_ROOT'] . '/'.DOMAIN;   //用于直接部署
$template_key_order='s0dJnPTO7QBMEbTOGyJYiyKfbBJQl_edLTUHUptb2OE';//模板网购成功通知
$template_key_express='mMYIk-pQqoJYwbtTIKmTVSw5wkKqUMBgJkbScQmwYEM';//模板快递物流提醒






include_once $mypath . '/includes/magicquotes.inc.php';
include_once $mypath . '/includes/db.inc.php';
include_once $mypath . '/includes/helpers.inc.php';
include_once $mypath.'/includes/db.class.php';
include_once $mypath . '/includes/ashton.php';
header("Content-Type:text/html; charset=utf-8");