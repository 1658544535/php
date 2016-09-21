<?php
!defined('HN1') && exit('Access Denied.');

/*============================== 数据库配置信息  =============================================*/

//$dbHost = 'localhost';
//$dbUser = 'root';
//$dbPass = '';
//$dbName = 'taozhumab2c';

$dbHost = 'localhost';
$dbUser = 'taozhumab2c';
$dbPass = 'b2c123456f';
$dbName = 'taozhumab2c';


/*============================== 网站配置信息  =============================================*/
$dbCharset 	= 'utf8';
$site 	= "http://weixinm2c.taozhuma.com/activity/shake/";			// 应用地址
$site_admin = $site . 'admin/';					// 网站后台地址
$site_name	= '外卖';							// 网站名称
$IMAGE_URL	= $site."upfiles/";					// 全局图片变量



/*============================== 微信配置信息  =============================================*/
$app_info = array(
	'appid' => 'wx19431beb4245a295',
	'secret' => 'fb56cff9272208efd323b8030cb8d840'
);

	$jssdk 	= new JSSDK($app_info['appid'], $app_info['secret']);			// 微信JS SDK
	$arrWxJsParam = $jssdk->getSignPackage();								// 获取微信JS SDK需注册的参数
	$access_token = $jssdk->get_AccessToken();								// 获取微信接口凭证

	$JSSDKCONFIRE = array(
		'WXJSDEBUG'		=> 'false',
		'WXJSAPPID'		=> $arrWxJsParam['appId'],
		'WXJSTIMESTAMP'	=> $arrWxJsParam['timestamp'],
		'WXJSNONCESTR'	=> $arrWxJsParam['nonceStr'],
		'WXJSSIGNATURE'	=> $arrWxJsParam['signature'],
		'WEBLINK'		=> 'http://weixinm2c.taozhuma.com/activity/shake/index.php',
		'WEBDESC'		=> '竹马摇一摇,立即赢大奖！',
		'WEBLOGO'		=>'http://weixinm2c.taozhuma.com/images/user_photo.png',
		'WEBTITLE'		=> '竹马摇一摇,立即赢大奖！'
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