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
		$addrId = CheckDatas('id', 0);
		empty($addrId) && ajaxJson(0, '参数错误');
		$result = apiData('deleteAddress.do', array('addId'=>$addrId, 'uid'=>$userid));
		$result['success'] ? ajaxJson(1, '') : ajaxJson(0, $result['error_msg']);
		break;
	case 'address_default'://设置默认地址
		$addrId = CheckDatas('id', 0);
		empty($addrId) && ajaxJson(0, '参数错误');
		$result = apiData('selectAddress.do', array('addId'=>$addrId, 'uid'=>$userid));
		$result['success'] ? ajaxJson(1, '操作成功') : ajaxJson(0, $result['error_msg']);
		break;
		break;
	case 'user_guess'://我的猜价
		$type = CheckDatas();
		break;
}
?>