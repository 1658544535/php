<?php
define('HN1', true);
require_once('./global.php');

$act = CheckDatas('act', '');
switch($act){
	case 'address'://我的地址列表
		$addrs = apiData('myaddress.do', array('uid'=>$userid));
		$addrs['success'] ? ajaxJson(1, '', $addrs['result'], 1, 1) : ajaxJson(0, $addrs['error_msg']);
		break;
	case 'address_del'://删除地址
		$addrId = intval($_POST['id']);
		empty($addrId) && ajaxJson(0, '参数错误');
		$result = apiData('deleteAddress.do', array('addId'=>$addrId, 'uid'=>$userid));
		$result['success'] ? ajaxJson(1, '') : ajaxJson(0, $result['error_msg']);
		break;
	case 'address_default'://设置默认地址
		$addrId = intval($_POST['id']);
		empty($addrId) && ajaxJson(0, '参数错误');
		$result = apiData('selectAddress.do', array('addId'=>$addrId, 'uid'=>$userid));
		$result['success'] ? ajaxJson(1, '操作成功') : ajaxJson(0, $result['error_msg']);
		break;
	case 'address_edit'://添加/编辑地址
		$addrId = intval($_POST['id']);
		$data = array(
			'address' => trim($_POST['addr']),
			'area' => intval($_POST['area']),
			'city' => intval($_POST['city']),
			'province' => intval($_POST['province']),
			'isDefault' => 0,
			'name' => trim($_POST['name']),
			'postCode' => trim($_POST['post']),
			'tel' => trim($_POST['tel']),
			'uid' => $userid,
		);
		if($addrId){
			$data['addId'] = $addrId;
			$result = apiData('eidtAddress.do', $data);
		}else{
			$result = apiData('addAddress.do', $data);
		}
		$result['success'] ? ajaxJson(1, '操作成功') : ajaxJson(0, $result['error_msg']);
		break;
	case 'user_guess'://我的猜价
		$type = CheckDatas();
		break;
}
?>