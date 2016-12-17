<?php
define('HN1', true);

header("content-type: text/html; charset=utf-8");
session_start();
date_default_timezone_set('Asia/Shanghai');//设置默认时区

define('SYSTEM_ROOT', dirname(__FILE__).'/');
define('APP_INC', SYSTEM_ROOT.'includes/inc/');

$isTest =  in_array($_SERVER['SERVER_NAME'], array('www.maduoduo.loc', 'duo.taozhuma.com', '10.10.66.50', 'wxloc.choupinhui.net', 'flymouse.tunnel.phpor.me')) ? true : false;

include_once(APP_INC.'ez_sql_core.php');
include_once(APP_INC.'ez_sql_mysql.php');
include_once(APP_INC.'functions.php');
include_once(APP_INC.'Model.class.php');

$isTest ? include_once(APP_INC.'debug_config.php') : include_once(APP_INC.'config.php');

$db = new ezSQL_mysql($dbUser, $dbPass, $dbName, $dbHost);
$db->query('SET character_set_connection='.$dbCharset.', character_set_results='.$dbCharset.', character_set_client=binary');

$Model = new Model($db, 'external_link_log');
$flag = isset($_GET['t']) ? trim($_GET['t']) : '';

$data = array(
	'flag' => $flag,
	'ip' => GetIP(),
	'time' => time(),
	'source' => 0,
);
$Model->add($data);

include "tpl/zhuan_web.php";
?>