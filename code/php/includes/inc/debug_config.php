<?php
!defined('HN1') && exit('Access Denied.');

/*============================== 数据库配置信息  =============================================*/
//开发
$dbHost = '10.10.66.250';
$dbUser = 'maduoduo';
$dbPass = 'maduoduo123';
$dbName = 'maduoduo';

//本地
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'root';
$dbName = 'maduoduo';

//测试
$dbHost = '120.25.81.49';
$dbUser = 'maduoduo1';
$dbPass = 'maduoduo123';
$dbName = 'maduoduo';

/*============================== 网站的基本配置信息  =============================================*/

$dbCharset 		= 'utf8';
$pfx 			= 'f_';
$site 			= ( $isTest ) ? 'http://tzm/' : 'http://weixinm2c.taozhuma.com/';		// 网站地址
$site_admin 	= 'http://pinwx.taozhuma.com/doLogin.do';									// 网站后台地址
$site_image		= 'http://pinwx.taozhuma.com/upfiles/';								// 获取图片地址
$site_name		= '拼得好';//网站名称



/*============================== 微信配置信息  =============================================*/

//$app_info = array(
//	'appid' => 'wx9d700af5085c2b6a',
//	'secret' => 'd582b0f73e82a729391ffbd9f6c75c1c'
//);

$app_info = array(
    'appid' => 'wx3eea553d8ab21caa',
    'secret' => '8a8eaaeda77febffb186e26e42572df6'
);

/*============================== 基本配置  =============================================*/

//$JSSDKCONFIRE = array(
//	'WXJSDEBUG'		=> 'true',
//	'WXJSAPPID'		=> 'a',
//	'WXJSTIMESTAMP'	=> '123456',
//	'WXJSNONCESTR'	=> '123456',
//	'WXJSSIGNATURE'	=> '123456',
//	'WEBLINK'		=> 'http://pinwx.taozhuma.com',
//	'WEBDESC'		=> '拼得好',
//	'WEBLOGO'		=> 'http://pinwx.taozhuma.com/images/user_photo.png',
//	'WEBTITLE'		=> '拼得好'
//);
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