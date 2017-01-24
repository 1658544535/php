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

define('API_URL', 'http://app.pindegood.com/v3.6');

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
		$keyword = $objWX->getRevContent();
		$wxhbKwId = getWxhbKeywordId($keyword);
		$notExit = true;
		if($wxhbKwId){
			$text = receiveWXHB($wxhbKwId, $objWX->getRevFrom());
			if($text == ''){
				$notExit = false;
			}else{
				$objWX->text($text)->reply();
			}
		}
		if($notExit){
			$replyInfo = __getReplyByKeyword($keyword);
			$replyInfo['kw'] ? $objWX->text($replyInfo['msg'])->reply() : $objWX->transfer_customer_service()->reply();
		}
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
//                        $subscribeMsg = "欢迎关注【拼得好】商城！\r\n①点击【进入商城】右下方领取88元新年红包！\r\n②千元抽奖仅花一毛，一团两人必中！<a href='http://weixin.pindegood.com/lottery_new.php'>立即开团</a>";
						$subscribeMsg = "欢迎关注【拼得好】购物商城！\r\n您还有新年红包未领取！<a href='http://weixin.pindegood.com/transfer.php'>点击领取</a>";
						break;
				}
				$objWX->text($subscribeMsg)->reply();
    			break;
			case Wechat::EVENT_SCAN://扫描带参数二维码
				switch($eventType['key']){
					case '2'://落地页来源
						recordSourceQrcode();
					default:
//						$text = '<a href="'.$siteUrl.'">优质玩具，预购从速，点击进入</a>';
//						$text = "欢迎关注【拼得好】商城！\r\n①点击【进入商城】右下方领取88元新年红包！\r\n②千元抽奖仅花一毛，一团两人必中！<a href='http://weixin.pindegood.com/lottery_new.php'>立即开团</a>";
						$text = "欢迎关注【拼得好】购物商城！\r\n您还有新年红包未领取！<a href='http://weixin.pindegood.com/transfer.php'>点击领取</a>";
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
		'领取' => "恭喜您兑换成功！点击兑换第三波领年货活动礼包进行开团领取！\r\n<a href='http://weixin.pindegood.com/groupon.php?id=8873'>坚果年货礼包>>>戳</a>\r\n【特别注意】组团成功后！公众号回复开团注册手机号码！我们会根据开团填写的地址安排发货！\r\n【福利加强】我们还会在所有成团列表中，抽取整团中奖哦！您跟参团的亲都有可能再中奖！",
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

function getWxhbKeywordId($keyword){
	$file = SYS_ROOT.'data/weixin_hongbao_password.php';
	if(file_exists($file)){
		$list = include_once($file);
	}else{
		global $dbHost, $dbUser, $dbPass, $dbName, $dbCharset;
		include_once(APP_INC.'ez_sql_core.php');
		include_once(APP_INC.'ez_sql_mysql.php');
		include_once(APP_INC.'Model.class.php');

		$db	= new ezSQL_mysql($dbUser, $dbPass, $dbName, $dbHost);
		$db->query('SET character_set_connection='.$dbCharset.', character_set_results='.$dbCharset.', character_set_client=binary');
		$mdl = new Model($db, 'wxhb_password');
		$rs = $mdl->getAll(array(), 'id,password', array('id'=>'asc'));
		$list = array();
		foreach($rs as $v){
			$list[$v->password] = $v->id;
		}
		file_put_contents($file, "<?php\r\nreturn ".var_export($list, true).";\r\n?>");
	}
	return isset($list[$keyword]) ? $list[$keyword] : 0;
}

function receiveWXHB($kwid, $openid){
	global $dbHost, $dbUser, $dbPass, $dbName, $dbCharset;

	$time = time();
	$_dir = LOG_INC.'wxhb_receive/';
	!file_exists($_dir) && mkdir($_dir, 0777, true);
	$logFile = $_dir.date('Y-m-d', $time).'.txt';

	include_once(APP_INC.'ez_sql_core.php');
	include_once(APP_INC.'ez_sql_mysql.php');
	include_once(APP_INC.'Model.class.php');

	$db	= new ezSQL_mysql($dbUser, $dbPass, $dbName, $dbHost);
	$db->query('SET character_set_connection='.$dbCharset.', character_set_results='.$dbCharset.', character_set_client=binary');
	file_put_contents($logFile, "【".date('Y-m-d H:i:s', $time)."】openid[{$openid}]，口令id：{$kwid}，创建数据库连接\r\n", FILE_APPEND);

	$mdlUser = new Model($db, 'sys_login');
	$userInfo = $mdlUser->get(array('openid'=>$openid), 'id,loginname,openid,name', ARRAY_A);
	if(empty($userInfo)) return '<a href="http://weixin.pindegood.com/user_binding.php">请先注册</a>';
	file_put_contents($logFile, "【".date('Y-m-d H:i:s', $time)."】openid[{$openid}]，口令id：{$kwid}，判断用户是否已注册\r\n", FILE_APPEND);

	$mdlReceiveLog = new Model($db, 'wxhb_receive_log');
	$receiveLog = $mdlReceiveLog->get(array('openid'=>$openid));
	if(!empty($receiveLog)) return '您已参与该活动！';
	file_put_contents($logFile, "【".date('Y-m-d H:i:s', $time)."】openid[{$openid}]，口令id：{$kwid}，判断用户是否已参与\r\n", FILE_APPEND);

	$mdlWxHBPwd = new Model($db, 'wxhb_password');
	$mdlWxHBPwd->startTrans();
	$sql = "SELECT * FROM `wxhb_password` WHERE `id`={$kwid} FOR UPDATE";
	$wxhb = $db->get_row($sql, ARRAY_A);
	if(empty($wxhb)) return '';
	file_put_contents($logFile, "【".date('Y-m-d H:i:s', $time)."】openid[{$openid}]，获取口令信息\r\n".var_export($wxhb, true)."\r\n", FILE_APPEND);

	if($wxhb['total'] <= 0) return '该口令已领取完啦！请更换别的拜年口令';
	$sql = 'UPDATE `wxhb_password` SET `total`=`total`-1 WHERE `id`='.$kwid;
	$db->query($sql);
	$mdlWxHBPwd->commit();
	file_put_contents($logFile, "【".date('Y-m-d H:i:s', $time)."】openid[{$openid}]，口令{$wxhb['password']}，减少口令领取红包次数\r\n", FILE_APPEND);

	$time = time();	
	$success = false;
	
	include_once('./wxpay/lib/WxHongBao.Api.php');
	$hongbao = array(
		'openid' => $openid,
		'sendName' => '拼得好',
		'amount' => $wxhb['money']*100,
		'num' => 1,
		'wishing' => '拼得好祝大家身体健康，财源广进',
		'activityName' => '新春红包',
		'remark' => '拼得好祝大家身体健康，财源广进',
	);
	file_put_contents($logFile, "【".date('Y-m-d H:i:s', $time)."】openid[{$openid}]，口令{$wxhb['password']}，设置红包信息参数\r\n".var_export($hongbao, true)."\r\n", FILE_APPEND);
	$hbApi = new WxHongBaoApi();
	$result = $hbApi->sendRedPack($hongbao);
	file_put_contents($logFile, "【".date('Y-m-d H:i:s', $time)."】openid[{$openid}]，口令{$wxhb['password']}，发送红包结果\r\n".var_export($result, true)."\r\n", FILE_APPEND);

	$mdlReceiveLog->startTrans();
	if($result['return_code'] != 'SUCCESS'){
		$content = "openid[{$openid}]口令[{$wxhb['password']}]领取红包失败[return_code:{$result['return_code']}]：{$result['return_msg']}";
		file_put_contents($logFile, "【".date('Y-m-d H:i:s', $time)."】{$content}\r\n", FILE_APPEND);
	}elseif($result['result_code'] != 'SUCCESS'){
		$content = "openid[{$openid}]口令[{$wxhb['password']}]领取红包失败[result_code:{$result['err_code']}]：{$result['err_code_des']}";
		file_put_contents($logFile, "【".date('Y-m-d H:i:s', $time)."】{$content}\r\n", FILE_APPEND);
	}else{
		$rLog = array(
			'openid' => $result['re_openid'],
			'loginname' => $userInfo['loginname'],
			'nickname' => $userInfo['name'],
			'time' => $time,
			'password' => $wxhb['password'],
			'money' => $result['total_amount']/100,
		);
		if($mdlReceiveLog->add($rLog) !== false){
			$mdlSendLog = new Model($db, 'wxhb_send_log');
			$sendLog = array(
				're_openid' => $result['re_openid'],
				'total_amount' => $result['total_amount']/100,
				'send_listid' => $result['send_listid'],
				'mch_billno' => $result['mch_billno'],
				'time' => $time,
			);
			if($mdlSendLog->add($sendLog) !== false){
				$success = true;
				$mdlReceiveLog->commit();
			}else{
				$mdlReceiveLog->rollback();
			}
		}else{
			$mdlReceiveLog->rollback();
		}
	}
	if($success){
		$content = "openid[{$openid}]口令[{$wxhb['password']}]领取红包成功：".($result['total_amount']/100).'元';
		file_put_contents($logFile, "【".date('Y-m-d H:i:s', $time)."】{$content}\r\n", FILE_APPEND);
		return $wxhb['money'].'元红包已发送';
	}else{
		$sql = 'UPDATE `wxhb_password` SET `total`=`total`+1 WHERE `id`='.$kwid;
		$db->query($sql);
		file_put_contents($logFile, "【".date('Y-m-d H:i:s', $time)."】口令领取失败，openid[{$openid}]，口令：{$wxhb['password']}\r\n", FILE_APPEND);
		return '该口令已领取完啦！请更换别的拜年口令';
	}
}
?>