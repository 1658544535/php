<?php
!defined('HN1') && exit('Access Denied.');

/*============================== 数据库配置信息  =============================================*/

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'taozhumab2c';


/*============================== 网站配置信息  =============================================*/
$dbCharset 	= 'utf8';
//$site 	= "http://b2c/model/ClickFarm/";			// 应用地址
$site 	= "http://10.10.66.17/model/ClickFarm/";			// 应用地址
$site_admin = $site . 'admin/';					// 网站后台地址
$site_name	= '外卖';							// 网站名称
$IMAGE_URL	= $site."upfiles/";					// 全局图片变量



/*============================== 微信配置信息  =============================================*/
$app_info = array(
	'appid' => 'wx19431beb4245a295',
	'secret' => 'fb56cff9272208efd323b8030cb8d840'
);

	$JSSDKCONFIRE = array(
		'WXJSDEBUG'		=> 'true',
		'WXJSAPPID'		=> 'a',
		'WXJSTIMESTAMP'	=> '123456',
		'WXJSNONCESTR'	=> '123456',
		'WXJSSIGNATURE'	=> '123456',
		'WEBLINK'		=> 'http://weixinm2c.taozhuma.com',
		'WEBDESC'		=> '妈妈圈玩具专属特卖',
		'WEBLOGO'		=>'http://weixinm2c.taozhuma.com/images/user_photo.png',
		'WEBTITLE'		=> '淘竹马玩具特卖'
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