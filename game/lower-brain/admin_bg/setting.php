<?php
	define('HN1', true);
	define('SCRIPT_ROOT',  dirname(dirname(dirname(dirname(__FILE__)))).'/game/lower-brain/');
	define('INC_PATH',  SCRIPT_ROOT.'inc');

	require_once( SCRIPT_ROOT . 'global.php' );

	$type  = isset($_POST['act']) ? $_POST['act'] : null;

	if (  $_SESSION['admin_login'] != 1 )
	{
		redirect('/game/lower-brain/admin_bg/login.php','请先进行登录！！');
	}


	switch ( $type )
	{
		case 'edit':
			$arr['enable'] 			= $_POST['enable'];
			$arr['error_num'] 		= $_POST['error_num'];
			$arr['success_scroe'] 	= $_POST['success_score'];
			$arr['math_game_time'] 	= $_POST['math_game_time'];
			$arr['code_num'] 		= $_POST['code_num'];

			$dataStr = json_encode($arr);
			file_put_contents( INC_PATH . '/game.ini',$dataStr);
			redirect( $site_game_bg . '/setting.php','设置成功！');
		break;

		default:
			$dataStr = file_get_contents( INC_PATH . '/game.ini' );
			$objData = json_decode( $dataStr );
			include_once( '../tpl/admin/setting.php' );
	}


?>
