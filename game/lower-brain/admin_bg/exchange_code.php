<?php
	define('HN1', true);
	define('SCRIPT_ROOT',  dirname(dirname(dirname(dirname(__FILE__)))).'/game/lower-brain/');
	define('INC_PATH',  SCRIPT_ROOT.'inc');

	require_once( SCRIPT_ROOT . 'global.php' );
	require_once( SCRIPT_ROOT . 'logic/game_brain_exchange_codeBean.php' );


	if (  $_SESSION['admin_login'] != 1 )
	{
		redirect('/game/lower-brain/admin_bg/login.php','请先进行登录！！');
	}


	$type = isset($_REQUEST['act']) ? $_REQUEST['act'] : null;

	$exchange_code 	= new game_brain_exchange_codeBean();
	$exchange_code->conn = $db;



	$type  = isset($_POST['act']) ? $_POST['act'] : null;


	switch ( $type )
	{
		case 'edit':

		break;

		default:
			$code_status_info 	= $exchange_code->get_code_status_count();			// 获取兑换码有效性的数量
			$valid  			= $code_status_info[0]->num;						// 获取有效的数据数量
			$novalid  			= $code_status_info[1]->num;						// 获取无效的数据数量
			include_once( '../tpl/admin/exchange_code_page.php' );
	}


?>
