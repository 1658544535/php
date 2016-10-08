<?php
define('HN1', true);
require_once('./global.php');

$act = CheckDatas('act', '');
switch($act){
	case 'address'://我的地址列表
		$page = max(1, intval($_POST['page']));
		$addrs = apiData('myaddress.do', array('uid'=>$userid,'pageNo'=>$page));
		$addrs['success'] ? ajaxJson(1, '', $addrs['result'], $page) : ajaxJson(0, $addrs['error_msg']);
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
		list($province, $city, $area) = explode(',', trim($_POST['area']));
		$data = array(
			'address' => trim($_POST['addr']),
			'area' => intval($area),
			'city' => intval($city),
			'province' => intval($province),
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
	case 'user_groupon'://我的拼团
		$status = intval($_POST['type']);
		$page = max(1, intval($_POST['page']));
		$result = apiData('myGroupListApi.do', array('pageNo'=>$page, 'status'=>$status, 'userId'=>$userid));
//		file_put_contents(LOG_INC.'zzzzzzzzzz.txt', var_export($result, true)."\r\n", FILE_APPEND);
		$result['success'] ? ajaxJson(1, '', $result['result'], $page) : ajaxJson(0, $result['error_msg']);
		break;
	case 'aftersale'://售后列表
		$page = max(1, intval($_POST['page']));
		$status = intval($_POST['type']);
		$result = apiData('refundListApi.do', array('pageNo'=>$page, 'status'=>$status, 'userId'=>$userid));
		$result['success'] ? ajaxJson(1, '', $result['result'], $page) : ajaxJson(0, $result['error_msg']);
		break;
	case 'groupon_free'://免团列表
		$page = max(1, intval($_POST['page']));
		$result = apiData('groupFreeListApi.do', array('pageNo'=>$page, 'userId'=>$userid));
		$result['success'] ? ajaxJson(1, '', $result['result'], $page) : ajaxJson(0, $result['error_msg']);
		break;
	case 'index_cate_groupon'://首页分类拼团
		$id = intval($_REQUEST['id']);
		$result = apiData('findGroupByTypeId.do', array('pageNo'=>$page, 'id'=>$id));
		$result['success'] ? ajaxJson(1, '', $result['result'], $page) : ajaxJson(0, $result['error_msg']);
		break;
	case 'index'://首页
		$cateId = intval($_REQUEST['id']);
		$page = max(1, intval($_POST['page']));
		if($cateId){
			$result = apiData('findGroupByTypeId.do', array('id'=>$cateId, 'pageNo'=>$page));
			$arr = array(
				'code' => 1,
				'msg' => '成功',
				'data' => array(
					'proData' => array(
						'pageNow' => $page,
						'ifLoad' => empty($result['result']) ? 0 : 1,
						'listData' => $result['result'],
					),
				),
			);
			echo json_encode($arr);
			exit();
		}else{
			$lunbo = apiData('groupHomeApi.do');
			$recom = apiData('homeGroupProductsApi.do', array('pageNo'=>$page));
			$arr = array(
				'code' => 1,
				'msg' => '成功',
				'data' => array(
					'banner' => empty($lunbo['result']) ? array() : $lunbo['result'],
					'proData' => array(
						'pageNow' => $page,
						'ifLoad' => empty($recom['result']) ? 0 : 1,
						'listData' => $recom['result'],
					),
				),
			);
			echo json_encode($arr);
			exit();
		}
		break;
	case 'areas'://生成地区
		getAreasJson();
		ajaxJson(1, '');
		break;
	case 'address_detail'://地址详情
		$addrId = intval($_POST['id']);
		empty($addrId) && ajaxJson(0, '参数错误');
		$result = apiData('addressDetail.do', array('addId'=>$addrId, 'uid'=>$userid));
		$result['success'] ? ajaxJson(1, '', $result['result']) : ajaxJson(0, $result['error_msg']);
		break;
	case 'coupon_valid'://订单可用优惠券
		$productId = intval($_POST['pid']);
		$amount = trim($_POST['amount']);
		$info = apiData('getValidUserCoupon.do', array('pid'=>$productId,'price'=>$amount,'uid'=>$userid));
		$info['success'] ? ajaxJson(1, '', $info['result']) : ajaxJson(0, $info['error_msg']);
		break;
}
?>