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

//以下为hll专用
//define('APP_ID','wxcdd3501520e8d5ec');
//define('APP_SECRET','27ce61390f76cc6583704c1d20dbcf14');
//define('MCH_ID','now is null');
//define('KEY','now is null');
//define('WEIXIN_ID','gh_74edee1a1cc6');
//define("TOKEN", "godlee");
//define('DOMAIN',"mmzrb");
//define("DB_NAME","mmzrb_db");
//define("DB_USER","mmzrb");
//define("DB_PSW","godlee1394");
//$mypath = $_SERVER['DOCUMENT_ROOT'] . '/'.DOMAIN;   //用于直接部署

//以下为ashtonmall专用
define('APP_ID','wx03393af10613da23');
define('APP_SECRET','40751854901cc489eddd055538224e8a');
define('WEIXIN_ID','gh_964192c927cb');
define('MCH_ID','now is null');
define('KEY','now is null');
define("TOKEN", "godlee");

define('DOMAIN',"ashtonmall");
define('NOTIFY_URL',"now is null");
define("DB_NAME","ashton_db");
define("DB_USER","aston_db_manager");
define("DB_PSW","c6cychNznJWGhQC8");
$mypath = $_SERVER['DOCUMENT_ROOT'] . '/'.DOMAIN;   //用于直接部署

include_once $mypath . '/includes/magicquotes.inc.php';
include_once $mypath . '/includes/db.inc.php';
include_once $mypath . '/includes/helpers.inc.php';
include_once $mypath.'/includes/db.class.php';
include_once $mypath . '/includes/ashton.php';
header("Content-Type:text/html; charset=utf-8");