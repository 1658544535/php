<?php
define('HN1', true);
require_once('./global.php');

$backUrl = getPrevUrl();

$mapType = array(1=>'仅退款', 2=>'我要退货', 3=>'售后');
$mapReason = array(1=>'没有收到货', 2=>'商品有质量问题', 3=>'商品与描述不一致', 4=>'商品少发漏发发错', 5=>'收到商品时有划痕或破损', 6=>'质疑假货', 7=>'其他');

$act = trim($_GET['act']);
switch($act){
	case 'apply'://申请
		$orderId = CheckDatas('oid', 0);
		$orderId = intval($orderId);
		empty($orderId) && redirect($backUrl, '参数错误');

		$info = apiData('refundDetails.do', array('oid'=>$orderId, 'uid'=>$userid));
		!empty($info['result']) && redirect($backUrl, '你已申请过');

		if(IS_POST()){
			$apiParam = array();
			for($i=0; $i<3; $i++){
				($_FILES['img']['size'][$i] > 0) && $apiParam['image'.($i+1)] = '@'.$_FILES['img']['tmp_name'][$i];
			}

			$mapType = array_flip($mapType);
			$mapReason = array_flip($mapReason);
			
			$data = $_POST['m'];
			$apiParam['oid'] = $orderId;
			$apiParam['refundReason'] = $data['describe'];
			$apiParam['refundType'] = $mapReason[$data['reason']];
			$apiParam['type'] = $mapType[$data['type']];
			$apiParam['uid'] = $userid;
			$result = apiData('applyRefund.do', $apiParam, 'post');
			if(empty($_SESSION['backurl_aftersale'])){
				$prevUrl = '/';
			}else{
				$prevUrl = $_SESSION['backurl_aftersale'];
				unset($_SESSION['backurl_aftersale']);
			}
			$result['success'] ? redirect($prevUrl, '申请成功') : redirect($backUrl, $result['error_msg']);
		}else{
			$order = apiData('orderdetail.do', array('oid'=>$orderId));
			!$order['success'] && redirect($backUrl, $order['error_msg']);
			$order = $order['result'];
			$_SESSION['backurl_aftersale'] = $backUrl;
			include_once('tpl/aftersale_apply_web.php');
		}
		break;
	case 'tracking'://物流
		$orderId = CheckDatas('oid', 0);
		$orderId = intval($orderId);
		empty($orderId) && redirect($backUrl, '参数错误');
		if(IS_POST()){
			$dataParam = array(
				'oid' => $orderId,
				'uid' => $userid,
				'logisticsName' => trim($_POST['type']),
				'logisticsNum' => trim($_POST['no']),
			);
			$result = apiData('submitLogistics.do', $dataParam);
			if(empty($_SESSION['backurl_aftersale'])){
				$prevUrl = '/';
			}else{
				$prevUrl = $_SESSION['backurl_aftersale'];
				unset($_SESSION['backurl_aftersale']);
			}
			$result['success'] ? redirect($prevUrl, '提交成功') : redirect($backUrl, $result['error_msg']);
		}else{
			$_SESSION['backurl_aftersale'] = $backUrl;
			include_once('tpl/aftersale_tracking_web.php');
		}
		break;
	case 'detail'://详情
		$orderId = intval($_GET['oid']);
		empty($orderId) && redirect($backUrl, '参数错误');
		$info = apiData('refundDetails.do', array('oid'=>$orderId, 'uid'=>$userid));
		empty($info) && redirect($backUrl, '网络异常，请稍候查看');
		!$info['success'] && redirect($backUrl, $info['error_msg']);
		$info = $info['result'];
		include_once('tpl/aftersale_detail_web.php');
		break;
	default://列表
		include_once('tpl/aftersale_web.php');
		break;
}
?>
