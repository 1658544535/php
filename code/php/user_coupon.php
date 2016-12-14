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
	if($result['success']){
			$_wxUserInfo = $objWX->getUserInfo($openid);
			if($_wxUserInfo == false){
				echo $objWX->errCode.'：'.$objWX->errMsg;
				die;
			}
			if($_wxUserInfo !== false){
				$userApiParam = array('uid'=>$result['result']['uid'], 'name'=>filterEmoji($_wxUserInfo['nickname']));
				if($_wxUserInfo['headimgurl']){
					$_dir = SCRIPT_ROOT.'upfiles/headimage/';
					!file_exists($_dir) && mkdir($_dir, 0777, true);
					$_headimg = $_dir.$openid.'.jpg';
					//				file_put_contents($_headimg, file_get_contents($_wxUserInfo['headimgurl']));
					$ch = curl_init($_wxUserInfo['headimgurl']);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
					$avatar = curl_exec($ch);
					curl_close($ch);
					file_put_contents($_headimg, $avatar);
					$userApiParam['file'] = '@'.$_headimg;
				}
				apiData('editUserInfo.do', $userApiParam, 'post');
			}	
		
		    $_wxInfo = new stdClass();
			$_wxInfo->id = $result['result']['uid'];
			$_wxInfo->loginname = $result['result']['phone'];
			$_wxInfo->openid = $openid;
			$_wxInfo->name = $result['result']['name'];
			$_wxInfo->image = $result['result']['image'];
			$_SESSION['is_login'] = true;
			$_SESSION['userinfo'] = $_wxInfo;
		//兑换优惠券操作
		$couponNo = CheckDatas( 'number', '' );
		$coupon = apiData('addUserCoupon.do', array('couponNo'=>$couponNo,'uid'=>$result['result']['uid']),'post');
		if($coupon['success'] !=''){
			echo ajaxJson( 1,'获取成功',$coupon['error_msg']);
		}else{
			echo ajaxJson( 2,'获取成功',$coupon['error_msg']);
		}
	}else{
		echo ajaxJson( 0,'获取成功',$result['error_msg']);
	}
}else{
	$couponNo = CheckDatas( 'number', '' );
	$coupon = apiData('addUserCoupon.do', array('couponNo'=>$couponNo,'uid'=>$userid),'post');
	if($coupon['success']){
	    echo	ajaxJson( 1,'获取成功',$coupon['error_msg']);
	}else{
		echo	ajaxJson( 2,'获取成功',$coupon['error_msg']);
	}
}





?>