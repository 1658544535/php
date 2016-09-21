<?php
!defined('HN1') && exit('Access Denied.');
error_reporting(E_ALL);
//error_reporting(0);

//set_magic_quotes_runtime(0);
define('APP_INC', dirname(__FILE__) . '/inc/');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
define('LOGIC_ROOT',  dirname(__FILE__).'/logic/');
define('LOG_INC', dirname(__FILE__) . '/logs/');

$isDebug = TRUE;

include_once(APP_INC . 'wxjssdk.php');

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
include_once(APP_INC . 'db.php');
require_once( APP_INC . 'log.php' );

$db = new ezSQL_mysql($dbUser, $dbPass, $dbName, $dbHost);
$db->query('SET character_set_connection=' . $dbCharset . ', character_set_results=' . $dbCharset . ', character_set_client=binary');
header("content-type: text/html; charset=utf-8");
session_start();

date_default_timezone_set('Asia/Shanghai'); //设置默认时区


/*============ 判断活动ID ==============*/
if( !isset($_SESSION['shake_activity_id']) )
{
	// 如果活动id不存在，则读取
	require_once( SCRIPT_ROOT . 'logic/shake_activityBean.php');
	$shake_activityBean 	= new shake_activityBean( $db, 'shake_activity' );

	$arrWhere['status'] 	= 1;
	$arrCol 				= array('id','title','starttime','endtime');
	$strOrderBy 			= '`id` DESC';
	$objActivityInfo 		= $shake_activityBean->get_one( $arrWhere, $arrCol, $strOrderBy );

	$_SESSION['shake_activity_id'] = ( $objActivityInfo != null ) ? $objActivityInfo->id : 0;
}

/*============ 输出日志 ==============*/
$file = LOG_INC . 'wx/api_' . date('Y_m_d_H') . '.log';
$CLogFileHandler = new CLogFileHandler($file);
Log::Init( $CLogFileHandler, 1);









?>