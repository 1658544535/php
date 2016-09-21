<?php

define('HN1', true);
require_once('../global.php');

$market_admin = isset( $_SESSION['marketAdmin'] ) ? $_SESSION['marketAdmin'] : "";

if( $market_admin != null )										// 如果用户已登录
{
	$market_admin_id = $market_admin['id'];
}

$act = isset( $_REQUEST['act'] ) ? $_REQUEST['act'] :  '';


switch( $act )
{
	case 'post':
		check();
	break;

	case 'logout':
		logout();
	break;

	default:
		include "tpl/login.php";
}


function check()
{
	$username	= isset($_POST['username']) ? sqlUpdateFilter($_POST['username']) 	 : '';
	$pwd 		= isset($_POST['pwd']) 		? md5($_POST['pwd']) 					 : '';

	if ( $username == 'admin' && $pwd == 'e10adc3949ba59abbe56e057f20f883e' )
	{
		$_SESSION['marketAdmin']['name']   = 'marketAdmin';
		$_SESSION['marketAdmin']['id']     = '199999';
		$_SESSION['marketAdmin']['type']   = '1';
		redirect("index.php",'登录成功！');
	}
	else
	{
		redirect("login.php",'您输入的帐号和（或）密码有误！');
	}

}

function logout()
{
	$_SESSION['marketAdmin'] = null;
	redirect( "login.php",'退出成功！');
}



?>

