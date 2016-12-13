<?php
define('HN1', true);
require_once('./global.php');

if(empty($bLogin)){
	$mobile = trim($_POST['mobile']);
	$code   = trim($_POST['code']);
	$apiParam = array(
			'captcha' => $code,
			'openid' => 'oQ1Yut9AASTaSpFOtEkaWFp08ZnQ',
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