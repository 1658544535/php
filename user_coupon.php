<?php
define('HN1', true);
require_once('./global.php');

if(empty($bLogin)){
	$mobile = trim($_GET['mobile']);
	$code   = trim($_GET['code']);

	$apiParam = array(
			'captcha' => $code,
			'openid' => $openid,
			'phone' => $mobile,
			'source' => 3,
			'unionid' => $_SESSION['unionid'],
	);
	$result = apiData('userlogin.do', $apiParam,'post');
	if($result['success'] !=''){
		$couponNo = CheckDatas( 'number', '' );
		$coupon = apiData('addUserCoupon.do', array('couponNo'=>$couponNo,'uid'=>$result['result']['uid']),'post');
		if($coupon['success'] !=''){
			echo ajaxJson( 1,'获取成功',$coupon['error_msg']);
		}else{
			echo ajaxJson( 0,'获取成功',$coupon['error_msg']);
		}
	}else{
		echo ajaxJson( 0,'获取成功',$result['error_msg']);
	}
}else{
	$couponNo = CheckDatas( 'number', '' );
	$coupon = apiData('addUserCoupon.do', array('couponNo'=>$couponNo,'uid'=>$userid),'post');
	if($coupon['success'] !=''){
	    echo	ajaxJson( 1,'获取成功',$coupon['error_msg']);
	}else{
		echo	ajaxJson( 0,'获取成功',$coupon['error_msg']);
	}
}





?>