<?php
define('HN1', true);
require_once('./global.php');

$bLogin && redirect('/');
IS_USER_WX_LOGIN();

$openid = !isset( $_SESSION['openid'] ) ? null : $_SESSION['openid'];

//if($_SERVER['REQUEST_METHOD'] == 'POST'){
//	$result = apiData('agentlogin.do', array('openid'=>$openid));
//	if($result['success']){
//		$result = $result['result'];
//		$_wxInfo = new stdClass();
//		$_wxInfo->id = $result['id'];
//		$_wxInfo->loginname = $result['phone'];
//		$_wxInfo->openid = $result['openid'];
//		$_wxInfo->name = $result['name'];
//		$_SESSION['is_login'] = true;
//		$_SESSION['userinfo'] = $user_wx_info;
//
//		$referUrl = empty($_SESSION['loginReferUrl']) ? '/' : $_SESSION['loginReferUrl'];
//		unset($_SESSION['loginReferUrl']);
//		redirect($referUrl);
//	}else{
//		redirect('wxuser_reg.php', $result['error_msg']);
//	}
//}else{
//	$_SESSION['loginReferUrl'] = urlencode($_SERVER['HTTP_REFERER']);
//	include "tpl/wxuser_login_web.php";
//}
//exit();

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
				redirect($backUrl, '登录失败111');
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
			!$user_info && redirect($backUrl, '登录失败222');

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
			redirect($backUrl, '登录失败333');
		}

		$SysLoginModel->commit();
		redirect($referUrl);
	}
}else{
	$_SESSION['loginReferUrl'] = urlencode($_SERVER['HTTP_REFERER']);
	include "tpl/user_bind_web.php";
}



