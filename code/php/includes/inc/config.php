<?php
!defined('HN1') && exit('Access Denied.');

/*============================== 数据库配置信息  =============================================*/

$dbHost = '10.10.66.250';
$dbUser = 'maduoduo';
$dbPass = 'maduoduo123';
$dbName = 'maduoduo';

/*============================== 网站的基本配置信息  =============================================*/

$dbCharset 		= 'utf8';
$pfx 			= 'f_';
$site 			= ( $isTest ) ? 'http://tzm/' : 'http://weixinm2c.taozhuma.com/';		// 网站地址
$site_admin 	= 'http://m2c.taozhuma.com/doLogin.do';									// 网站后台地址
$site_image		= 'http://b2c.taozhuma.com/upfiles/';									// 获取图片地址
$site_name		= '拼得好';//网站名称



/*============================== 微信配置信息  =============================================*/

$app_info = array(
	'appid' => '',
	'secret' => ''
);

/*============================== 基本配置  =============================================*/
$jssdk 	= new JSSDK($app_info['appid'], $app_info['secret']);			// 微信JS SDK
$arrWxJsParam = $jssdk->getSignPackage();								// 获取微信JS SDK需注册的参数

$JSSDKCONFIRE = array(
	'WXJSDEBUG'		=> 'false',
	'WXJSAPPID'		=> $arrWxJsParam['appId'],
	'WXJSTIMESTAMP'	=> $arrWxJsParam['timestamp'],
	'WXJSNONCESTR'	=> $arrWxJsParam['nonceStr'],
	'WXJSSIGNATURE'	=> $arrWxJsParam['signature'],
	'WEBLINK'		=> 'http://weixinm2c.taozhuma.com',
	'WEBDESC'		=> '拼得好',
	'WEBLOGO'		=>'http://weixinm2c.taozhuma.com/images/user_photo.png',
	'WEBTITLE'		=> '拼得好'
);


/*============================== 全局定义微信JS SDK数据参数  =============================================*/
define('WXJSDEBUG', $JSSDKCONFIRE['WXJSDEBUG']);
define('WXJSAPPID',$JSSDKCONFIRE['WXJSAPPID']);
define('WXJSTIMESTAMP',$JSSDKCONFIRE['WXJSTIMESTAMP']);
define('WXJSNONCESTR',$JSSDKCONFIRE['WXJSNONCESTR']);
define('WXJSSIGNATURE',$JSSDKCONFIRE['WXJSSIGNATURE']);
define('WEBLINK',$JSSDKCONFIRE['WEBLINK']);
define('WEBDESC',$JSSDKCONFIRE['WEBDESC']);
define('WEBLOGO',$JSSDKCONFIRE['WEBLOGO']);
define('WEBTITLE',$JSSDKCONFIRE['WEBTITLE']);

?>