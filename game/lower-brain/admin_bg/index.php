<?php
	define('HN1', true);
	define('SCRIPT_ROOT',  dirname(dirname(dirname(dirname(__FILE__)))).'/game/lower-brain/');

	require_once( SCRIPT_ROOT . 'global.php' );

	define('LOG_PATH',  dirname(dirname(dirname(__FILE__))).'/logs');

	if (  $_SESSION['admin_login'] != 1 )
	{
		redirect('/game/lower-brain/admin_bg/login.php','请先进行登录！！');
	}

	include_once( '../tpl/admin/index.php' );


?>
