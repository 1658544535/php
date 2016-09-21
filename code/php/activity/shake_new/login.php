<?php
define('HN1', true);
require_once('./global.php');
require_once( LOGIC_ROOT .'shake_linkBean.php');
require_once( LOGIC_ROOT .'sys_loginBean.php');

$act 			= !isset($_REQUEST['act'])   ? ''     : $_REQUEST['act'];
$dir 			= !isset($_REQUEST['dir'])   ? $site : $_REQUEST['dir'];
$state 			= !isset($_REQUEST['state']) ? ''     : $_REQUEST['state'];
$log_file		= dirname(__FILE__) . "/logs/login/" . date("Ymd") . ".log";
$shake_linkBean = new shake_linkBean( $db, 'shake_link' );
$sys_loginBean  = new sys_loginBean( $db, 'sys_login' );


/*
 * 登录检测步骤：
 * 1、 通过授权链接获取code
 * 2、 通过返回的code换取网页授权access_token和openid
 * 2、 判断返回的信息是否为空，如果为空则出错，否则进行下一步操作
 * 3、 检测该sys_login.openid是否存在，如果存在则继续操作,如果不存在则添加用户记录
 * */

switch($act)
{
	/*============== 登录操作 ==============*/
	default:

		if ( $isDebug )		/*============== 获取用户信息（在测试环境中） ==============*/
		{
			// 用户信息
			$userinfo = array(
				'subscribe' 		=> '1',
			    'openid' 			=> 'o6MuHtwL7s7gntl6xYmXHikcD6zQ',
			    'nickname' 			=> '孩er',
			    'sex' 				=> '1',
			    'language' 			=> 'zh_CN',
			    'city' 				=> '深圳',
			    'province' 			=> '广东',
			    'country' 			=> '中国',
			    'headimgurl' 		=> 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLBDpgBPDVic6HwAcVexKb1IGaiaqQeI4q2IksyiaQV6KTibYCujIBYEg3bWmyveJ539wBpYOLvSCRLibKQ/0',
			    'subscribe_time' 	=> '1440069192',
			    'unionid' 			=> 'o5Tz0siAWAHfw0ixZnmzEzaLXx_0',
			    'remark' 			=> '',
			    'groupid' 			=> '0'
			);
		}
		else				/*============== 获取用户信息（在正式环境中） ==============*/
		{

			if( $state == '' )		// 第一次进入登录，则先获取code;
			{
				redirect("https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$app_info['appid']."&redirect_uri=".urlencode($site."login.php?state=123&dir=".$dir)."&response_type=code&scope=snsapi_base&state=123#wechat_redirect");
				return;
			}
			else
			{
				$CODE 			= $_REQUEST['code'] == null ? '' : $_REQUEST['code'];						// 获取返回的CODE
				$result_array 	= get_access_token($CODE);													// 通过返回的CODE换取网页授权access_token和openid

				if ( isset($result_array['errcode']) )
				{
					log_result($log_file,"errcode：".$result_array['errcode']."\nerrmsg：".$result_array['errmsg']);
				}
				else
				{
					$userinfo = get_userinfo($access_token, $result_array['openid']);						// 通过access_token和openid获取用户基本信息
				}
			}
		}

		/*================================== 保存session并记录到数据表 ==================================*/
		// 分享者信息
		$arrShareUserInfo = array(
			'openid'			=> $_SESSION['oid'],
			'unionid'			=> $_SESSION['unid']
		);

		// 记录session用于分享用
		$_SESSION['shake_info'] = array(
			'openid'	=> $userinfo['openid'],
			'unionid'	=> $userinfo['unionid'],
			'user_name'	=> $userinfo['nickname']
		);

		// 活动场次
		$shake_activity_id = $_SESSION['shake_activity_id'];

		if ( $shake_activity_id != 0 )
		{
			// 将用户信息记录到数据表
			record_user_info( $shake_linkBean, $userinfo, $arrShareUserInfo, $shake_activity_id );
		}


		/*================================== 判断该用户是否为新用户 ==================================*/
		//$_SESSION['is_new_user'] = is_user_new( $sys_loginBean, $userinfo['unionid'] );
		$_SESSION['is_new_user'] = is_user_new( $sys_loginBean, $userinfo['openid'] );

		$redirect_url 	= $_SESSION['is_new_user'] === FALSE ? 'index.php' : 'reg.php';						// 获取返回的url
		redirect($redirect_url);
}




/*
 * 功能：获取登录用户的信息，并检查是否存在记录，如果不在则添加到数据表
 * 参数：
 * @param object $shake_linkBean		shake_link数据模型类
 * @param array $arrMineUserInfo		要记录的用户信息
 * @param array $arrShareUserInfo		获取分享者的用户信息
 *
 * */
function record_user_info( $shake_linkBean, $arrMineUserInfo, $arrShareUserInfo, $shake_activity_id )
{
	$arrParam = array( 'openid'=> $arrMineUserInfo['openid'], 'shake_id'=> $shake_activity_id );
	$rs 	  = $shake_linkBean->get_one( $arrParam );						// 查找用户与该场次是否存在记录

	if ( $rs == null && $arrMineUserInfo != null )
	{
		// 如果为空则添加
		$arrParam = array(
			'subscribe' 		=> $arrMineUserInfo['subscribe'],
		    'openid' 			=> $arrMineUserInfo['openid'],
		    'nickname' 			=> $arrMineUserInfo['nickname'],
		    'sex' 				=> $arrMineUserInfo['sex'],
		    'language' 			=> $arrMineUserInfo['language'],
		    'city' 				=> $arrMineUserInfo['city'],
		    'province' 			=> $arrMineUserInfo['province'],
		    'country' 			=> $arrMineUserInfo['country'],
		    'headimgurl' 		=> $arrMineUserInfo['headimgurl'],
		    'subscribe_time' 	=> $arrMineUserInfo['subscribe_time'],
		    'unionid' 			=> $arrMineUserInfo['unionid'],
		    'remark' 			=> $arrMineUserInfo['remark'],
		    'groupid' 			=> $arrMineUserInfo['groupid'],
		    'share_openid' 		=> $arrShareUserInfo['openid'],
		    'share_unionid' 	=> $arrShareUserInfo['unionid'],
		    'shake_id'			=> $shake_activity_id
		);

		$rs = $shake_linkBean->create( $arrParam );
	}
}

/**
 * 	获取指定用户是否为平台新用户
 *
 * @param object $sys_loginBean
 * @param string $unionid
 * @return bool  true:新用户  false:旧用户
 * */
//function is_user_new( $sys_loginBean, $unionid )
function is_user_new( $sys_loginBean, $openid )
{
	//$rs = $sys_loginBean->get_one( array('unionid'=>$unionid) );
	$rs = $sys_loginBean->get_one( array('openid'=>$openid) );
	return ( $rs == null ) ? true : false;
}


/*
 * 微信授权步骤：
 * 第一步：用户同意授权，获取code
 * 第二步：通过code换取网页授权access_token
 * 第三步：刷新access_token（如果需要）
 * 第四步：拉取用户信息(需scope为 snsapi_userinfo)
 * */


//	微信返回信息
//				Array
//				(
//				    [access_token] => OezXcEiiBSKSxW0eoylIeGrXUQP_y0URJagAu_GiSvLCkGHeUsM7oD8mLT3MI2hrhXwRVrJfDGfK0oJaZZ82pY4c7KnYKKdumG44UWHUOb6hjt-VQE4O9xFsEFEk0npvJbq0ImEIcbtyEePVQNEs-g
//				    [expires_in] => 7200
//				    [refresh_token] => OezXcEiiBSKSxW0eoylIeGrXUQP_y0URJagAu_GiSvLCkGHeUsM7oD8mLT3MI2hrJKWv6vqzrEh9RGLT85A24mfuTvAhyLgkt95oMfeaZhRHWraxZrrnQ8fHYK00HdYlEHDYqgvKK8a9iS1hq6I4cw
//				    [openid] => o6MuHtwL7s7gntl6xYmXHikcD6zQ
//				    [scope] => snsapi_base
//				    [unionid] => o5Tz0siAWAHfw0ixZnmzEzaLXx_0
//				)
//				Array
//				(
//				    [subscribe] => 1
//				    [openid] => o6MuHtwL7s7gntl6xYmXHikcD6zQ
//				    [nickname] => 孩er
//				    [sex] => 1
//				    [language] => zh_CN
//				    [city] => 深圳
//				    [province] => 广东
//				    [country] => 中国
//				    [headimgurl] => http://wx.qlogo.cn/mmopen/ajNVdqHZLLBDpgBPDVic6HwAcVexKb1IGaiaqQeI4q2IksyiaQV6KTibYCujIBYEg3bWmyveJ539wBpYOLvSCRLibKQ/0
//				    [subscribe_time] => 1440069192
//				    [unionid] => o5Tz0siAWAHfw0ixZnmzEzaLXx_0
//				    [remark] =>
//				    [groupid] => 0
//				)


/*
$_SESSION 管理：
$_SESSION['shake_info'] :记录游戏者的	openid、 unionid、 user_name、 mobile
$_SESSION['oid']:  分享者的openid
$_SESSION['unid'] :  分享者的unionid
$_SESSION['shake_activity_id']: 活动场次
$_SESSION['is_new_user']： 游戏者是否为新用户，如果是需要进行注册

*/
?>
