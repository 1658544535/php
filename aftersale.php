<?php
define('HN1', true);
require_once('./global.php');

$backUrl = getPrevUrl();

$mapType = array(1=>'仅退款', 2=>'我要退货', 3=>'售后');
$mapReason = array(1=>'没有收到货', 2=>'商品有质量问题', 3=>'商品与描述不一致', 4=>'商品少发漏发发错', 5=>'收到商品时有划痕或破损', 6=>'质疑假货', 7=>'其他');

//上传图片保存目录
define('IMAGE_UPLOAD_DIR', SCRIPT_ROOT.'upfiles/aftersale/');
define('IMAGE_UPLOAD_URL', 'upfiles/aftersale/');

$act = trim($_GET['act']);
switch($act){
	case 'apply'://申请
		$orderId = CheckDatas('oid', 0);
		$orderId = intval($orderId);
		empty($orderId) && redirect($backUrl, '参数错误');

		$info = apiData('refundDetails.do', array('oid'=>$orderId, 'uid'=>$userid));
		!empty($info['result']) && redirect($backUrl, '你已申请过');

		if(IS_POST()){
			set_time_limit(0);
			$apiParam = array();
			$upImgs = $_POST['img'];
			
			$i = 1;
			foreach($upImgs as $v){
				$apiParam['image'.$i] = '@'.IMAGE_UPLOAD_DIR.$v;
				$i++;
			}

			$mapType = array_flip($mapType);
			$mapReason = array_flip($mapReason);
			
			$data = $_POST['m'];
			$apiParam['oid'] = $orderId;
			$apiParam['refundReason'] = $data['describe'];
			$apiParam['refundType'] = $mapReason[$data['reason']];
			$apiParam['type'] = $mapType[$data['type']];
			$apiParam['uid'] = $userid;
			$apiParam['phone'] = $data['phone'];
			$apiParam['price'] = $data['price'];
			$result = apiData('applyRefund.do', $apiParam, 'post');
			if(empty($_SESSION['backurl_aftersale'])){
				$prevUrl = '/';
			}else{
				$prevUrl = $_SESSION['backurl_aftersale'];
				unset($_SESSION['backurl_aftersale']);
			}
			if($result['success']){
				foreach($upImgs as $v){
					file_exists(IMAGE_UPLOAD_DIR.$v) && unlink(IMAGE_UPLOAD_DIR.$v);
				}
				$prevUrl .= ((strpos($prevUrl, '?') === false) ? '?' : '&').'bs=3';
				redirect($prevUrl, '申请成功');
			}else{
				redirect($backUrl, $result['error_msg']);
			}
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
			$name = trim($_POST['type']);
			$logisticsNo = trim($_POST['no']);
			empty($name) && redirect($backUrl, '请填写物流类型');
			empty($logisticsNo) && redirect($backUrl, '请填写运单编号');
			$dataParam = array(
				'oid' => $orderId,
				'uid' => $userid,
				'logisticsName' => $_SESSION['aftersale_tracking'][$name]['nameEn'],
				'logisticsNum' => $logisticsNo,
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
			$trackList = array();
			$tmpTracks = array();
			$tracks = apiData('logistics.do', array());
			foreach($tracks['result'] as $v){
				$trackList[] = $v['name'];
				$tmpTracks[$v['name']] = $v;
			}
			$_SESSION['aftersale_tracking'] = $tmpTracks;
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
	case 'logistics'://物流详情
		$orderId = intval($_GET['oid']);
		empty($orderId) && redirect($backUrl, '参数错误');
		$info = apiData('refundExpress.do', array('oid'=>$orderId));
		empty($info) && redirect($backUrl, '网络异常，请稍候查看');
		include_once('tpl/logistics_web.php');
		break;
	case 'uploadimg'://上传图片
		$upfile = $_FILES['files'];
		($upfile['size'][0] <= 0) && ajaxResponse(false, '请选择图片');
		$allowTypes = array('image/jpg','image/jpeg','image/png','image/pjpeg','image/gif','image/bmp','image/x-png');
		!in_array($upfile['type'][0], $allowTypes) && ajaxResponse(false, '只能上传图片');
		$fileInfo = pathinfo($upfile['name'][0]);
		$orderId = intval($_GET['oid']);
		!file_exists(IMAGE_UPLOAD_DIR) && mkdir(IMAGE_UPLOAD_DIR, 0777, true);
		$destFile = $orderId.'_'.time().'.'.$fileInfo['extension'];
		if(move_uploaded_file($upfile['tmp_name'][0], IMAGE_UPLOAD_DIR.$destFile)){
			ajaxResponse(true, $destFile, array('url'=>IMAGE_UPLOAD_URL.$destFile));
		}else{
			ajaxResponse(false, '上传失败');
		}
		break;
	default://列表
		include_once('tpl/aftersale_web.php');
		break;
}
?>
