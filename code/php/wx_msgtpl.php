<?php
define('HN1', true);
//require_once ('global.php');

error_reporting(E_ALL);

header("content-type: text/html; charset=utf-8");
session_start();
date_default_timezone_set('Asia/Shanghai'); 							// 设置默认时区

define('SYS_ROOT', dirname(__FILE__).'/');
define('APP_INC', dirname(__FILE__) . '/includes/inc/');
define('LIB_ROOT', dirname(__FILE__) . '/includes/lib/');
define('LOG_INC', dirname(__FILE__) . '/logs/');

define('API_URL', 'http://app.pindegood.com/v3.5');
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

$time = time();

$act = trim($_REQUEST['act']);

$_logDir = LOG_INC.'msgtpl/'.$act.'/';
!file_exists($_logDir) && mkdir($_logDir, 0777, true);
$_logFile = $_logDir.$act.'_'.date('Y-m-d', $time).'.txt';

//测试版本
$isDemo =  in_array($_SERVER['SERVER_NAME'], array('weixin.pindegood.com')) ? false : true;

//各操作对应的模板id
$tplMap = array(
	//正式环境
	'online' => array(
		'pay' => 'HijtVshBey8vWEiheh97ih_VCMndYZv28ouP2lnyTa0',
		'open' => 'q6Kaj6ncMMCNAXWniidB8yH0AOgdSjuQ_b3J9dreWiI',
		'join' => 'JUakJR3M_mE7MnrDGf_1kbWsmNAjTnUb458XYwn6aSM',
		'delivery' => 'EGztXez9id31kHrJZo6i-pY6523kx15PDgvC80Qw658',
		'raffle01' => array(
			'win' => 'kbBLSKrbhq4niAIZ9_HnsYOicBKPADhouKpHvknmvig',
		),
		'guess' => 'kbBLSKrbhq4niAIZ9_HnsYOicBKPADhouKpHvknmvig',
		'join_fail' => 'pP41fxH24PzPaKArwxh9LixWfluEI5gu328xix46MWM',
	),
	//测试环境
	'demo' => array(
		'pay' => 'VccXSm9yOGQf5wh134ZJU1WeRScWhi1MIjRBcWOAA20',
		'open' => 'kzB9_8I5Dl3nByE1AZy8-qrVuLVXXZD7uZJDhifDqPI',
		'join' => '8z5eCo87R5RO6EATUlbP1O6WjKRLLdgPzPt89K6VyZ8',
		'delivery' => 'kehyZ0py0ftUpe56CiUqs-rR9VsP1BII5Cb49x5JrMk',
		'raffle01' => array(
			'win' => 'cb_Dmqcz5sJSkVw1spO4-Ao4bkUUhLxmzdQmx_0VtKM',
		),
		'guess' => '8DpmIFPjeiY4qHV932XN8oLTN1F2UgFd_Cepy94p_XM',
		'join_fail' => 'aYY7dRR0oH8X3kDUjIsgkutJRyPzJkbJT3UWWk-agMM',
	),
);
$tplIds = $isDemo ? $tplMap['demo'] : $tplMap['online'];

