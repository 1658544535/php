<?php
define('HN1', true);

header("content-type: text/html; charset=utf-8");
session_start();
date_default_timezone_set('Asia/Shanghai'); 							// 设置默认时区

define('SYS_ROOT', dirname(__FILE__).'/');
define('APP_INC', dirname(__FILE__) . '/includes/inc/');
define('LIB_ROOT', dirname(__FILE__) . '/includes/lib/');
define('LOG_INC', dirname(__FILE__) . '/logs/');

define('API_URL', 'http://app.pindegood.com/v3.5');

$siteUrl = 'http://weixin.pindegood.com/';

include_once(APP_INC.'config.php');
include_once(APP_INC.'functions.php');

//不配送的省份id，甘肃 内蒙古 宁夏 青海 西藏 新疆
$unSendProviceIds = array(29,6,31,30,27,32);

//微信相关配置信息(用于微信类)
$wxOption = array(
    'appid' => $app_info['appid'],
    'appsecret' => $app_info['secret'],
    'token' => $app_info['token'] ? $app_info['token'] : 'weixin',
    'encodingaeskey' => $app_info['encodingaeskey'] ? $app_info['encodingaeskey'] : '',
);
include_once(LIB_ROOT.'/Weixin.class.php');
include_once(LIB_ROOT.'/weixin/errCode.php');
$objWX = new Weixin($wxOption);

$objWX->valid();
$wxReqType = $objWX->getRev()->getRevType();

switch($wxReqType){
	case Wechat::MSGTYPE_TEXT://文本
		break;
	case Wechat::MSGTYPE_EVENT://事件
		$eventType = $objWX->getRevEvent();
		switch($eventType['event']){
    		case Wechat::EVENT_SUBSCRIBE://关注订阅号
				if($eventType['key']){//扫描二维码关注
					$subscribeMsg = '<a href="'.$siteUrl.'free.php?id=17">0元开团，点击领券</a>';
				}else{//正常关注
					$subscribeMsg = '终于等到您~欢迎来到火遍朋友圈、汇聚全球玩具的拼得好，我们为您准备了7.7专区、品牌特卖等好玩实惠的玩具拼团，<a href="'.$siteUrl.'">☞点击进入商城</a>';
				}
				$weObj->text($subscribeMsg)->reply();
    			break;
			case Wechat::EVENT_SCAN://扫描带参数二维码
				$text = '<a href="'.$siteUrl.'">优质玩具，预购从速，点击进入</a>';
				$weObj->text($subscribeMsg)->reply();
				break;
    	}
		break;
}
?>