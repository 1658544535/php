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
		'unionid' => $_SESSION['unionid'],
	);
	(isset($_SESSION['turntable_inviterid']) && $_SESSION['turntable_inviterid']) && $apiParam['invId'] = $_SESSION['turntable_inviterid'];
	
	$result = apiData('userlogin.do', $apiParam);
	if($result['success']){
		$result = $result['result'];

		//设置微信信息
		$_wxUserInfo = $objWX->getUserInfo($openid);
		if($_wxUserInfo == false){
			echo $objWX->errCode.'：'.$objWX->errMsg;
			die;
		}
		if($_wxUserInfo !== false){
			$userApiParam = array('uid'=>$result['uid'], 'name'=>filterEmoji($_wxUserInfo['nickname']));
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
		$_wxInfo->id = $result['uid'];
		$_wxInfo->loginname = $result['phone'];
		$_wxInfo->openid = $openid;
		$_wxInfo->name = $result['name'];
		$_wxInfo->image = $result['image'];
		$referUrl = empty($_SESSION['loginReferUrl']) ? '/' : urldecode($_SESSION['loginReferUrl']);
		$_SESSION['is_login'] = true;
		$_SESSION['userinfo'] = $_wxInfo;
		unset($_SESSION['loginReferUrl']);
        if(isset($_SESSION['turntable_inviterid'])) unset($_SESSION['turntable_inviterid']);
		redirect($referUrl);
	}else{
		redirect('user_binding.php', $result['error_msg']);
	}
}else{
	$wxState = 'wxinfo';
    if($_GET['state'] == $wxState){
		$_accessToken = $objWX->getOauthAccessToken();
		if($_accessToken !== false){
			$_wxinfo = $objWX->getOauthUserinfo($_accessToken['access_token'], $openid);
			$_SESSION['unionid'] = $_wxinfo['unionid'];
		}
	}else{
        $_SESSION['loginReferUrl'] = urlencode($_SERVER['HTTP_REFERER']);
        $wxUser = $objWX->getUserInfo($openid);
        if(($wxUser !== false) && !$wxUser['subscribe']){
			//记录用户未关注公众号
			$time = time();
			$_logDir = LOG_INC.'user/';
			!file_exists($_logDir) && mkdir($_logDir, 0777, true);
			$_logFile = $_logDir.'subscribe_'.date('Y-m-d', $time).'.txt';
			$_logInfo = "【".date('Y-m-d H:i:s', $time)."】当前用户openid:{$openid} 尚未关注公众号\r\n";
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);

            $_bcUrl = $site.'user_binding.php';
            redirect($objWX->getOauthRedirect($_bcUrl, $wxState));
        }
    }
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
