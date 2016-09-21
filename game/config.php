<?php
!defined('HN1') && exit('Access Denied.');


$dbHost = 'localhost';
$dbUser = 'fenxiao';
$dbPass = 'qunyu236f';
$dbName = 'fenxiao';

$dbCharset 		= 'utf8';
$pfx 			= 'f_';
$site 			= 'http://weixinm2c.taozhuma.com/';				// 网站地址
//$site 			= 'http://tzm/';				// 网站地址
$site_admin 	= 'http://m2c.taozhuma.com/doLogin.do';				// 网站后台地址
$site_image		= 'http://www.taozhuma.com/upfiles/';				// 获取图片地址
$site_game 		= $site . 'game/lower-brain';						//游戏地址
$site_game_bg 	= $site . 'game/lower-brain/admin_bg';				// 游戏后台地址
$site_name		= '淘竹马玩具分销平台';//网站名称

$app_info = array(
	'appid' => 'wx19431beb4245a295',
	'secret' => 'fb56cff9272208efd323b8030cb8d840'
);

$isDebug 		 = false;											// 开启程序调试模式
$isTestStatus 	 = true;											// 是否测试状态
$strTestuserinfo = '{"id":"6","name":"dennis","openid":"o6MuHtzGVyS8xi5VxCs3RjhEhQfk","img":"phone.png","isExchange":"0","time":"1430901706"}';
$mc_key 		 = 'tzmm2c';


//游戏配置信息
$dataStr = file_get_contents( dirname(__FILE__) . '/game.ini' );	// 读取配置文件
$objData = json_decode( $dataStr );
define('GAME_ERROR_NUM',  $objData->error_num);						// 允许错误数
define('GAME_SUCCESS_SCROE',  $objData->success_scroe);			// 通关数
define('ALLOW_MATH_GAME_TIME',$objData->math_game_time);		// 同个场次允许比较的相隔时间

?>