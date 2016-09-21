<?php
	define('HN1', true);
	define('SCRIPT_ROOT',  dirname(dirname(dirname(dirname(__FILE__)))).'/game/lower-brain/');
	define('INC_PATH',  SCRIPT_ROOT.'inc');

	require_once( SCRIPT_ROOT . 'global.php' );

	$type  = isset($_REQUEST['act']) ? $_REQUEST['act'] : null;

	if (  $_SESSION['admin_login'] != 1 )
	{
		redirect('/game/lower-brain/admin_bg/login.php','请先进行登录！！');
	}

	switch ( $type )
	{
		case 'decode':		// 加密页
			$encrypt = isset($_REQUEST['val']) ? $_REQUEST['val'] : null;
			$res = ( $encrypt != null ) ?  mc_encrypt($encrypt, MCKEY) : null;

			include_once( '../tpl/admin/decode_page.php' );
		break;

		case 'encode':		// 解密页

			$encrypt = isset($_REQUEST['val']) ? $_REQUEST['val'] : null;
			$res = ( $encrypt != null ) ?  mc_decrypt(urldecode($encrypt), MCKEY) : null;

			include_once( '../tpl/admin/encode_page.php' );
		break;

	}


?>
