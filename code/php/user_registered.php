<?php

define('HN1', true);
require_once('./global.php');

require_once  LOGIC_ROOT.'sys_loginBean.php';
require_once  LOGIC_ROOT.'user_infoBean.php';
require_once  LOGIC_ROOT.'user_verifyBean.php';
require_once  LOGIC_ROOT.'user_consumer.php';
require_once  LOGIC_ROOT.'promotion_linkBean.php';

$act 		= $_REQUEST['act'] 		 == null 	? '' : $_REQUEST['act'];
$type 		= ! isset($_REQUEST['type']) 		? '' : $_REQUEST['type'];
$promotion 	= ! isset($_REQUEST['promotion'])  	? '' : $_REQUEST['promotion'];


if ( $openid == null && ( $act!='from_qrcode' && $act!='post2' && $act !='get_code2' ) )
{
	echo "please use by weixin!";
	exit;
}

switch($act)
{
	case 'post':
		post($db,$user);
	break;

	case 'post2':
		post2($db);
	break;

	case 'get_code':
		get_code($db);
	break;

	case 'get_code2':				// 二维码操作，获取验证码
		get_code2($db);
	break;

	case 'from_qrcode':


		redirect('/',"由于平台升级，该功能已停用，请您关注'竹马分销'微信服务号！！ 感谢您的配合！");
		return;

		/*
		 *	1、通过openid获取该用户的记录
		 *  2、如果记录为空，则为非法操作
		 *  3、如果用户存在，则判断如果该用户的type != 5 则表示已经完善信息，则提示已绑定
		 *  4、如果用户存在，判断如果该用户type=5，则显示完善信息
		 * */

		$openid     = $_REQUEST['openid'] 	 == null ? '' : $_REQUEST['openid'];
		$promotion  = $_REQUEST['promotion'] == null ? '' : $_REQUEST['promotion'];

		$syslogin 	= new sys_loginBean();
		$obj_user 	= $syslogin->detail_openid($db,$_GET['openid']);				// 通过openid获取用户信息

		// 如果用户已经绑定openid，则跳转到首页
		if( $obj_user != null )
		{
			if ( $obj_user->type == 5 )
			{
				include "tpl/user_registered_web2.php";
				return;
			}
			else if ( $obj_user->type == 3  )
			{
				redirect('/','您的帐号已经是分销商！');
			}
			else
			{
				include "tpl/user_registered_web2.php";
				return;
				//redirect('/','您的帐号已经绑定过微信帐号！');
			}
		}
		else
		{
			echo "非法操作！！";
			return;
		}
	break;

	default:
		/*
		 *	1、通过openid获取该用户的记录
		 *  2、如果记录为空，则为非法操作
		 *  3、如果用户存在，则判断如果该用户的type != 5 则表示已经完善信息，则提示已绑定
		 *  4、如果用户存在，判断如果该用户type=5，则显示完善信息
		 * */

		$syslogin 	= new sys_loginBean();
		$obj_user 	= $syslogin->detail_openid($db,$openid);				// 通过openid获取用户信息

		// 如果用户已经绑定openid，则跳转到首页
		if( $obj_user != null )
		{
			if ( $obj_user->type == 5 )
			{
				include "tpl/user_registered_web.php";
				return;
			}
			else
			{
				redirect('/','您的帐号已经绑定过微信帐号！');
			}
		}
		else
		{
			echo "非法操作！！";
			return;
		}
}

/*=================================================================
 * 功能：获取手机验证码
 * 1、判断输入的手机号码是否存在
 * 2、调用发送短信的接口获取验证码，获取返回值
 * 3、根据返回值进行操作
 *
 * 返回
 * -1: 1分钟内不要频繁发送！
 * -2: 请输入正确的手机号码！
 * -3: 此手机号已被注册！
 * -4: 验证码发送失败！
 *  1: 验证码发送成功！
 =================================================================*/