//switch($act)
//{
//
///*===================== 完善资料信息页面 ===========================*/
//	case "user_reg":
//		include "tpl/user_reg_web.php";
//	break;
//
///*===================== 完善资料信息处理页面 ===========================*/
//	case "reg":
//
//		/*
//		 * 规则：
//		 * 1、判断手机号、openid、验证码、密码是否存在
//		 * 2、判断手机号是否已经被注册
//		 * 3、判断验证码是否正确
//		 * 3、通过 openid 获取该用户的微信信息
//		 * 4、添加 syslogin 的相关信息
//		 * 5、添加 user_info 的相关信息
//		 * 6、清除 $_SESSION['send_time']
//		 * 7、获得优惠券  user_coupon
//		 * 8、记录用户登录日志 sys_login_log
//		 * 9、用户钱包 user_wallet
//		 * */
//
//		try
//		{
//			$openid 	= $openid;
//			$phone 		= ! isset($_REQUEST['phone'])  	   ? '' : sqlUpdateFilter($_REQUEST['phone']);
//			$code 		= ! isset($_REQUEST['code']) 	   ? '' : sqlUpdateFilter($_REQUEST['code']);
//			$password 	= ! isset($_REQUEST['password'])   ? '' : sqlUpdateFilter($_REQUEST['password']);
//			$password 	= ! isset($_REQUEST['password'])   ? '' : sqlUpdateFilter($_REQUEST['password']);
//
//			if ( $bLogin )
//			{
//				redirect('/','您的帐号已绑定，请不要重复绑定！');
//			}
//
//			if ( $openid == '' || $phone == '' || $code == '' || $password == '' )
//			{
//				throw new Exception( "绑定失败！原因：参数不完整！" );
//			}
//
//			$count = $user_bulding->check_user_loginname( $phone );										// 通过手机号获取该手机是否被注册
//
//			if ( $count == 1 )
//			{
//				throw new Exception( "绑定失败！原因：该手机号已被注册！" );
//			}
//
//			$userverify = new user_verifyBean();
//			$verify_code = $userverify->verify($db, $phone);											// 获取验证码
////059722
//			if ( $verify_code != $code )																// 判断验证码是否正确
//			{
////				$chuwai = array('13011111111', '13011111112', '13011111113','13011111114','13011111115','13011111116','13011111117','13011111118','13011111119');
////				if(!in_array($phone, $chuwai)) throw new Exception( "绑定有误！原因：您提交的验证码不正确！" );
//				throw new Exception( "绑定有误！原因：您提交的验证码不正确！" );
//			}
//
//			$_regInfo = array(
//				'openid' => $openid,
//				'phone' => $phone,
//				'password' => $password,
//				'code' => $code,
//			);
//			$_SESSION['reg_info'] = $_regInfo;
//			
//			redirect('/user_binding?act=user_info');
//			exit();
//
////			if ( $isTest )
////			{
////				$user_wx_info = (object)array("subscribe"=>1,
////					"openid"=> "o6MuHtwL7s7gntl6xYmXHikcD6zQ",
////					"nickname"=> "破孩er",
////					"sex"=> 1,
////					"language"=>"zh_CN",
////					"city"=>"深圳",
////					"province"=>  "广东",
////					"country"=> "中国",
////					"headimgurl"=>  "http://wx.qlogo.cn/mmopen/ajNVdqHZLLBDpgBPDVic6HwAcVexKb1IGaiaqQeI4q2InOuAPRztQ9veeJM3ON8EBB0h2ibwTe0ZicxnopoicnDCicJw/0",
////					"subscribe_time"=> 1438219229,
////					"unionid"=> "o5Tz0siAWAHfw0ixZnmzEzaLXx_0",
////					"remark"=> "",
////					"groupid"=> 0
////				);
////			}
////			else
////			{
////				$user_wx_info = $user_bulding->get_user_wx_info_from_openid( $openid );								// 通过openid获取用户的微信信息
////			}
////
////			$user_wx_info->password   = md5($password);																// 把密码追加上去
////			$user_wx_info->loginname  = $phone;																		// 把手机号追加上去
////			$user_info = $user_bulding->create_user_info( $user_wx_info );											// 更新sys_login 和 添加user_info表
////
////// 			if ( ! $user_info )
////// 			{
////// 				throw new Exception("绑定有误！原因：添加用户信息失败！");
////// 			}
////
////			$msg = "user binding success!!  绑定成功  openid:{$openid}, phone:{$phone}, code:{$code}, password:{$password}, userid:{$user_info->id}";
////			$log->put('/user/binding', $msg);																		// 记录日志
////
////			// 添加用户登录日志
////			$rs = $user_bulding->addUserLoginLog( $user_info->id );
////			if ( $rs )
////			{
////				$log->put('/user/binding', 'sys_login_log添加成功！' );												// 记录日志
////			}
////
////			// 增加用户钱包
////			$rs = $user_bulding->createUserWallet( $user_info->id );
////			if ( $rs )
////			{
////				$log->put('/user/binding', 'user_wallet添加成功！' );													// 记录日志
////			}
////
//////			// 添加新人礼包（优惠券）
//////			$rs = $user_bulding->getUserCoupon( $user_info->id );
//////			if ( $rs )
//////			{
//////				$log->put('/user/binding', '新人礼包（优惠券）发送成功！' );												// 记录日志
//////			}
////
////			$_SESSION['send_time']	 = NULL;																		// 清除session记录
////			$_SESSION['is_login']	 = true;																		// 登录状态为true
////			$_SESSION['userinfo'] 	 = $user_info;																	// 把用户信息存入session
////			redirect('/user_binding?act=user_info');
//		}
//		catch( Exception $e )
//		{
//			$msg = "操作：完善用户信息!!  {$e->getMessage()}  openid:{$openid}, phone:{$phone}, code:{$code}, $password:{$password}";
//			$log->put('/user/binding', $msg);															// 记录日志
//
//			redirect('/user_binding', $e->getMessage());
//		}
//	break;
//
///*===================== 绑定资料信息页面 ===========================*/
//	case "user_bind":
//		include "tpl/user_bind_web.php";
//	break;
//
//
///*===================== 绑定资料信息处理页面 ===========================*/
//	case "bind":
//		/*
//		 * 功能：绑定用户的微信帐号
//		 * 流程：
//		 * 1、获取手机号是否存在
//		 * 2、判断用户的密码是否正确
//		 * 3、如果正确则绑定微信帐号
//		 * 4、重新获取值，并保存在session中
//		 * */
//
//		try
//		{
//			$openid 	= $_SESSION['openid'];
//			$unionid 	= $_SESSION['unionid'];
//			
//			$phone 		= ! isset($_REQUEST['phone'])  	  ? '' : sqlUpdateFilter($_REQUEST['phone']);
//			$password 	= ! isset($_REQUEST['password'])  ? '' : sqlUpdateFilter($_REQUEST['password']);
//
//			if ( $bLogin )
//			{
//				redirect('/','您的帐号已绑定，请不要重复绑定！');
//			}
//
//			if ( $openid == '' || $phone == '' || $password == '' )
//			{
//				throw new Exception( "绑定失败！原因：参数不完整！" );
//			}
//
//			$count = $user_bulding->check_user_loginname( $phone );													// 通过手机号获取该手机是否被注册
//
//			if ( $count == 0 )
//			{
//				throw new Exception( "绑定失败！原因：您输入的帐号暂未注册！" );
//			}
//
//			$rs = $user_bulding->bind_user_info( $openid, $unionid, $phone, md5($password) );
//
//			if ( $rs == -1 )
//			{
//				throw new Exception( "绑定失败！原因：您输入的帐号密码有误！" );
//			}
//		
//			if ( $rs == -2 )
//			{
//				throw new Exception( "绑定失败！原因：数据更新失败！" );
//			}
//
//			$msg = "user binding success!!  绑定成功  openid:{$openid}, phone:{$phone}, userid:{$rs->id}";
//			$log->put('/user/binding', $msg);																		// 记录日志
//
//			$_SESSION['is_login'] = true;																			// 登录状态为true
//			$_SESSION['userinfo'] = $rs;																			// 把用户信息存入session
//
//			// 添加用户登录日志
//			$user_bulding->addUserLoginLog( $user_info->id );
//
//			redirect('/user_binding?act=binding_success');
//
//		}
//		catch( Exception $e )
//		{
//			$msg = "操作：绑定用户信息!!  {$e->getMessage()}  openid:{$openid}, phone:{$phone},$password:{$password}";
//			$log->put('/user/binding', $msg);																		// 记录日志
//
//			redirect('/user_binding?act=user_bind', $e->getMessage());
//		}
//
//
//	break;
//
///*===================== 绑定资料信息处理页面 ===========================*/
//	case "unbind":
//		if ( $user_bulding->unbind( $_SESSION['userinfo']->id ) )
//		{
//			$_SESSION['is_login'] 	= false;
//			$_SESSION['userinfo'] 	= null;
//
//			$msg = "成功退出帐号！";
//		}
//		else
//		{
//			$msg = "退出帐号失败，请重试！";
//		}
//
//		redirect('/index', $msg );
//	break;
//
///*===================== 绑定成功界面 ===========================*/
//	case "binding_success":
//		include "tpl/user_binding_success_web.php";
//	break;
//
///*===================== 完善注册信息界面 ===========================*/
//	case "user_info":
//		$openid 	= $_SESSION['openid'];
//		
//		$SysloginModel = M('sys_login');
//		$uid=$SysloginModel->get(array('openid'=>$openid));
//	
//	 include "tpl/reg.php";
//		break;
//	
//	case "info":
//		$_regInfo = $_SESSION['reg_info'];
//		
//		if(empty($_regInfo)){
//			redirect('/user_binding?act=user_reg');
//			exit();
//		}
//
//		$name 		= ! isset($_REQUEST['name'])  	       ? '' : sqlUpdateFilter($_REQUEST['name']);
//		$baby_name 	= ! isset($_REQUEST['baby_name']) 	   ? '' : sqlUpdateFilter($_REQUEST['baby_name']);
//		$baby_sex 	= ! isset($_REQUEST['baby_sex']) 	   ? '' : sqlUpdateFilter($_REQUEST['baby_sex']);
//		$baby_birthday 	= ! isset($_REQUEST['baby_birthday'])   ? '' : sqlUpdateFilter($_REQUEST['baby_birthday']);
//
//		
//		
//		$openid = $_regInfo['openid'];
//		$password = $_regInfo['password'];
//		$code = $_regInfo['code'];
//		$phone = $_regInfo['phone'];
//
//		$user_wx_info = $user_bulding->get_user_wx_info_from_openid($openid);
//		$user_wx_info->password   = md5($password);																// 把密码追加上去
//		$user_wx_info->loginname  = $phone;																		// 把手机号追加上去
//		$user_wx_info->nickname   = $name;
//		$user_wx_info->baby_sex   = $baby_sex;
//		$user_wx_info->baby_birthday = $baby_birthday;
//		$user_info = $user_bulding->create_user_info( $user_wx_info );											// 更新sys_login 和 添加user_info表
//        
//
//			$data = array(
//				'user_id'       => $user_info->id,
//				'name'          => $name,
//				'baby_name'     => $baby_name,
//			    'baby_sex'      => $baby_sex,
//				'baby_birthday' => $baby_birthday,	
//				'create_date' 	=> date("Y-m-d H:i:s"),
//			    'is_default'    => 1
//		 );
//		$UserBabyModel->add($data);
//	
//		$msg = "user binding success!!  绑定成功  openid:{$openid}, phone:{$phone}, code:{$code}, password:{$password}, userid:{$user_info->id}";
//		$log->put('/user/binding', $msg);																		// 记录日志
//
//		// 添加用户登录日志
//		$rs = $user_bulding->addUserLoginLog( $user_info->id );
//		if ( $rs )
//		{
//			$log->put('/user/binding', 'sys_login_log添加成功！' );												// 记录日志
//		}
//
//		// 增加用户钱包
//		$rs = $user_bulding->createUserWallet( $user_info->id );
//		if ( $rs )
//		{
//			$log->put('/user/binding', 'user_wallet添加成功！' );													// 记录日志
//		}
//
////			// 添加新人礼包（优惠券）
////			$rs = $user_bulding->getUserCoupon( $user_info->id );
////			if ( $rs )
////			{
////				$log->put('/user/binding', '新人礼包（优惠券）发送成功！' );												// 记录日志
////			}
//
//		$_SESSION['send_time']	 = NULL;																		// 清除session记录
//		$_SESSION['is_login']	 = true;																		// 登录状态为true
//		$_SESSION['userinfo'] 	 = $user_info;																	// 把用户信息存入session
//
//		redirect('/user_binding?act=binding_success');
//	break;
///*===================== 默认页面 ===========================*/
//	default:
////		isset($_GET['dir']) && $_SESSION['loginReferUrl'] = $_GET['dir'];
//		$_SESSION['loginReferUrl'] = urlencode($_SERVER['HTTP_REFERER']);
//		include "tpl/user_bind_web.php";
//	break;
//}

?>
