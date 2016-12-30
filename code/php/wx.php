<?php
define('HN1', true);
error_reporting(0);
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
		$replyInfo = __getReplyByKeyword($objWX->getRevContent());
		$replyInfo['kw'] ? $objWX->text($replyInfo['msg'])->reply() : $objWX->transfer_customer_service()->reply();
		break;
	case Wechat::MSGTYPE_EVENT://事件
		$eventType = $objWX->getRevEvent();
		switch($eventType['event']){
    		case Wechat::EVENT_SUBSCRIBE://关注订阅号
				//扫描二维码场景
				$qrcodeScene = substr($eventType['key'], 8);
				switch($qrcodeScene){
					case '1'://赠免券
						$subscribeMsg = '<a href="'.$siteUrl.'free.php?id=17">0元开团，点击领券</a>';
						break;
					case '2'://落地页来源
						recordSourceQrcode();
					default:
//						$subscribeMsg = '终于等到您~欢迎来到火遍朋友圈、汇聚全球玩具的拼得好，我们为您准备了7.7专区、品牌特卖等好玩实惠的玩具拼团，<a href="'.$siteUrl.'">☞点击进入商城</a>';
//						$subscribeMsg = '终于等到你！我们已经为你准备了猜价格、9.9特卖、掌上秒杀、0.1夺宝等好玩实惠的活动。拼靓价得好货，一切尽在拼得好，<a href="'.$siteUrl.'">☞点击进入商城</a>';
                        $subscribeMsg = "欢迎关注【拼得好】商城！\r\n①点击【进入商城】右下方领取88元新年红包！\r\n②千元抽奖仅花一毛，一团两人必中！<a href='http://weixin.pindegood.com/lottery_new.php'>立即开团</a>";
						break;
				}
				$objWX->text($subscribeMsg)->reply();
    			break;
			case Wechat::EVENT_SCAN://扫描带参数二维码
				switch($eventType['key']){
					case '2'://落地页来源
						recordSourceQrcode();
					default:
						$text = '<a href="'.$siteUrl.'">优质玩具，预购从速，点击进入</a>';
						break;
				}
				$objWX->text($text)->reply();
				break;
    	}
		break;
	default:
		$objWX->transfer_customer_service()->reply();
		break;
}
//通过关键字获取回复消息
function __getReplyByKeyword($keyword){
	$_dir = LOG_INC.'keyword_reply/';
	!file_exists($_dir) && mkdir($_dir, 0777, true);

	//关键字=>回复内容
	$keywordMap = array(
		'0.1' => '<a href="http://weixin.pindegood.com/free.php?id=18">戳 >> 0元夺宝，成团必中，开团即得好礼！</a>',
		'水画布' => '<a href="http://weixin.pindegood.com/coupon_action.php?linkid=37&aid=148">水画布低至9.9元新用户秒杀开抢中，您还在犹豫点不点的时候，已经有1689人领取了！☞链接！</a>',
//		'领玩具' => '<a href="http://weixin.pindegood.com/free.php?id=18">双十一返场，狂欢不打烊！1000份 免费玩具再狂送，点击马上领取☞☞☞+领</a>',
		'纸巾' => '<a href="http://weixin.pindegood.com/groupon.php?id=771">湿水不易破 ，6包维达抽取式三层纸巾，狂欢免费送，已有2626人领取成功！快戳 ☞链接！</a>',
		'兑奖' => "①点击<a href=\"http://weixin.pindegood.com/user_binding.php\">注册</a>拼得好帐号\r\n②回复“兑奖码+注册手机号”\r\n③点击<a href=\"http://weixin.pindegood.com/user_info.php?act=coupon\">马上领取！</a>\r\n（兑奖时间：09:00-17:30）",
//        '领年货' => "【好友联盟领年货】活动规则：\r\n①点击左下方菜单【领年货】-【专属海报】\r\n②发给好友/朋友圈，获得扫码支持，攒福气值\r\n③福气值达到即可点击左下角菜单【领年货】-【我的年货】兑换\r\n温馨提示：福气值越高，可兑换年货更高级哦！更有<a href='http://weixin.pindegood.com/lottery_new.php'>1毛团长必中夺宝</a>等着您！",
	);
	$keywordMap['1毛'] = $keywordMap['0.1夺宝'] = $keywordMap['夺宝'] = $keywordMap['0.1'];
	$keywordMap['优惠券'] = $keywordMap['水画布活动'] = $keywordMap['优惠券活动'] = $keywordMap['水画布'];
//	$keywordMap['免费领玩具'] = $keywordMap['送玩具'] = $keywordMap['领'] = $keywordMap['免费送玩具'] = $keywordMap['免费拿玩具'] = $keywordMap['免费玩具'] = $keywordMap['免费'] = $keywordMap['领玩具'];
	$keywordMap['免费送'] = $keywordMap['湿水不易破'] = $keywordMap['纸巾活动'] = $keywordMap['纸巾'];
	$keywordMap['游戏'] = $keywordMap['游戏兑奖'] = $keywordMap['兑奖'];
//    $keywordMap['年货'] = $keywordMap['领 年货'] = $keywordMap['领年货'];
	$result = isset($keywordMap[$keyword]) ? array('kw'=>true, 'msg'=>$keywordMap[$keyword]) : array('kw'=>false);
	$time = time();
	$content = $keywordMap[$keyword] ? "{$keywordMap[$keyword]}\r\n\r\n" : "\r\n";
	file_put_contents($_dir.date('Y-m-d', $time).'.txt', "【".date('Y-m-d H:i:s', $time)."】关键字：{$keyword}\r\n{$content}", FILE_APPEND);
	return $result;
}

function recordSourceQrcode(){
	global $dbHost, $dbUser, $dbPass, $dbName;
	include_once(APP_INC.'ez_sql_core.php');
	include_once(APP_INC.'ez_sql_mysql.php');
	include_once(APP_INC.'Model.class.php');

	$db	= new ezSQL_mysql($dbUser, $dbPass, $dbName, $dbHost);
	$db->query('SET character_set_connection='.$dbCharset.', character_set_results='.$dbCharset.', character_set_client=binary');

	$data = array(
		'flag' => 2,
		'ip' => GetIP(),
		'time' => time(),
		'source' => 1,
	);
	$Model = new Model($db, 'external_link_log');
	$Model->add($data);
}
?>