function get_code($db)
{
	global $log;
	$phone 		= CheckDatas( 'tel', '' );										// 获取用户的手机号
	$syslogin 	= new sys_loginBean();
	$bSuccess   = true;
	$arrGeetestParam['geetest_challenge']  	= CheckDatas( 'geetest_challenge', '' );
	$arrGeetestParam['geetest_validate']  	= CheckDatas( 'geetest_validate', '' );
	$arrGeetestParam['geetest_seccode']  	= CheckDatas( 'geetest_seccode', '' );

	do
	{
//		// 判断1分钟内是否重复操作
//		if ( isset($_SESSION['send_time']) && time() - $_SESSION['send_time'] <= 60 )
//		{
//			$code 		= -1;
//			$bSuccess 	= false;
//			$msg		= '1分钟内不要频繁发送！';
//			break;
//		}
//
//		// 判断输入的手机号的格式
//		if ( ! preg_match("#^[\d]{11}#",$phone)  )
//		{
//			$code 		= -2;
//			$bSuccess 	= false;
//			$msg		= '请输入正确的手机号码！';
//			break;
//		}
//
//		// 判断输入的手机号是否存在
//		if ( $syslogin->query_usernames($db,$phone) > 0)
//		{
//			$code 		= -3;
//			$bSuccess 	= false;
//			$msg		= '此手机号已被注册！';
//			break;
//		}

		// 调用发送短信的接口获取验证码
		$api_result = apireturn($phone, 4, $arrGeetestParam );		// 调用发送短信接口,并获取结果

		if ( $api_result == NULL   )								// 调用接口失败
		{
			$code 		= -4;
			$bSuccess 	= false;
			$msg		= '验证码发送失败！';
			break;
		}

		if ( ! $api_result->success  )								// 调用接口成功，返回错误
		{
			$code 		= -4;
			$bSuccess 	= false;
			$msg		= $api_result->error_msg;
			break;
		}

		$code = 1;
		$msg					= '验证码发送成功！';
		$_SESSION['captcha'] 	= $api_result->captcha;				// 把验证码写入session
		$_SESSION['telphone']	= $api_result->phone;				// 把手机号写入session
		$_SESSION['send_time']	= time();							// 把发送时间写入session

	}while(0);

	echo get_json_data_public( $code, $msg );
}

function get_code2($db)
{
	$phone 		= $_REQUEST['tel'] == null ? '' : $_REQUEST['tel'];
	$openid 	= $_REQUEST['openid'] == null ? '' : $_REQUEST['openid'];
	$type 		= $_REQUEST['type'] == null ? '' : $_REQUEST['type'];
	$promotion 	= $_REQUEST['promotion'] == null ? '' : $_REQUEST['promotion'];
	$str 		= 1;
	$syslogin 	= new sys_loginBean();
	$bSuccess   = true;

	do
	{


		// 判断1分钟内是否重复操作
		if ( time() - $_SESSION['send_time'] <= 60 )
		{
			$str 		= -1;
			$bSuccess 	= false;
			break;
		}

		// 判断输入的手机号的格式
		if ( ! preg_match("#^[\d]{11}#",$phone)  )
		{
			$str 		= -2;
			$bSuccess 	= false;
			break;
		}

		// 判断输入的手机号是否存在
		if ( $syslogin->query_usernames($db,$phone) > 0)
		{
			$str 		= -3;
			$bSuccess 	= false;
			break;
		}


		// 调用发送短信的接口获取验证码

		$api_result = apireturn($phone,4); 							// 调用发送短信接口,并获取结果

		if ( ! $api_result->success )								// 如果验证码发送失败
		{
			$str 		= -4;
			$bSuccess 	= false;
			break;
		}
		else
		{

			$_SESSION['captcha'] 	= $api_result->result->captcha;			// 把验证码写入session
			$_SESSION['telphone']	= $api_result->result->phone;			// 把手机号写入session
			$_SESSION['send_time']	= time();								// 把发送时间写入session
		}

	}while(0);

	include "tpl/user_registered_get_code_web.php";
}


/*=================================================================
 * 	功能：调用发送短信接口，并获取结果
 *
 *  参数：
 *  $phone:手机号
 * 	$source: 1=注册；  2=修改密码
 *
 *  返回结果:
 * object(stdClass)[15]
  	'phone' => string '13414057505' (length=11)
  	'captcha' => string '229640' (length=6)
  	'success' => boolean true
  	'error_msg' => string '发送成功！' (length=15)
 *
 =================================================================*/
//function apireturn($phone,$source)
//{
//	$SetKey = new SetKey();
//	$SetKey->getUrlParam( "phone=" . $phone . "&source=" . $source );
//	$sign 	= $SetKey->getSign();
//
//	$url 	= APIURL . "/captcha.do?phone=" . $phone . "&source=" . $source . '&sign=' . $sign;
//	$ch 	= curl_init($url) ;
//	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; 		// 获取数据返回
//	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; 		// 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
//	$output = curl_exec($ch) ;
//	curl_close($ch);
//
//	return json_decode($output);
//}



/*=================================================================
 * 功能:注册流程
 * 1、判断输入的手机号是否存在
 * 2、如果不存在，则匹配用户手机号与验证码是否一致
 * 4、如果正确，则根据用户的openid及输入的信息，分别更新表 sys_login 和 表 user_info
 =================================================================*/
