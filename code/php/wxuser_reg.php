<?php
define('HN1', true);
require_once('./global.php');

$bLogin && redirect('/');
IS_USER_WX_LOGIN();

$openid = !isset( $_SESSION['openid'] ) ? null : $_SESSION['openid'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$prevUrl = getPrevUrl();
	$mobile = trim($_POST['mobile']);
	$pwd = trim($_POST['password']);
	$repwd = trim($_POST['repassword']);
	$vcode = $_POST['code'];
	empty($mobile) && redirect($prevUrl, '手机号码不能为空');
	empty($pwd) && redirect($prevUrl, '密码不能为空');
	($pwd != $repwd) && redirect($prevUrl, '两次密码不一致');
	($vcode == '') && redirect($prevUrl, '验证码不能为空');

	$apiParam = array(
		'captcha' => $vcode,
		'category' => 1,
		'openid' => $openid,
		'pass' => $pwd,
		'phone' => $mobile,
		'regChannel' => 'weixin',
	);
	$result = apiData('register.do', $apiParam);
	if($result['success']){
		$result = $result['result'];
		$_wxInfo = new stdClass();
		$_wxInfo->id = $result['id'];
		$_wxInfo->loginname = $result['phone'];
		$_wxInfo->openid = $result['openid'];
		$_wxInfo->name = $result['name'];
		$_SESSION['is_login'] = true;
		$_SESSION['userinfo'] = $user_wx_info;

		$referUrl = empty($_SESSION['regReferUrl']) ? '/' : $_SESSION['regReferUrl'];
		unset($_SESSION['regReferUrl']);
		@unset($_SESSION['loginReferUrl']);
		redirect($referUrl, '注册成功');
	}else{
		redirect($prevUrl, $result['error_msg']);
	}
}else{
	if(isset($_SESSION['loginReferUrl'])){
		$_SESSION['regReferUrl'] = $_SESSION['loginReferUrl'];
	}else{
		$_SESSION['regReferUrl'] = urlencode($_SERVER['HTTP_REFERER']);
	}
	include "tpl/wxuser_reg_web.php";
}
?>