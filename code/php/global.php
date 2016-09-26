<?php
!defined('HN1') && exit('Access Denied.');

header("content-type: text/html; charset=utf-8");
session_start();
date_default_timezone_set('Asia/Shanghai'); 							// 设置默认时区

define('APP_INC', dirname(__FILE__) . '/includes/inc/');
define('LOG_INC', dirname(__FILE__) . '/logs/');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
define('LOGIC_ROOT',  dirname(__FILE__).'/logic/');						// 未来优化后删除
define('FUNC_ROOT', dirname(__FILE__) . '/includes/func/');
define('LIB_ROOT', dirname(__FILE__) . '/includes/lib/');
define('WXPAID_ROOT', dirname(__FILE__) . '/wxpay/');
define('MODEL_DIR', dirname(__FILE__) . '/logic/Model/');

$isTest =  ($_SERVER['SERVER_NAME'] == 'www.maduoduo.loc') ? true : false;			// 是否为测试模式

//数据接口
define('API_URL', 'http://rap.taozhuma.com/mockjsdata/2');

/*============================== 加载基本文件 =============================================*/
include_once(APP_INC . 'ez_sql_core.php');
include_once(APP_INC . 'ez_sql_mysql.php');
include_once(APP_INC . 'functions.php');
include_once(APP_INC . 'wxjssdk.php');
include_once(APP_INC . 'db.php');
include_once(APP_INC . 'inic_log.php');
include_once(APP_INC . 'Model.class.php');
include_once(APP_INC . 'sys_parameter.php');


if ( $isTest )
{
	include_once(APP_INC . 'debug_config.php');
}
else
{
	include_once(APP_INC . 'config.php');
}

/*============================== 初始化 =============================================*/
$db 	= new ezSQL_mysql($dbUser, $dbPass, $dbName, $dbHost);
$db->query('SET character_set_connection=' . $dbCharset . ', character_set_results=' . $dbCharset . ', character_set_client=binary');
$log    = new Log();


/*============================== 线上线下信息配置 =============================================*/
if ( ! $isTest )																		// 线上配置
{
	//error_reporting(0);																	// 禁止报错
	$allow_not_weixin = array( 'page','wxpay','hongbao' );								// 允许非微信浏览器返回的功能

	if ( ! in_array( get_now_func(), $allow_not_weixin ))								// 如果该功能不是允许非微信浏览器范围
	{
		if ( ! is_weixin() )															// 判断是否通过微信登录
		{
			redirect('/page.php?type=not_allow');
			return;
		}
	}
}
else
{
	error_reporting(E_ALL);
	error_reporting(0);

	if(empty($_SESSION['userinfo'])){
		$test = $db->get_row("select * from sys_login where `loginname`='15816620443'");

		$_SESSION['userinfo'] 	= $test;
		$_SESSION['openid'] 	= '1111112222333445555566666777888';//"o6MuHtwL7s7gntl6xYmXHikcD6zQ";
		$_SESSION['is_login']	= empty($test) ? false : true;

		$__testWXUserInfo = array(
			'openid' => $_SESSION['openid'],
			'nickname' => '测试昵称',
			'unionid' => '111111199',
			'headimgurl' => 'http://wx.qlogo.cn/mmopen/PiajxSqBRaEJKhQAPsIWmuMdVDPichItjJp9ejypBuZsE6lRFqkXp9B3nFqpwkVwtibd04kEicuRhuMr24IofQics1A/0',
			'sex' => 1,
			'province' => '广东省',
			'city' => '汕头市',
		);
	}
}



/*============================== 如果还未微信登录（即openid为空）则先进行微信登录 =============================================*/
//微信支付异步回调通知不进行登录
if($_SERVER['SCRIPT_NAME'] != '/wxpay/notify_url.php'){
	if( isset($_SERVER['DOCUMENT_URI']) )
	{
		if ($_SERVER['DOCUMENT_URI'] != '/login.php'  && $_SERVER['DOCUMENT_URI'] != '/page.php' && $_SERVER['DOCUMENT_URI'] != '/validate.php' )
		{
			IS_USER_WX_LOGIN();
		}
	}
	else
	{
		$dontCheckScriptName = array('/login', '/login.php', '/page.php', '/validate.php', '/product_detail', '/product_detail.php');
		$needCheckScriptName = array('/user_binding', '/user_binding.php', '/user_registered', '/user_registered.php');
//		if ($_SERVER['SCRIPT_NAME'] != '/login'  && $_SERVER['SCRIPT_NAME'] != '/login.php' && $_SERVER['SCRIPT_NAME'] != '/page.php' && $_SERVER['SCRIPT_NAME'] != '/validate.php' )
		if(!in_array($_SERVER['SCRIPT_NAME'], $dontCheckScriptName))
		{
			IS_USER_WX_LOGIN();
		}
	}
}

/*============================== 用户参数设置 =============================================*/
$user 	 		= isset($_SESSION['userinfo'])  ? $_SESSION['userinfo'] : null;
$openid  		= isset($_SESSION['openid']) 	? $_SESSION['openid'] 	: null;			// 用openid来判断是否已触发登录页
$unionid  		= isset($_SESSION['unionid']) 	? $_SESSION['unionid'] 	: null;			// 用unionid来判断是否已触发登录页
$bLogin 		= isset($_SESSION['is_login'])	? $_SESSION['is_login'] : FALSE;		// 用is_login来判断是否已绑定
$SHARP_URL 		= WEBLINK;

if ( $user != null )
{
	$userid			= $user->id;
}

//不配送的省份id，甘肃 海南 内蒙古 宁夏 青海 西藏 新疆
$unSendProviceIds = array(29,22,6,31,27,32);
?>