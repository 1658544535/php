<?php
	define('HN1', true);
	define('SCRIPT_ROOT',  dirname(dirname(dirname(__FILE__))).'/game/lower-brain/');
	require_once( SCRIPT_ROOT . 'global.php' );
	require_once SCRIPT_ROOT . 'logic/game_brain_userBean.php';
	require_once SCRIPT_ROOT . 'inc/authorize.php';
	define('LOG_DIR', SCRIPT_ROOT . "logs" );

	$userBean = new game_brain_userBean();
	$userBean->conn = $db;

	$authorize = new authorize( $app_info['appid'], $app_info['secret']);
	$get_user_type = "userinfo";


	$return_dir = $site_game .'/login.php?'. $_SERVER['QUERY_STRING'];

	if ( $_GET['state'] == "" )																													// 第一次调用
	{
		redirect($authorize->get_code( $get_user_type, $return_dir ));																			// 通过调用微信接口，获取code
		return;
	}

	$code 			= @$_REQUEST['code'] == null ? '' : $_REQUEST['code'];																		// 通过返回的通过code换取网页授权access_token
	$decode_openid  = @$_REQUEST['cid'] == null ? '' : $_REQUEST['cid'];
	$from 			= @$_REQUEST['from'] == null ? '' : $_REQUEST['from'];
	$user_wx_info 	= ( $get_user_type == "userinfo" ) ? $authorize->get_user_info( $code ) : $authorize->get_user_base( $code );				// 获取该微信用户的信息
	$KDatetime		= date('H:i d/m/Y',time());																									// 获取当前时间

	if ( $isTestStatus )		// 测试
	{
		$user_wx_info["openid"]		= "o6MuHtzGVyS8xi5VxCs3RjhEhQfk";
	}

	// 如果不为空则进行操作
	if( $user_wx_info["openid"] != '' || ! $user_wx_info )
	{
		$userBean->openid = $user_wx_info["openid"];										// 获取用户微信openid
		$obj_user = $userBean->get_one();													// 获取本地数据库中该用户的信息

		// 如果用户已经绑定openid，则跳转到首页
		if( is_object($obj_user) )
		{
			$KFile		= LOG_DIR .'/user_weixin_login.txt';
			$KContent	= "\n\n\nuser login success ============\nusername:" .$obj_user->name." \nuserid:" .$obj_user->id."\nopenid:".$user_wx_info["openid"]."\nTime:".$KDatetime."\n";
			file_put_contents($KFile,$KContent,FILE_APPEND); 						// 记录日志

			$_SESSION['LowerBrainUser'] = $obj_user;								// 记录session
		}
		else	// 如果用户没绑定openid，则添加新的记录到sys_login表中
		{
			if ( $isTestStatus )
			{
				$userBean->name 		= "dennis";
				$userBean->openid 		= $user_wx_info["openid"];
				$userBean->img 			= "phone.png";
				$userBean->sex 			= 1;
				$userBean->province 	= '广东';
				$userBean->city 		= '深圳';
				$userBean->country 		= 'zh-cn';
				$userBean->unionid 		= 'o6_bmasdasdsad6_2sgVt7hMZOPfL';
			}
			else
			{
				$userBean->name 		= $user_wx_info['nickname'];
				$userBean->openid 		= $user_wx_info["openid"];
				$userBean->img 			= $user_wx_info["headimgurl"];
				$userBean->sex 			= $user_wx_info["sex"];
				$userBean->province 	= $user_wx_info["province"];
				$userBean->city 		= $user_wx_info["city"];
				$userBean->country 		= $user_wx_info["country"];
				$userBean->unionid 		= $user_wx_info["unionid"];
			}

			$user_id 	= $userBean->creat(); 								// 生成用户

			$KFile		= LOG_DIR .'/user_weixin_login.txt';
			$KContent	= "\n\n\nuser insert success ============\nusername:" .$userBean->name." \nuserid:" .$insert_id."\nopenid:".$userBean->openid."\nTime:".$KDatetime."\n";
			file_put_contents($KFile,$KContent,FILE_APPEND); 				// 记录日志

			$_SESSION['LowerBrainUser'] = (object)array('id'=>$user_id,'name'=>$userBean->name,'openid'=>$userBean->openid,'img'=>$userBean->img,'isExchange'=>0, 'time'=>time());
		}

		redirect('/game/lower-brain/index.php?cid=' . $decode_openid . "&entry=indexshare&from=" . $from );
		exit;
	}
	else		// 如果值为空则记录log
	{
		$KFile = LOG_DIR .'/user_weixin_error.txt';
		$KContent="CODE:".$CODE."\n Time:".$KDatetime."\n";
		file_put_contents($KFile,$KContent,FILE_APPEND);
		echo "please use by weixin!";
	}


?>
