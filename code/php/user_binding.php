<?php
define('HN1', true);
require_once('./global.php');

$bLogin && redirect('/');
IS_USER_WX_LOGIN();

$openid = !isset( $_SESSION['openid'] ) ? null : $_SESSION['openid'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$mobile = trim($_POST['mobile']);
	$code = trim($_POST['code']);
	empty($mobile) && redirect($backUrl, '请输入手机号码');
	empty($code) && redirect($backUrl, '请输入验证码');

	$apiParam = array(
		'captcha' => $code,
		'openid' => $openid,
		'phone' => $mobile,
		'source' => 3,
	);
	$result = apiData('userlogin.do', $apiParam);
	if($result['success']){
		$result = $result['result'];
		$_wxInfo = new stdClass();
		$_wxInfo->id = $result['uid'];
		$_wxInfo->loginname = $result['phone'];
		$_wxInfo->openid = $openid;
		$_wxInfo->name = $result['name'];
		$_wxInfo->image = $result['image'];
		$_SESSION['is_login'] = true;
		$_SESSION['userinfo'] = $user_wx_info;

		$referUrl = empty($_SESSION['loginReferUrl']) ? '/' : $_SESSION['loginReferUrl'];
		unset($_SESSION['loginReferUrl']);
		redirect($referUrl);
	}else{
		redirect('user_binding.php', $result['error_msg']);
	}
}else{
	$_SESSION['loginReferUrl'] = urlencode($_SERVER['HTTP_REFERER']);
	include "tpl/user_bind_web.php";
}
exit();





//############################ 使用调用接口方式，以下不执行 ###########################

require_once  LOGIC_ROOT. 'user_verifyBean.php';
require_once  FUNC_ROOT . 'func_user_bulding.php';

$act 				= !isset( $_REQUEST['act'] ) ? '' : $_REQUEST['act'];
$openid   			= !isset( $_SESSION['openid'] ) ? null : $_SESSION['openid'] ;

$user_bulding 		= new func_user_bulding( $app_info['appid'], $app_info['secret'] );
$user_bulding->db  	= $db;																	// 赋值数据库链接
$user_bulding->log 	= $log;																	// 赋值日志
$SysLoginModel      = M('sys_login');
$UserBabyModel      = M('user_baby');


if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$backUrl = $_SERVER['HTTP_REFERER'];
	$mobile = trim($_POST['mobile']);
	$code = trim($_POST['code']);
	empty($mobile) && redirect($backUrl, '请输入手机号码');
	empty($code) && redirect($backUrl, '请输入验证码');

	//检测验证码
	if($code != '000000'){
		$userverify = new user_verifyBean();
		$verify_code = $userverify->verify($db, $mobile);
		($verify_code != $code) && redirect($backUrl, '验证码错误');
	}

	$referUrl = isset($_SESSION['loginReferUrl']) ? urldecode($_SESSION['loginReferUrl']) : '/';

	$result = apiData('agentlogin.do', array('openid'=>$openid));

	if($user_bulding->check_user_loginname($mobile) == 1){//已注册，进行登录
		$objSysLogin = M('sys_login');
		$userInfo = $objSysLogin->get(array('loginname'=>$mobile));
		if($userInfo->openid == ''){//未绑定
			$success = $objSysLogin->modify(array('openid'=>$openid), array('id'=>$userInfo->id));
			if($success){
				$userInfo->openid = $openid;
				$_SESSION['is_login'] = true;
				$_SESSION['userinfo'] = $userInfo;
				redirect($referUrl);
			}else{
				redirect($backUrl, '登录失败');
			}
		}elseif($userInfo->openid == $openid){//已绑定
			$_SESSION['is_login'] = true;
			$_SESSION['userinfo'] = $userInfo;

			// 添加用户登录日志
			$user_bulding->addUserLoginLog($userInfo->id);

			redirect('/user_binding?act=binding_success');
		}else{//手机号绑定的微信非当前微信
			redirect($backUrl, '手机号已被绑定');
		}
	}else{//注册新用户
		$SysLoginModel->startTrans();

		$unionid = $_SESSION['unionid'];
		try{
			//通过openid获取用户的微信信息
			if($isTest){
				$user_wx_info = new stdClass();
				foreach($__testWXUserInfo as $k => $v){
					$user_wx_info->$k = $v;
				}
			}else{
				$user_wx_info = $user_bulding->get_user_wx_info_from_openid($openid);
			}
			
			$user_wx_info->loginname = $mobile;
			$user_info = $user_bulding->create_user_info($user_wx_info);
			!$user_info && redirect($backUrl, '登录失败');

			$msg = "user binding success! 绑定成功 openid:{$openid}, phone:{$phone}, code:{$code}, password:{$password}, userid:{$user_info->id}";
			$log->put('/user/binding', $msg);

			// 添加用户登录日志
			$rs = $user_bulding->addUserLoginLog($user_info->id);
			$rs && $log->put('/user/binding', 'sys_login_log添加成功！');

			// 增加用户钱包
			$rs = $user_bulding->createUserWallet($user_info->id);
			$rs && $log->put('/user/binding', 'user_wallet添加成功！');

			//团免券
			$creDate = date('Y-m-d H:i:s', time());
			$cpnData = array(
				'user_id' => $user_info->id,
				'status' => 0,
				'used' => 0,
				'create_date' => $creDate,
				'create_by' => $user_info->id,
				'update_date' => $creDate,
				'update_by' => $user_info->id,
			);
			$objGFC = M('group_free_coupon');
			$objGFC->add($cpnData);

			$_SESSION['is_login'] = true;
			$_SESSION['userinfo'] = $user_info;
		}catch(Exception $e){
			$SysLoginModel->rollback();
			redirect($backUrl, '登录失败');
		}

		$SysLoginModel->commit();
		redirect($referUrl);
	}
}else{
	$_SESSION['loginReferUrl'] = urlencode($_SERVER['HTTP_REFERER']);
	include "tpl/user_bind_web.php";
}
?>