switch($act){
    case 'pay'://支付
		exit();
		$tplParam = array(
			'openid' => trim($_REQUEST['openid']),
			'factPrice' => trim($_REQUEST['factPrice']),
			'productName' => trim($_REQUEST['productName']),
		);
		$_logInfo = "【".date('Y-m-d H:i:s', $time)."】发送支付通知开始，openid：{$tplParam['openid']}，实付金额：{$tplParam['factPrice']}，商品：{$tplParam['productName']}\r\n";
		file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		$data = array(
			'touser' => $tplParam['openid'],
			'template_id' => $tplIds['pay'],//'HijtVshBey8vWEiheh97ih_VCMndYZv28ouP2lnyTa0',
			'url' => $site,//.'order_detail.php?oid='.$orderId,
			'topcolor' => '#000000',
			'data' => array(
				'first' => array(
					'value' => '恭喜您支付成功！',
					'color' => '#000000',
				),
				'keyword1' => array(
					'value' => $tplParam['factPrice'],
					'color' => '#000000',
				),
				'keyword2' => array(
					'value' => $tplParam['productName'],
					'color' => '#000000',
				),
				'remark' => array(
//					'value' => '拼得好APP上线狂欢，海量好货底价狂欢！今天买满88元就送超值电热水壶！更有0.1夺宝新品等着您！lei啊lei啊，狂欢吧>>>',
					'value' => '因快递公司放假，自1月16日-2月4日订单，暂缓发货，2月5日后恢复正常！春节放价不放假，照常接单，买买买走起>>>',
					'color' => '#ff0000',
				),
			),
		);
		$sendResult = $objWX->sendTemplateMessage($data);
		if($sendResult === false){
			$_logInfo = "【".date('Y-m-d H:i:s', $time)."】支付通知发送失败，openid：{$tplParam['openid']}，实付金额：{$tplParam['factPrice']}，商品：{$tplParam['productName']}，失败信息：".$objWX->errMsg."【".$objWX->errCode."】\r\n";
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		}else{
			$_logInfo = "【".date('Y-m-d H:i:s', $time)."】支付通知发送成功，openid：{$tplParam['openid']}，实付金额：{$tplParam['factPrice']}，商品：{$tplParam['productName']}\r\n";
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		}
		file_put_contents($_logFile, "\r\n", FILE_APPEND);
        break;
    case 'open'://开团
		$tplParam = array(
			'openid' => trim($_REQUEST['openid']),
			'factPrice' => trim($_REQUEST['factPrice']),
			'productName' => trim($_REQUEST['productName']),
			'consignee' => trim($_REQUEST['consignee']),
			'consigneePhone' => trim($_REQUEST['consigneePhone']),
			'consigneeAddress' => trim($_REQUEST['consigneeAddress']),
			'orderNo' => trim($_REQUEST['orderNo']),
		);
		$_logInfo = "【".date('Y-m-d H:i:s', $time)." 订单号：{$tplParam['orderNo']}】发送开团通知开始，openid：{$tplParam['openid']}，实付金额：{$tplParam['factPrice']}，商品：{$tplParam['productName']}，收货人：{$tplParam['consignee']}，联系号码：{$tplParam['consigneePhone']}，地址：{$tplParam['consigneeAddress']}\r\n";
		file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		$data = array(
			'touser' => $tplParam['openid'],
			'template_id' => $tplIds['open'],//'q6Kaj6ncMMCNAXWniidB8yH0AOgdSjuQ_b3J9dreWiI',
			'url' => $site,//.'order_detail.php?oid='.$orderId,
			'topcolor' => '#000000',
			'data' => array(
				'first' => array(
					'value' => '恭喜您开团成功！',
					'color' => '#000000',
				),
				'keyword1' => array(
					'value' => $tplParam['factPrice'],
					'color' => '#000000',
				),
				'keyword2' => array(
					'value' => $tplParam['productName'],
					'color' => '#000000',
				),
				'keyword3' => array(
					'value' => $tplParam['consignee'].' '.$tplParam['consigneePhone'].' '.$tplParam['consigneeAddress'],
					'color' => '#000000',
				),
				'keyword4' => array(
					'value' => $tplParam['orderNo'],
					'color' => '#000000',
				),
				'remark' => array(
					'value' => '拼得好扫货季，低价百货嗨购中，GO>>>',
					'color' => '#ff0000',
				),
			),
		);
		$sendResult = $objWX->sendTemplateMessage($data);
		if($sendResult === false){
			$_logInfo = "【".date('Y-m-d H:i:s', $time)." 订单号：{$tplParam['orderNo']}】开团通知发送失败，openid：{$tplParam['openid']}，实付金额：{$tplParam['factPrice']}，商品：{$tplParam['productName']}，收货人：{$tplParam['consignee']}，联系号码：{$tplParam['consigneePhone']}，地址：{$tplParam['consigneeAddress']}，失败信息：".$objWX->errMsg."【".$objWX->errCode."】\r\n";
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		}else{
			$_logInfo = "【".date('Y-m-d H:i:s', $time)." 订单号：{$tplParam['orderNo']}】开团通知发送成功，openid：{$tplParam['openid']}，实付金额：{$tplParam['factPrice']}，商品：{$tplParam['productName']}，收货人：{$tplParam['consignee']}，联系号码：{$tplParam['consigneePhone']}，地址：{$tplParam['consigneeAddress']}\r\n";
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		}
		file_put_contents($_logFile, "\r\n", FILE_APPEND);		
        break;
    case 'join'://拼团
		$paramData = trim($_REQUEST['data']);
		$_logInfo = "【".date('Y-m-d H:i:s', $time)."】发送拼团通知开始\r\n";
		file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		
		if(empty($paramData)){
			$_logInfo = "【".date('Y-m-d H:i:s', $time)."】发送拼团通知，参数为空\r\n";
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		}

		$tplParam = json_decode($paramData, true);
		if($tplParam === false){
			$_logInfo = "【".date('Y-m-d H:i:s', $time)."】发送拼团通知，参数转为json失败，传递参数data值为{$paramData}\r\n";
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		}

		$data = array(
			'template_id' => $tplIds['join'],//'JUakJR3M_mE7MnrDGf_1kbWsmNAjTnUb458XYwn6aSM',
			'url' => $site.'free.php?id=16',
			'topcolor' => '#000000',
			'data' => array(
				'first' => array(
					'value' => '恭喜您拼团成功！我们将尽快为你发货。',
					'color' => '#000000',
				),
				'keyword1' => array(
					'color' => '#000000',
				),
				'keyword2' => array(
					'color' => '#000000',
				),
				'remark' => array(
					'value' => '拼得好扫货季，低价百货嗨购中，0元开团，全场好货疯抢中！马上点击抢拼吧>>>',
					'color' => '#ff0000',
				),
			),
		);

		foreach($tplParam as $v){
			$data['touser'] = $v['openid'];
			$data['data']['keyword1']['value'] = $v['orderNo'];
			$data['data']['keyword2']['value'] = $v['factPrice'];
			$sendResult = $objWX->sendTemplateMessage($data);
			if($sendResult === false){
				$_logInfo = "【".date('Y-m-d H:i:s', $time)." 订单号:{$v['orderNo']}】拼团通知发送失败，openid:{$v['openid']}，实付金额：{$v['factPrice']}，失败信息：".$objWX->errMsg."【".$objWX->errCode."】\r\n";
				file_put_contents($_logFile, $_logInfo, FILE_APPEND);
			}else{
				$_logInfo = "【".date('Y-m-d H:i:s', $time)." 订单号:{$v['orderNo']}】拼团通知发送成功，openid:{$v['openid']}，实付金额：{$v['factPrice']}\r\n";
				file_put_contents($_logFile, $_logInfo, FILE_APPEND);
			}
		}
		file_put_contents($_logFile, "\r\n", FILE_APPEND);
        break;
    case 'delivery'://发货
		$tplParam = array(
			'openid' => trim($_REQUEST['openid']),
			'logisticsName' => trim($_REQUEST['logisticsName']),
			'logisticsNo' => trim($_REQUEST['logisticsNo']),
			'productName' => trim($_REQUEST['productName']),
			'buyNum' => trim($_REQUEST['buyNum']),
			'orderNo' => trim($_REQUEST['orderNo']),
		);
		$_logInfo = "【".date('Y-m-d H:i:s', $time)."】发送发货通知开始\r\n";
		file_put_contents($_logFile, $_logInfo, FILE_APPEND);

		$data = array(
			'touser' => $tplParam['openid'],
			'template_id' => $tplIds['delivery'],//'EGztXez9id31kHrJZo6i-pY6523kx15PDgvC80Qw658',
			'url' => $site,//.'order_detail.php?oid='.$orderId,
			'topcolor' => '#000000',
			'data' => array(
				'first' => array(
					'value' => '您购买的商品已经发货啦！',
					'color' => '#000000',
				),
				'keyword1' => array(
					'value' => $tplParam['logisticsName'],
					'color' => '#000000',
				),
				'keyword2' => array(
					'value' => $tplParam['logisticsNo'],
					'color' => '#000000',
				),
				'keyword3' => array(
					'value' => $tplParam['productName'],
					'color' => '#000000',
				),
				'keyword4' => array(
					'value' => $tplParam['buyNum'],
					'color' => '#000000',
				),
				'remark' => array(
					'value' => '亲的宝贝已经启程送往您怀抱！等待过程中，欢迎加入拼得好，更有海量大牌免费试用等着您，GO>>>',
					'color' => '#ff0000',
				),
			),
		);

		$sendResult = $objWX->sendTemplateMessage($data);
		if($sendResult === false){
			$_logInfo = "【".date('Y-m-d H:i:s', $time)." 订单号:{$tplParam['orderNo']}】发货通知发送失败，openid:{$tplParam['openid']}，商品：{$tplParam['productName']}【购买数量：{$tplParam['buyNum']}】，物流：{$tplParam['logisticsName']}【运单号：{$tplParam['logisticsNo']}】，失败信息：".$objWX->errMsg."【".$objWX->errCode."】\r\n";
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		}else{
			$_logInfo = "【".date('Y-m-d H:i:s', $time)." 订单号:{$tplParam['orderNo']}】发货通知发送成功，openid:{$tplParam['openid']}，商品：{$tplParam['productName']}【购买数量：{$tplParam['buyNum']}】，物流：{$tplParam['logisticsName']}【运单号：{$tplParam['logisticsNo']}】\r\n";
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		}        
		file_put_contents($_logFile, "\r\n", FILE_APPEND);
        break;
	case 'raffle01'://0.1抽奖
		$_logInfo = "【".date('Y-m-d H:i:s', $time)."】开始发送0.1抽奖通知\r\n";
		file_put_contents($_logFile, $_logInfo, FILE_APPEND);

		$typeValueMap = array(
			1 => 'open',
			2 => 'join',
			3 => 'group',
			4 => 'win',
			5 => 'unwin',
			6 => 'failure',
		);
		$typeMap = array(
			//开团
			'open' => array(
				'tplid' => $tplIds['raffle01']['open'],// 'q6Kaj6ncMMCNAXWniidB8yH0AOgdSjuQ_b3J9dreWiI',
				'name' => '开团',
				'first' => '恭喜您，开团成功啦！邀请好友参与，成团即拿奖品哦！',
				'remark' => '告诉您小妙招，分享至好友加速成团哦！点击马上分享>>>',
				'link' => $site.'groupon_join.php?aid=',
			),
//			//参团
//			'join' => array(
//				'tplid' => '',
//				'name' => '参团',
//				'first' => '恭喜您，参团成功啦！邀请好友参与，成团即有机会获得奖品哦！',
//				'remark' => '告诉您小妙招，分享至好友加入成团哦！点击马上分享>>>',
//				'link' => $site.'groupon_join.php?aid=',
//			),
			//成团
			'group' => array(
				'tplid' => $tplIds['raffle01']['group'],// 'JUakJR3M_mE7MnrDGf_1kbWsmNAjTnUb458XYwn6aSM',
				'name' => '成团',
				'first' => '恭喜您，拼团成功啦！稍后留意开奖信息哦！',
				'remark' => '[劲爆]优质好货，0元开团，预购从速，点击领券>>>',
				'link' => $site.'free.php?id=16',
			),
			//中奖
			'win' => array(
				'tplid' => $tplIds['raffle01']['win'],
				'name' => '已中奖',
				'first' => '恭喜您，终于成团啦！奖品正在打包送到您手上，敬请期待！',
//				'remark' => '点击领取拼得好给您新年专属红包>>>',
//				'link' => $site.'lottery_new.php?act=red&code=',
				'remark' => '点击了解更多0.1元抽奖活动>>>',
				'link' => $site.'lottery_new.php',
			),
			//未中奖
			'unwin' => array(
				'tplid' => $tplIds['raffle01']['unwin'],
				'name' => '未中奖',
				'first' => '您没有中奖！您的款项正在退款中！',
				'remark' => '不要灰心，马上开团获得更多0.1元抽奖机会>>>',
				'link' => $site.'lottery_new.php?act=red&code=',
			),
//			//参团失败
//			'failure' => array(
//				'tplid' => '',
//				'name' => '参团失败',
//				'first' => '很遗憾，您参与的团人数不足未成团，正在退款中！',
//				'remark' => '[劲爆]优质好货，0元开团，预购从速，点击领券>>>',
//				'link' => $site.'free.php?id=16',
//			),
		);

		$_type = trim($_REQUEST['type']);
		$type = $typeValueMap[$_type];
        if($type != 'win') die();

		//参团和参团失败目前不发送，后期需要时，将此代码去除
		if(in_array($type, array('join', 'failure'))){
			$_logInfo = "【".date('Y-m-d H:i:s', $time)."】0.1抽奖【{$typeMap[$type]['name']} {$type}】此类型操作不需要发送通知\r\n";
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
			exit();
		}

		$paramData = trim($_REQUEST['data']);
		$_logInfo = "【".date('Y-m-d H:i:s', $time)."】发送0.1抽奖【{$typeMap[$type]['name']} {$type}】通知开始，接收的参数data内容为{$paramData}\r\n";
		file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		
		if(empty($paramData)){
			$_logInfo = "【".date('Y-m-d H:i:s', $time)."】发送0.1抽奖【{$typeMap[$type]['name']} {$type}】通知，参数为空\r\n";
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		}

		$tplParam = json_decode($paramData, true);
		if($tplParam === false){
			$_logInfo = "【".date('Y-m-d H:i:s', $time)."】发送0.1抽奖【{$typeMap[$type]['name']} {$type}】通知，参数转为json失败，接收参数data值为{$paramData}\r\n";
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		}
		
		$data = array(
			'template_id' => $typeMap[$type]['tplid'],
			'topcolor' => '#000000',
			'data' => array(
				'first' => array(
					'value' => $typeMap[$type]['first'],
					'color' => '#000000',
				),
				'keyword1' => array(
					'color' => '#000000',
				),
				'keyword2' => array(
					'color' => '#000000',
				),
				'keyword3' => array(
					'color' => '#000000',
				),
				'keyword4' => array(
					'color' => '#000000',
				),
				'remark' => array(
					'value' => $typeMap[$type]['remark'],
					'color' => '#ff0000',
				),
			),
		);
		foreach($tplParam as $v){
			$_data = $data;
			$_data['touser'] = $v['openid'];
			$_msg = '';
			switch($type){
				case 'open'://开团
					$_data['url'] = $typeMap[$type]['link'].$v['attendId'];
					$_data['data']['keyword1']['value'] = $v['factPrice'];
					$_data['data']['keyword2']['value'] = $v['productName'];
					$_data['data']['keyword3']['value'] = $v['consignee'].' '.$v['consigneePhone'].' '.$v['consigneeAddress'];
					$_data['data']['keyword4']['value'] = $v['orderNo'];
					$_msg = "，商品：{$v['productName']}";
					break;
				case 'group'://成团
					$_data['url'] = $typeMap[$type]['link'];
					$_data['data']['keyword1']['value'] = $v['orderNo'];
					$_data['data']['keyword2']['value'] = $v['factPrice'];
					unset($_data['data']['keyword3'], $_data['data']['keyword4']);
					break;
				case 'win'://中奖
				case 'unwin'://未中奖
					$_data['url'] = $typeMap[$type]['link'];//.$v['invCode'];
					$_data['data']['keyword1']['value'] = $v['productName'];
					$_data['data']['keyword2']['value'] = $v['factPrice'];
					$_data['data']['keyword3']['value'] = $v['groupDate'];
					$_data['data']['keyword4']['value'] = $typeMap[$type]['name'];
					$_msg = "，商品：{$v['productName']}，成团时间：{$v['groupDate']}";
					break;
			}
			
			$sendResult = $objWX->sendTemplateMessage($_data);
			if($sendResult === false){
				$_logInfo = "【".date('Y-m-d H:i:s', $time)." 订单号:{$v['orderNo']}】0.1抽奖【{$typeMap[$type]['name']} {$type}】通知发送失败，openid:{$v['openid']}，实付金额：{$v['factPrice']}{$_msg}，失败信息：".$objWX->errMsg."【".$objWX->errCode."】\r\n";
			}else{
				$_logInfo = "【".date('Y-m-d H:i:s', $time)." 订单号:{$v['orderNo']}】0.1抽奖【{$typeMap[$type]['name']} {$type}】通知发送成功，openid:{$v['openid']}，实付金额：{$v['factPrice']}{$_msg}\r\n";
			}
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		}
		file_put_contents($_logFile, "\r\n", FILE_APPEND);
		break;
	case 'guess'://猜价中奖
		$templateId = $tplIds['guess'];//'kbBLSKrbhq4niAIZ9_HnsYOicBKPADhouKpHvknmvig';
		$prizeLevelMap = array(
			1 => array(
				'name' => '一等奖',
				'first' => '【恭喜您！中奖啦】您参与的猜价格活动开奖啦！！',
				'remark' => '赶快点击领取商品 >>>',
				'prize' => '一等奖，获得该商品',
			),
			2 => array(
				'name' => '二等奖',
				'first' => '【恭喜您！中奖啦】您参与的猜价格活动开奖啦！！',
				'remark' => '赶快点击领取优惠券，购买商品 >>>',
				'prize' => '二等奖，获得5元抵扣券',
			),
			3 => array(
				'name' => '三等奖',
				'first' => '【恭喜您！中奖啦】您参与的猜价格活动开奖啦！！',
				'remark' => '赶快点击领取优惠券，购买商品 >>>',
				'prize' => '三等奖，获得3元抵扣券',
			),
		);

		$_logInfo = "【".date('Y-m-d H:i:s', $time)."】发送猜价开奖通知开始\r\n";
		file_put_contents($_logFile, $_logInfo, FILE_APPEND);

		$type = trim($_REQUEST['type']);
		$paramData = trim($_REQUEST['data']);
		$_logInfo = "【".date('Y-m-d H:i:s', $time)."】发送猜价开奖通知开始，接收的参数type内容为{$type}，data内容为{$paramData}\r\n";
		file_put_contents($_logFile, $_logInfo, FILE_APPEND);

		if(empty($paramData)){
			$_logInfo = "【".date('Y-m-d H:i:s', $time)."】发送猜价开奖通知，参数为空\r\n";
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		}

		$tplParam = json_decode($paramData, true);
		if($tplParam === false){
			$_logInfo = "【".date('Y-m-d H:i:s', $time)."】发送猜价开奖通知，参数转为json失败，传递参数data值为{$paramData}\r\n";
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		}

		$data = array(
			'template_id' => $templateId,
			'topcolor' => '#000000',
			'data' => array(
				'first' => array(
					'color' => '#000000',
				),
				'keyword1' => array(
					'color' => '#000000',
				),
				'keyword2' => array(
					'color' => '#000000',
				),
				'keyword3' => array(
					'color' => '#000000',
				),
				'keyword4' => array(
					'color' => '#000000',
				),
				'remark' => array(
					'color' => '#ff0000',
				),
			),
		);

		foreach($tplParam as $v){
			$data['touser'] = $v['openid'];
			$data['url'] = $site.'product_guess_price.php?act=detail&gid='.$v['activityId'].'&pid='.$v['productId'];
			$data['data']['first']['value'] = $prizeLevelMap[$type]['first'];
			$data['data']['remark']['value'] = $prizeLevelMap[$type]['remark'];
			$data['data']['keyword1']['value'] = $v['productName'];
			$data['data']['keyword2']['value'] = '0.0';
			$data['data']['keyword3']['value'] = $v['prizeTime'];
			$data['data']['keyword4']['value'] = $prizeLevelMap[$type]['prize'];
			
			$sendResult = $objWX->sendTemplateMessage($data);
			if($sendResult === false){
				$_logInfo = "【".date('Y-m-d H:i:s', $time)."】猜价开奖通知发送失败，openid:{$v['openid']}，【抽奖时间:{$v['prizeTime']}】{$prizeLevelMap[$type]['name']}：{$prizeLevelMap[$type]['prize']}，商品【ID:{$v['productId']}】：{$v['productName']}，活动ID：{$v['activityId']}，失败信息：".$objWX->errMsg."【".$objWX->errCode."】\r\n";
			}else{
				$_logInfo = "【".date('Y-m-d H:i:s', $time)."】猜价开奖通知发送成功，openid:{$v['openid']}，【抽奖时间:{$v['prizeTime']}】{$prizeLevelMap[$type]['name']}：{$prizeLevelMap[$type]['prize']}，商品【ID:{$v['productId']}】：{$v['productName']}，活动ID：{$v['activityId']}\r\n";
			}
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		}
		file_put_contents($_logFile, "\r\n", FILE_APPEND);
		break;
	case 'join_fail'://拼团失败
		$paramData = trim($_REQUEST['data']);
		$_logInfo = "【".date('Y-m-d H:i:s', $time)."】发送拼团失败通知开始\r\n";
		file_put_contents($_logFile, $_logInfo, FILE_APPEND);

		if(empty($paramData)){
			$_logInfo = "【".date('Y-m-d H:i:s', $time)."】发送拼团失败通知，参数为空\r\n";
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		}

		$tplParam = json_decode($paramData, true);
		if($tplParam === false){
			$_logInfo = "【".date('Y-m-d H:i:s', $time)."】发送拼团失败通知，参数转为json失败，传递参数data值为{$paramData}\r\n";
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		}

		$data = array(
			'template_id' => $tplIds['join_fail'],//'pP41fxH24PzPaKArwxh9LixWfluEI5gu328xix46MWM',
			'url' => $site,
			'topcolor' => '#000000',
			'data' => array(
				'first' => array(
					'value' => '您参加的拼团因人数不足而组团失败。我们将在3个工作日内为您安排退款事宜。',
					'color' => '#000000',
				),
				'keyword1' => array(
					'color' => '#000000',
				),
				'keyword2' => array(
					'color' => '#000000',
				),
				'keyword3' => array(
					'color' => '#000000',
				),
				'remark' => array(
					'value' => '拼得好扫货季，低价百货嗨购中，不仅秒杀！百货特惠，进站狂购>>>',
					'color' => '#ff0000',
				),
			),
		);

		foreach($tplParam as $v){
			$data['touser'] = $v['openid'];
			$data['data']['keyword1']['value'] = $v['productName'];
			$data['data']['keyword2']['value'] = $v['productPrice'];
			$data['data']['keyword3']['value'] = $v['factPrice'];
			$sendResult = $objWX->sendTemplateMessage($data);
			if($sendResult === false){
				$_logInfo = "【".date('Y-m-d H:i:s', $time)." 订单号:{$v['orderNo']}】拼团通知发送失败，openid:{$v['openid']}，商品金额：{$v['productPrice']}，退款金额：{$v['factPrice']}，失败信息：".$objWX->errMsg."【".$objWX->errCode."】\r\n";
				file_put_contents($_logFile, $_logInfo, FILE_APPEND);
			}else{
				$_logInfo = "【".date('Y-m-d H:i:s', $time)." 订单号:{$v['orderNo']}】拼团通知发送成功，openid:{$v['openid']}，商品金额：{$v['productPrice']}，退款金额：{$v['factPrice']}\r\n";
				file_put_contents($_logFile, $_logInfo, FILE_APPEND);
			}
		}
		file_put_contents($_logFile, "\r\n", FILE_APPEND);
		break;
}
?>