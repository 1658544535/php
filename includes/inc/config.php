<?php
!defined('HN1') && exit('Access Denied.');

/*============================== 数据库配置信息  =============================================*/

$dbHost = '120.25.81.49';
$dbUser = 'maduoduo1';
$dbPass = 'maduoduo123';
$dbName = 'maduoduo';

/*============================== 网站的基本配置信息  =============================================*/

$dbCharset 		= 'utf8';
$pfx 			= 'f_';
$site 			= ( $isTest ) ? 'http://pinwx.taozhuma.com/' : 'http://pinwx.taozhuma.com/';		// 网站地址
$site_admin 	= 'http://pinwx.taozhuma.com/doLogin.do';									// 网站后台地址
$site_image		= 'http://pinwx.taozhuma.com/upfiles/';									// 获取图片地址
$site_name		= '拼得好';//网站名称

/*============================== 微信配置信息  =============================================*/

$app_info = array(
	'appid' => 'wx3eea553d8ab21caa',
	'secret' => '8a8eaaeda77febffb186e26e42572df6'
);

// === 我自己的
//$app_info = array(
//	'appid' => 'wxf47337e9d960e867',
//	'secret' => 'd0033914647c2924375edd9f4df6a1a6',
//    'encodingaeskey' => 'p9Hxd1yYgcXJIOCCsSrBvNLMuoSBYbJ7zBaIxsR6p4w',
//    'token' => 'weixin123',
//);

//$app_info = array(
//	'appid' => 'wx9d700af5085c2b6a',
//	'secret' => 'd582b0f73e82a729391ffbd9f6c75c1c'
//);

///*============================== 基本配置  =============================================*/
//$jssdk 	= new JSSDK($app_info['appid'], $app_info['secret']);			// 微信JS SDK
//$arrWxJsParam = $jssdk->getSignPackage();								// 获取微信JS SDK需注册的参数
//
//$JSSDKCONFIRE = array(
//	'WXJSDEBUG'		=> 'false',
//	'WXJSAPPID'		=> $arrWxJsParam['appId'],
//	'WXJSTIMESTAMP'	=> $arrWxJsParam['timestamp'],
//	'WXJSNONCESTR'	=> $arrWxJsParam['nonceStr'],
//	'WXJSSIGNATURE'	=> $arrWxJsParam['signature'],
//	'WEBLINK'		=> 'http://pinwx.taozhuma.com',
//	'WEBDESC'		=> '拼得好',
//	'WEBLOGO'		=> 'http://pinwx.taozhuma.com/images/user_photo.png',
//	'WEBTITLE'		=> '拼得好'
//);
//
//
///*============================== 全局定义微信JS SDK数据参数  =============================================*/
//define('WXJSDEBUG', $JSSDKCONFIRE['WXJSDEBUG']);
//define('WXJSAPPID',$JSSDKCONFIRE['WXJSAPPID']);
//define('WXJSTIMESTAMP',$JSSDKCONFIRE['WXJSTIMESTAMP']);
//define('WXJSNONCESTR',$JSSDKCONFIRE['WXJSNONCESTR']);
//define('WXJSSIGNATURE',$JSSDKCONFIRE['WXJSSIGNATURE']);
//define('WEBLINK',$JSSDKCONFIRE['WEBLINK']);
//define('WEBDESC',$JSSDKCONFIRE['WEBDESC']);
//define('WEBLOGO',$JSSDKCONFIRE['WEBLOGO']);
//define('WEBTITLE',$JSSDKCONFIRE['WEBTITLE']);

?>