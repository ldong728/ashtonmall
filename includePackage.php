<?php
//以下为测试公众号用
//define('APP_ID','wx03393af10613da23');
//define('APP_SECRET','40751854901cc489eddd055538224e8a');
//define('WEIXIN_ID','gh_964192c927cb');
//define('MCH_ID','now is null');
//define('KEY','now is null');
//define("TOKEN", "godlee");
//define('DOMAIN',"mmzrb");
//define('NOTIFY_URL',"now is null");
//define("DB_NAME","gshop_db");
//define("DB_USER","gshopUser");
//define("DB_PSW","cT9vVpxBLQaFQYrh");
//$mypath = $_SERVER['DOCUMENT_ROOT'] . '/'.DOMAIN;   //用于直接部署



////以下为测试号专用
//define('APP_ID','wx03393af10613da23');
//define('APP_SECRET','40751854901cc489eddd055538224e8a');
//define('WEIXIN_ID','gh_964192c927cb');
//define('MCH_ID','now is null');
//define('KEY','now is null');
//define("TOKEN", "godlee");
//define('DOMAIN',"ashtonmall");
//define('NOTIFY_URL',"now is null");
//define("DB_NAME","ashton_db");
//define("DB_USER","aston_db_manager");
//define("DB_PSW","c6cychNznJWGhQC8");
//$mypath = $_SERVER['DOCUMENT_ROOT'] . '/'.DOMAIN;   //用于直接部署


//以下为承天科技支付测试专用
define('ADMIN','hll');
define('PASSWORD','admin');
define('APP_ID','wxe351f7bfd5b5e2a6');
define('APP_SECRET','1eb1e0701b845f183ff2843fcddb4b7e');
define('WEIXIN_ID','gh_bc1d700f0582');
define('MCH_ID','1285420201');
define('KEY','Hlb2005booth20160101hlbbooth0625');
define("TOKEN", "godlee");
define('DOMAIN',"ashtonmall");
define('NOTIFY_URL',"now is null");
define("DB_NAME","ashton_db");
define("DB_USER","aston_db_manager");
define("DB_PSW","c6cychNznJWGhQC8");
$mypath = $_SERVER['DOCUMENT_ROOT'] . '/'.DOMAIN;   //用于直接部署
$template_key_order='XpZKkl2LFqxN95XpKFRKcR7Dxu1Nh9ZCj3ILRzrbMUY';//模板网购成功通知
$template_key_express='OWQiu_I2B-ZpxPDMrJpxU0al1fNN-onZE7uGeUTtcks';//模板快递物流提醒

////以下为新瑞电脑模板消息测试专用
//define('APP_ID','wx0baf4a2c977aea54');
//define('APP_SECRET','c36e5fa132075b7e46537a008d919008');
//define('WEIXIN_ID','gh_904600228e98');
//define('MCH_ID','now is null');
//define('KEY','now is null');
//define("TOKEN", "godlee");
//define('DOMAIN',"ashtonmall");
//define('NOTIFY_URL',"now is null");
//define("DB_NAME","ashton_db");
//define("DB_USER","aston_db_manager");
//define("DB_PSW","c6cychNznJWGhQC8");
//$mypath = $_SERVER['DOCUMENT_ROOT'] . '/'.DOMAIN;   //用于直接部署
//$template_key_order='I3LU5K3-fcFaFgcDkx1nI6TNoXAT__oKT8pa1Xgzng0';//模板网购成功通知
//$template_key_express='bzIhSrV49KZP9MX_7bGOXFc8p0RcswH9YSGCkTqMjXo';//模板快递物流提醒




include_once $mypath . '/includes/magicquotes.inc.php';
include_once $mypath . '/includes/db.inc.php';
include_once $mypath . '/includes/helpers.inc.php';
include_once $mypath.'/includes/db.class.php';
include_once $mypath . '/includes/ashton.php';
header("Content-Type:text/html; charset=utf-8");