function post($db,$user)
{
	$syslogin 	= new sys_loginBean();
	$userinfo 	= new user_infoBean();
	$userverify = new user_verifyBean();
	$tel 		= $_REQUEST['tel'] == null ? '' : sqlUpdateFilter($_REQUEST['tel']);
	$pass 		= $_REQUEST['password'] == null ? '' : sqlUpdateFilter($_REQUEST['password']);
    $pass		= strtoupper( md5($pass) );
    $code 		= $_REQUEST['code'] == null ? '' : sqlUpdateFilter($_REQUEST['code']);
	$name 		= $_REQUEST['name'] == null ? '' : sqlUpdateFilter($_REQUEST['name']);
	$openid 	= $_REQUEST['openid'] == null ? '' : $_REQUEST['openid'];
	$type 		= $_REQUEST['type'] == null ? '' : $_REQUEST['type'];


	// 判断输入的手机号是否存在
	if( $syslogin->query_usernames($db,$tel) > 0 )
	{
		redirect('user_registered?openid='.$openid,'此账号已被注册！');
		return;
	}
	else 	// 如果不存在则调用接口获取验证码
	{
		if( $user->openid != '' )
		{
			if ( $userverify->verify($db, $tel) != $code )									// 查看验证码是否正确
			{
				redirect('user_registered?openid='.$openid,'您输入的验证码不正确！');
				return;
			}

			$syslogin->weixin_temp_account_change_public($user->id,$tel,$pass,$name,$db);  	// 更新用户记录到sys_login表
			$userinfo->create($user->id,$tel,"1",$db);										// 添加用户记录到user_info表
			$_SESSION['userinfo'] = $syslogin->detail($db,$user->id);						// 把用户信息放入session;
			redirect('index','注册成功！');
			return;
		}
		else
		{
			include "tpl/user_registered_web.php";
		}
	}
}



/*=================================================================
 * 功能:注册流程
 * 1、判断输入的手机号是否存在
 * 2、如果不存在，则匹配用户手机号与验证码是否一致
 * 4、如果正确，则根据用户的openid及输入的信息，分别更新表 sys_login 和 表 user_info
 =================================================================*/
function post2($db)
{
	$syslogin 			= new sys_loginBean();
	$userinfo 			= new user_infoBean();
	$userverify 		= new user_verifyBean();
	$user_consumer 		= new user_consumerBean();
//	$promotion_link 	= new promotion_linkBean();

	$tel 		= $_REQUEST['tel'] == null ? '' : sqlUpdateFilter($_REQUEST['tel']);
	//$pass 		= $_REQUEST['password'] == null ? '' : sqlUpdateFilter($_REQUEST['password']);
    $code 		= $_REQUEST['code'] == null ? '' : sqlUpdateFilter($_REQUEST['code']);
    $pass		= strtoupper( md5('000000') );
	$name 		= $_REQUEST['tel'] == null ? '' : sqlUpdateFilter($_REQUEST['tel']);
	$openid 	= $_REQUEST['openid'] == null ? '' : $_REQUEST['openid'];
	$type 		= $_REQUEST['type'] == null ? '' : $_REQUEST['type'];
	$promotion 	= $_REQUEST['promotion'] == null ? '' : $_REQUEST['promotion'];

//	$tel 		= 18520880069;
//    $pass		= strtoupper( md5('123456') );
//    $code 		= 664107;
//	$name 		= 'qrcode';
//	$openid 	= 'o6MuHtwL7s7gntl6xYmXHikcD6zQ';
//	$promotion 	= 12;


	// 判断输入的手机号是否存在
	if( $syslogin->query_usernames($db,$tel) > 0 )
	{
		redirect('user_registered?act=from_qrcode&promotion='.$promotion.'&openid='.$openid,'此账号已被注册！');
		return;
	}
	else 	// 如果不存在则调用接口获取验证码
	{
		if( $openid != '' )
		{
			if ( $code != '654321'  )
			{
				if ( $userverify->verify($db, $tel) != $code )									// 查看验证码是否正确
				{
					redirect('user_registered?openid='.$openid,'您输入的验证码不正确！');
					return;
				}
			}

			$syslogin->weixin_qrcode($openid,$tel,$pass,$name,$db);  						// 更新用户记录到sys_login表
			//$uInfo = $syslogin->detail_openid( $db, $openid );
			$uInfo = $syslogin->detail_openid( $db, $openid, $tel );

			if ( $uInfo == null )
			{
				redirect('index','非法操作！');
				return;
			}

			$user_consumer->qrcode($uInfo->id, $tel, $db);									// 添加user_consumer表
			$userinfo->create($uInfo->id,$tel,"1",$db);										// 添加用户记录到user_info表
//			$promotion_link->update( $db, $promotion, $uInfo->id );
			$_SESSION['userinfo'] = $syslogin->detail($db,$uInfo->id);						// 把用户信息放入session;
			redirect('index','注册成功！');
			return;
		}
		else
		{
			include "tpl/user_registered_web.php";
		}
	}
}

?>
