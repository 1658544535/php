<?php
define('HN1', true);
require_once('./global.php');

require_once FUNC_ROOT . 'func_user_bulding.php';
//require_once LOGIC_ROOT.'sys_loginBean.php';
//require_once LOGIC_ROOT.'user_infoBean.php';

$act 			= !isset($_REQUEST['act'])   ? ''     : $_REQUEST['act'];
$dir 			= !isset($_REQUEST['dir'])   ? 'user' : $_REQUEST['dir'];
$state 			= !isset($_REQUEST['state']) ? ''     : $_REQUEST['state'];

/*
 * 登录检测步骤：
 * 1、 通过授权链接获取code
 * 2、 通过返回的code换取网页授权access_token和openid
 * 2、 判断返回的信息是否为空，如果为空则出错，否则进行下一步操作
 * 3、 检测该sys_login.openid是否存在，如果存在则继续操作,如果不存在则添加用户记录
 * */

switch($act)
{
	case 'login_out':
		login_out();
	break;


	/*----------------------------------------------------------------------------------------------------
		-- 登录操作
	-----------------------------------------------------------------------------------------------------*/
	default:
		if( $state == '' )		// 第一次进入登录，则先获取code;
		{
			redirect("https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$app_info['appid']."&redirect_uri=".urlencode($site."login?state=123&dir=".$dir.'&'.__genUrlParam())."&response_type=code&scope=snsapi_base&state=123#wechat_redirect");
			return;
		}
		else
		{
			$redirect_url 		= @$_REQUEST['dir'] == null ? '/' : urldecode($_REQUEST['dir']);						// 获取返回的url
			$CODE 				= @$_REQUEST['code'] == null ? '' : $_REQUEST['code'];						// 通过返回的code换取网页授权access_token和openid
			$user_bulding 		= new func_user_bulding( $app_info['appid'], $app_info['secret'] );
			$user_bulding->db  	= $db;																		// 赋值数据库链接
			$user_bulding->log 	= $log;																		// 赋值日志
			$arrWxinfo 			 = $user_bulding->get_wx_openid( $CODE );									// 通过code来换取openid

			try
			{
				if ( ! $arrWxinfo )
				{
					throw new Exception('登录失败！原因：您的code id不正确！');
				}

				/*----------------------------------------------------------------------------------------------------
					-- 获取用户的微信信息，来获取unionid和是否关注微信
				-----------------------------------------------------------------------------------------------------*/
				$user_info = $user_bulding->get_userinfo_from_openid( $arrWxinfo['openid'], $arrWxinfo['unionid'] );

				if ( ! $user_info )
				{
					// 该微信用户不存在，则添加
					$msg = "user login !!  输出： 该用户未绑定，将前往绑定页面！ openid:{$arrWxinfo['openid']}";
					$log->put('/user/login', $msg);														// 记录日志
					$_SESSION['is_login'] 	= FALSE;													// 登录状态为false
					//$redirect_url 			= '/user_binding';										// 跳转到绑定页面
				}
				else
				{
					// 该微信用户存在，则判断sys_login.loginname是否为空
					$msg = "user login !!   输出： 该用户已绑定，将前往指定页面！  id:{$user_info->id}, openid:{$user_info->openid}, loginname:{$user_info->loginname}, name:{$user_info->name}";
					$log->put('/user/login', $msg);														// 记录日志
					$_SESSION['is_login'] = TRUE;														// 登录状态为true
					$_SESSION['userinfo'] = $user_info;

					$user_bulding->addUserLoginLog( $user_info->id );									// 添加用户登录日志
				}

				$_SESSION['openid']   = $arrWxinfo['openid'];											// 用openid来判断是否已触发登录页
				$_SESSION['unionid']  = $arrWxinfo['unionid'];											// unionid

				$_strlen = strlen($redirect_url)-1;
				$_urlParam = __genUrlParam();
				$redirect_url .= (($redirect_url{$_strlen} == '/') ? '' : (($_urlParam=='')?'':'&'));
				($_urlParam != '') && $redirect_url .= $_urlParam;
				redirect($redirect_url);

			}
			catch( Exception $e )
			{
				$_SESSION['is_login'] 	= FALSE;														// 登录状态为false
				echo $e->getMessage();
			}
		}
}


/**
 * 退出登录
 */
function login_out()
{
 	$_SESSION['userinfo'] = null;
 	redirect('index.php');
	return;
}

/**
 * 随机生成7位数的字符串
 */
function create_randomstr( $length = 7 )
{
	$chars = "0123456789";
	$str ="";
	for ( $i = 0; $i < $length; $i++ )
	{
		$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
	}
	return $str;
}

function __genUrlParam(){
	$params = array('pid','aid','type');
	$arr = array();
	foreach($params as $v){
		isset($_GET[$v]) && $arr[] = $v.'='.$_GET[$v];
	}
	return implode('&', $arr);
}
?>
