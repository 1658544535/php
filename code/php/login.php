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
		if($state == '')		// 第一次进入登录，则先获取code;
		{
			$_bcUrl = $site."login.php?dir=".$dir.'&'.__genUrlParam();
			redirect($objWX->getOauthRedirect($_bcUrl, '123', 'snsapi_base'));
			return;
		}
		else
		{
			$redirect_url = @$_REQUEST['dir'] == null ? '/' : urldecode($_REQUEST['dir']);
			$_SESSION['is_login'] = false;
			$wxInfo = $objWX->getOauthAccessToken();
			if($wxInfo === false){
				$log->put('/user/login', 'user login! 获取用户openid失败');
			}else{
				$userInfo = apiData('userlogin.do', array('openid'=>$wxInfo['openid'],'source'=>3));
				if($userInfo['success']){
					$userInfo = $userInfo['result'];
					$_wxUserInfo = $objWX->getUserInfo($wxInfo['openid']);
					//没有头像则获取微信头像
					if($userInfo['image'] == ''){
						if($_wxUserInfo['headimgurl']){
							$_dir = SCRIPT_ROOT.'upfiles/headimage/';
							!file_exists($_dir) && mkdir($_dir, 0777, true);
							$_headimg = $_dir.$wxInfo['openid'].'.jpg';
//							file_put_contents($_headimg, file_get_contents($_wxUserInfo['headimgurl']));
							$ch = curl_init($_wxUserInfo['headimgurl']);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
							$avatar = curl_exec($ch);
							curl_close($ch);
							file_put_contents($_headimg, $avatar);
							$editResult = apiData('editUserInfo.do', array('uid'=>$userInfo['uid'],'file'=>'@'.$_headimg), 'post');
							$editResult['success'] && $userInfo['image'] = $_wxUserInfo['headimgurl'];
						}
					}
					$log->put('/user/login', "user login! 微信用户自动登录，openid:{$wxInfo[openid]}，用户id:{$userInfo[uid]}，帐号:{$userInfo[phone]}，昵称:{$userInfo[name]}，关注公众号：".(($_wxUserInfo === false)?'':($_wxUserInfo['subscribe']?'已关注':'尚未关注')));
					$_tmp = new stdClass();
					$_tmp->openid = $wxInfo['openid'];
					$_tmp->id = $userInfo['uid'];
					$_tmp->loginname = $userInfo['phone'];
					$_tmp->name = $userInfo['name'];
					$_tmp->image = $userInfo['image'];
					$_SESSION['userinfo'] = $_tmp;
					$_SESSION['is_login'] = true;
				}else{
					$log->put('/user/login', "user login! 微信用户【{$wxInfo[openid]}】未注册");
				}
				$_SESSION['openid'] = $wxInfo['openid'];
			}
			$_strlen = strlen($redirect_url)-1;
			$_urlParam = __genUrlParam();
			$redirect_url .= (($redirect_url{$_strlen} == '/') ? '' : (($_urlParam=='')?'':'&'));
			($_urlParam != '') && $redirect_url .= $_urlParam;
			redirect($redirect_url);
		}
		break;
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
	$params = array('pid','aid','type','gid','pdkUid');
	$arr = array();
	foreach($params as $v){
		isset($_GET[$v]) && $arr[] = $v.'='.$_GET[$v];
	}
	return implode('&', $arr);
}
?>
