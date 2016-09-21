<?php
	define('HN1', true);
	define('SCRIPT_ROOT',  dirname(dirname(dirname(dirname(__FILE__)))).'/game/lower-brain/');

	require_once( SCRIPT_ROOT . 'global.php' );

	define('LOG_PATH',  dirname(dirname(dirname(__FILE__))).'/logs');




	$act = ( isset( $_REQUEST['act'] ) ) ? $_REQUEST['act'] :  null;



	switch( $act )
	{
		case "login_save":

			$user_name 	= $_POST['user_name'];
			$pwd 		= $_POST['pwd'];

			if ( $user_name == 'adminroot' && $pwd == 'taozhumaadminlogin0321' )
			{
				$_SESSION['admin_login'] = 1;
				redirect('/game/lower-brain/admin_bg','登录成功！');
			}
			else
			{
				redirect('/game/lower-brain/admin_bg/login.php','登录失败！请重试！');
			}

		break;

		case "loginout":
				$_SESSION['admin_login'] = null;
				redirect('/game/lower-brain/admin_bg/login.php','安全登出！');
		break;

		default:
			include_once( '../tpl/admin/login.php' );
	}




?>
