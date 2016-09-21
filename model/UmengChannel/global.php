<?php
!defined('HN1') && exit('Access Denied.');
error_reporting(E_ALL);
//error_reporting(0);

//set_magic_quotes_runtime(0);
define('WEB_ROOT', dirname(__FILE__) );
define('APP_INC', 	WEB_ROOT . '/inc/');
define('LOG_INC', 	WEB_ROOT . '/logs/');
define('MODEL_INC',	WEB_ROOT . '/model/');
define('LIB_DIR',	WEB_ROOT . '/lib/');

$isDebug = false;

if ( $isDebug )
{
	include_once(APP_INC . 'debug_config.php');
}
else
{
	include_once(APP_INC . 'config.php');
}

include_once(APP_INC . 'ez_sql_core.php');
include_once(APP_INC . 'ez_sql_mysql.php');
include_once(APP_INC . 'functions.php');
include_once(LIB_DIR.'/Model.class.php');


$db = new ezSQL_mysql($dbUser, $dbPass, $dbName, $dbHost);
$db->query('SET character_set_connection=' . $dbCharset . ', character_set_results=' . $dbCharset . ', character_set_client=binary');
header("content-type: text/html; charset=utf-8");
session_start();


date_default_timezone_set('Asia/Shanghai'); //设置默认时区





?>