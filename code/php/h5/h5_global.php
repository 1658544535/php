<?php
!defined('HN1') && exit('Access Denied.');

header("content-type: text/html; charset=utf-8");
session_start();
date_default_timezone_set('Asia/Shanghai'); 							// 设置默认时区

$dirFile = dirname(__FILE__).'/';

define('SYSTEM_ROOT', $dirFile.'../');
define('SYSTEM_INC', SYSTEM_ROOT.'includes/inc/');
define('APP_INC', SYSTEM_INC);
define('SYSTEM_LOG', SYSTEM_ROOT.'logs/');
define('SYSTEM_FUNC', SYSTEM_ROOT.'includes/func/');
define('SYSTEM_LIB', SYSTEM_ROOT.'includes/lib/');
define('SYSTEM_MODEL', SYSTEM_ROOT.'logic/Model/');

include_once(SYSTEM_INC.'ez_sql_core.php');
include_once(SYSTEM_INC.'ez_sql_mysql.php');
include_once(SYSTEM_INC.'functions.php');
include_once(SYSTEM_INC.'db.php');
include_once(SYSTEM_INC.'Model.class.php');
include_once(SYSTEM_INC.'wxjssdk.php');

$debugTest = defined('DEBUG_TEST') ? DEBUG_TEST : false;
$sysCfg = $debugTest ? 'debug_config.php' : 'config.php';
include_once(SYSTEM_INC.$sysCfg);

$db = new ezSQL_mysql($dbUser, $dbPass, $dbName, $dbHost);
$db->query('SET character_set_connection='.$dbCharset.',character_set_results='.$dbCharset.',character_set_client=binary');
?>