<?php
define('HN1', true);
require_once('./global.php');

require_once  LOGIC_ROOT.'sys_loginBean.php';
require_once  LOGIC_ROOT.'user_infoBean.php';
require_once  LOGIC_ROOT.'user_verifyBean.php';
require_once  LOGIC_ROOT.'user_consumerBean.php';

$act = isset( $_REQUEST['act'] ) ? $_REQUEST['act'] : '';

if ( $_SESSION['is_new_user'] == false )
{
	redirect( $site . "index.php");
	exit;
}

if ( !isset($_SESSION['shake_info']) || $_SESSION['shake_info'] == "" )
{
	$dir = $_SERVER['REQUEST_URI'];
	redirect( $site . "login.php?&dir=" . $dir);
	exit;
}

switch( $act )
{

	case 'post':
		post($db);
	break;

	case 'get_code':
		get_code($db);
	break;

	case "login":
		require_once('./tpl/user_login_web.php');
	break;

	default:
		// 否则跳转到主页
		require_once('./tpl/user_registered_web.php');
}



	/*=================================================================
	 * 功能:注册流程
	 * 1、判断输入的手机号是否存在
	 * 2、如果不存在，则匹配用户手机号与验证码是否一致
	 * 4、如果正确，则根据用户的openid及输入的信息，分别更新表 sys_login 和 表 user_info
	 =================================================================*/
	function post($db)
	{
		$syslogin 		= new sys_loginBean( $db,'sys_login' );
		$userinfo 		= new user_infoBean( $db,'user_info' );
		$userverify 	= new user_verifyBean( $db,'user_verify' );
 		$tel 			= $_REQUEST['tel'] == null ? '' : sqlUpdateFilter($_REQUEST['tel']);
 		$code 			= $_REQUEST['code'] == null ? '' : sqlUpdateFilter($_REQUEST['code']);
	    $pass			= strtoupper( md5('000000') );
		$name 			= $_SESSION['shake_info']['user_name'];
		$openid 		= $_SESSION['shake_info']['openid'];
		$unionid 		= $_SESSION['shake_info']['unionid'];
		$type 			= 1;

		// 判断验证码是否正确
		$rs = $userverify->get_one( array( 'loginname'=>$tel ), '','id DESC' );
		if ( $rs->captcha != $code )
		{
			redirect('reg.php','您输入的验证码不正确！');
			return;
		}

		// 判断帐号是否存在
		$rs = $syslogin->get_one(array('loginname'=>$tel));

		if ( $rs != null )
		{
			$arrParam = array('openid'=>$_SESSION['shake_info']['openid'], 'unionid'=>$_SESSION['shake_info']['unionid']);
	    	$arrWhere = array('loginname'=>$tel);
	    	$syslogin->update( $arrParam, $arrWhere);
			$_SESSION['is_new_user'] = false;										// 把用户信息放入session;
		}
		else
		{
			$arrParam = array(
				'loginname' 	=> $tel,
				'password'		=> $pass,
				'name'			=> $name,
				'openid'		=> $openid,
				'type'			=> $type,
				'status'		=> 1,
				'create_date' 	=> date('Y-m-d H:i:s'),
				'update_date'	=> date('Y-m-d H:i:s'),
				'unionid'		=> $unionid
			);

			$user_id = $syslogin->create( $arrParam );								// 添加用户记录到sys_login表

			$arrParam = array(
				'user_id'		=> $user_id,
				'tel'			=> $tel,
				'status'		=> 1,
				'create_date'	=> date('Y-m-d H:i:s'),
				'update_date'	=> date('Y-m-d H:i:s'),
				'channel'		=> 2,
				'remarks'		=> '注册途径：摇一摇'
			);
			$userinfo->create($arrParam);											// 添加用户记录到user_info表

			$_SESSION['is_new_user'] = false;										// 把用户信息放入session;
		}

		redirect('index.php','登录成功！');
	}


	/*=================================================================
	 * 	功能：调用发送短信接口，并获取结果
	 *
	 *  参数：
	 *  $phone:手机号
	 * 	$source: 1=注册；  2=修改密码; 4=临时接口（没验证手机是否存在）
	 *
	 *  返回结果:
	 * object(stdClass)[15]
	  	'phone' => string '13414057505' (length=11)
	  	'captcha' => string '229640' (length=6)
	  	'success' => boolean true
	  	'error_msg' => string '发送成功！' (length=15)
	 *
	 =================================================================*/
	function apireturn($phone,$source)
	{
		$url 	= "http://b2c.taozhuma.com/captcha.do?phone=" . $phone . "&source=4";
		//$url 	= "http://b2c.taozhuma.com/captcha.do?phone=" . $phone . "&source=" . $source;
		//$url 	= "http://testb2c.taozhuma.com/captcha.do?phone=" . $phone . "&source=4";
		$ch 	= curl_init($url) ;
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; 		// 获取数据返回
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; 		// 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
		$output = curl_exec($ch) ;
		curl_close($ch);

		return json_decode($output);
	}



	/*=================================================================
	 * 功能：获取手机验证码
	 * 1、调用发送短信的接口获取验证码，获取返回值
	 * 2、根据返回值进行操作
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
		$phone 		= isset($_GET['tel']) ? $_GET['tel'] : "";										// 获取用户的手机号
		$syslogin 	= new sys_loginBean($db,'sys_login');
		$bSuccess   = true;

		do
		{
			// 判断1分钟内是否重复操作
			if ( isset($_SESSION['send_time']) && time() - $_SESSION['send_time'] <= 60 )
			{
				$code 		= -1;
				$bSuccess 	= false;
				$msg 		= '1分钟内不要频繁发送！';
				break;
			}

			// 判断输入的手机号的格式
			if ( ! preg_match("#^[\d]{11}#",$phone)  )
			{
				$code 		= -2;
				$bSuccess 	= false;
				$msg 		= '请输入正确的手机号码！';
				break;
			}


			// 调用发送短信的接口获取验证码
			$api_result = apireturn($phone,1); 							// 调用发送短信接口,并获取结果
			$result = $api_result->result;

			if ( ! $api_result->success )								// 如果验证码发送失败
			{
				$code 		= -4;
				$bSuccess 	= false;
				$msg 		= $api_result->error_msg;
				break;
			}

			$code = 1;
			$bSuccess = true;
			$msg = "已成功获取验证码，请注意查收！";

			$_SESSION['captcha'] 	= $result->captcha;					// 把验证码写入session
			$_SESSION['telphone']	= $result->phone;					// 把手机号写入session
			$_SESSION['send_time']	= time();							// 把发送时间写入session

		}while(0);

		echo get_api_data( $bSuccess, $code, $msg );
	}




?>

