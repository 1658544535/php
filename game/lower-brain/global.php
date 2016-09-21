<?php
!defined('HN1') && exit('Access Denied.');

define('APP_INC', dirname(__FILE__) . '/inc/');
define('LOG_INC', dirname(dirname(dirname(__FILE__))) . '/logs/');

include_once(APP_INC . 'config.php');
( $isDebug ) ? error_reporting(E_ALL) : error_reporting(0);

include_once(APP_INC . 'ez_sql_core.php');
include_once(APP_INC . 'ez_sql_mysql.php');
include_once(APP_INC . 'functions.php');
include_once(APP_INC . 'wxjssdk.php');

$isTestStatus = true;

$db = new ezSQL_mysql($dbUser, $dbPass, $dbName, $dbHost);
$db->query('SET character_set_connection=' . $dbCharset . ', character_set_results=' . $dbCharset . ', character_set_client=binary');

$jssdk 	= new JSSDK($app_info['appid'], $app_info['secret']);			// 微信JS SDK
$arrWxJsParam = $jssdk->getSignPackage();								// 获取微信JS SDK需注册的参数


header("content-type: text/html; charset=utf-8");
session_start();
date_default_timezone_set('Asia/Shanghai'); //设置默认时区


if ( $isTestStatus )		// 如果是测试
{
	$_SESSION['LowerBrainUser'] = json_decode($strTestuserinfo);
}

//$_SESSION['LowerBrainUser'] = null;

$user_info 		= $_SESSION['LowerBrainUser'];


define('MCKEY', 'TAOZHUMAM2CMCKEYGAME' );
$openid_lock 	= mc_encrypt( $user_info->openid, MCKEY);									// 获取加密后的openid




// 全局定义微信JS SDK数据参数
define('WXJSDEBUG', ( $isTestStatus ) ? 'true' : 'false');
define('WXJSAPPID',$arrWxJsParam['appId']);
define('WXJSTIMESTAMP',$arrWxJsParam['timestamp']);
define('WXJSNONCESTR',$arrWxJsParam['nonceStr']);
define('WXJSSIGNATURE',$arrWxJsParam['signature']);
define('WEBLINK', "{$site_game}?cid={$openid_lock}&entry=indexshare");
define('WEBDESC','分享pk赢取更多兑换码');
define('WEBLOGO','http://weixinm2c.taozhuma.com/images/user_photo.png');
define('WEBTITLE','最贱大脑邀请你参与');


?>