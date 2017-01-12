<?php
define('HN1', true);
require_once('./global.php');

$act = CheckDatas('act', '');
switch($act){
	case 'address'://我的地址列表
		$page = max(1, intval($_POST['page']));
		$pId =$_SESSION['order']['productId'];
		$addrs = apiData('myaddress.do', array('uid'=>$userid,'pageNo'=>$page,'pid'=>$pId));
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
			$result = apiData('eidtAddress.do', $data,'post');
		}else{
			$result = apiData('addAddress.do', $data,'post');
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
			$result = apiData('findProductListApi.do', array('id'=>$cateId,'level'=>1,'pageNo'=>$page));
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
	case 'collect'://收藏
		empty($userid) && ajaxJson(0, '请先登录', array('r'=>'login'));
		$activityId = intval($_POST['id']);
		$productId = intval($_POST['pid']);
		$type = trim($_POST['t']);
		($type == '') && $type = 5;//默认为拼团
		$result = apiData('addFavorite.do', array('activityId'=>$activityId,'favSenId'=>$productId,'favType'=>$type,'uid'=>$userid));
		$result['success'] ? ajaxJson(1, '收藏成功') : ajaxJson(0, (($result['error_msg'] == '') ? '收藏失败' : $result['error_msg']));
		break;
	case 'uncollect'://取消收藏
		$activityId = intval($_POST['id']);
		$productId = intval($_POST['pid']);
		$type = trim($_POST['t']);
		($type == '') && $type = 5;//默认为拼团
		$result = apiData('delSingleFavorite.do', array('activityId'=>$activityId,'favSenId'=>$productId,'favType'=>$type,'uid'=>$userid));
		$result['success'] ? ajaxJson(1, '取消收藏') : ajaxJson(0, (($result['error_msg'] == '') ? '取消失败' : $result['error_msg']));
		break;
	case 'specials'://专题列表
		$catId = intval($_POST['id']);
		$page = max(1, intval($_POST['page']));
 		$list = apiData('specialListApi.do', array('typeId'=>$catId,'pageNo'=>$page));	
// 		$list['success'] ? ajaxJson(1, '', $list['result'], $page) : ajaxJson(0, $list['error_msg']);
		$fx   = apiData('getShareContentApi.do', array('id'=>$catId,'type'=>12));
		$arr  =array(
				'list'=>$list['result'],
				'fx'  =>$fx['result']
		);
		ajaxJson(1, '', $arr, $page);
		break;
	case 'special'://专题
		$id = intval($_GET['id']);
		$page = max(1, intval($_POST['page']));
		$list = apiData('specialDetailApi.do', array('specialId'=>$id,'pageNo'=>$page));
		$list['success'] ? ajaxJson(1, '', $list['result'], $page) : ajaxJson(0, $list['error_msg']);
		break;
	case 'newspecial'://新品专区
		$id = intval($_GET['id']);
		$page = max(1, intval($_POST['page']));
		$list = apiData('newSpecialApi.do', array('pageNo'=>$page));
		$list['success'] ? ajaxJson(1, '', $list['result'], $page) : ajaxJson(0, $list['error_msg']);
		break;
	case 'special_77'://77专区
		$id = intval($_GET['id']);
		$page = max(1, intval($_POST['page']));
		$list = apiData('zoneProductsApi.do', array('id'=>$id,'pageNo'=>$page));
		$list['success'] ? ajaxJson(1, '', $list['result'], $page) : ajaxJson(0, $list['error_msg']);
		break;
	case 'sellout'://售罄
		$page = max(1, intval($_POST['page']));
		$list = apiData('sellOutListApi.do', array('pageNo'=>$page));
		$list['success'] ? ajaxJson(1, '', $list['result'], $page) : ajaxJson(0, $list['error_msg']);
		break;
}
?>