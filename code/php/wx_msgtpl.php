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

define('API_URL', 'http://pdh.choupinhui.net/v3.5');
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

switch($act){
    case 'pay'://支付
		$tplParam = array(
			'openid' => trim($_REQUEST['openid']),
			'factPrice' => trim($_REQUEST['factPrice']),
			'productName' => trim($_REQUEST['productName']),
		);
		$_logInfo = "【".date('Y-m-d H:i:s', $time)."】发送支付通知开始，openid：{$tplParam['openid']}，实付金额：{$tplParam['factPrice']}，商品：{$tplParam['productName']}\r\n";
		file_put_contents($_logFile, $_logInfo, FILE_APPEND);
		$data = array(
			'touser' => $tplParam['openid'],
			'template_id' => 'HijtVshBey8vWEiheh97ih_VCMndYZv28ouP2lnyTa0',
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
					'value' => '[重磅]提前双十一，全场玩具7.7！好玩低价，预购从速>>',
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
			'template_id' => 'q6Kaj6ncMMCNAXWniidB8yH0AOgdSjuQ_b3J9dreWiI',
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
					'value' => '[重磅]提前双十一，全场玩具7.7！好玩低价，预购从速>>',
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
			'template_id' => 'JUakJR3M_mE7MnrDGf_1kbWsmNAjTnUb458XYwn6aSM',
			'url' => 'http://wxpdh.choupinhui.net/free.php?id=16',
			'topcolor' => '#000000',
			'data' => array(
				'first' => array(
					'value' => '恭喜您拼团成功！我们将尽快为你发货。',
					'color' => '#000000',
				),
				'keyword1' => array(
//					'value' => $orderInfo['orderInfo']['orderNo'],
					'color' => '#000000',
				),
				'keyword2' => array(
//					'value' => $orderInfo['productInfo']['orderPrice'],
					'color' => '#000000',
				),
				'remark' => array(
					'value' => '优质玩具，0元开团，预购从速，点击领券>>>',
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
			'template_id' => 'EGztXez9id31kHrJZo6i-pY6523kx15PDgvC80Qw658',
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
					'value' => '[重磅]提前双十一，全场玩具7.7！好玩低价，预购从速>>',
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
//    case 'refund'://退款
//        $result = '';
//        $orderId = intval($_GET['oid']);
//        $uid = intval($_GET['uid']);
//        $refundInfo = apiData('refundDetails.do', array('oid'=>$orderId, 'uid'=>$uid));
//        if($refundInfo['success']){
//            $refundInfo = $refundInfo['result'];
//            $orderInfo = apiData('orderdetail.do', array('oid'=>$orderId));
//            $typeMap = array(1=>'仅退款', 2=>'退货退款');
//            $data = array(
//                'touser' => $openid,
//                'template_id' => '-ufIIBoIsqG6QOFo7N8N19n3jBx9Lguyi7VqAITE8kU',
//                'url' => $site,//.'groupon_join.php?aid='.$orderInfo['attendId'],
//                'topcolor' => '#000000',
//                'data' => array(
//                    'first' => array(
//                        'value' => '退款成功！',
//                        'color' => '#000000',
//                    ),
//                    'keyword1' => array(
//                        'value' => $refundInfo['refundPrice'],
//                        'color' => '#000000',
//                    ),
//                    'keyword2' => array(
//                        'value' => $typeMap[$refundInfo['type']],
//                        'color' => '#000000',
//                    ),
//                    'keyword3' => array(
//                        'value' => $refundInfo['refundType'],
//                        'color' => '#000000',
//                    ),
//                    'keyword4' => array(
//                        'value' => '',
//                        'color' => '#000000',
//                    ),
//                    'keyword5' => array(
//                        'value' => $orderInfo['result']['orderInfo']['orderNo'],
//                        'color' => '#000000',
//                    ),
//                    'remark' => array(
//                        'value' => '[重磅]提前双十一，全场玩具7.7！好玩低价，预购从速>>',
//                        'color' => '#ff0000',
//                    ),
//                ),
//            );
//
//            $sendResult = $objWX->sendTemplateMessage($data);
//            if($sendResult !== false){
//                $result = json_encode($sendResult);
//            }
//        }
//		echo $result;
//        break;
}
?>