<?php
define('HN1', true);
require_once('../global.php');

$market_admin = isset( $_SESSION['marketAdmin'] ) ? $_SESSION['marketAdmin'] : "";
$act = isset( $_REQUEST['act'] ) ? $_REQUEST['act'] :  '';


if( $market_admin != null && $act != 'logout' )							// 如果用户已登录
{
	redirect( "index.php",'该用户已登录！');
}



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

	$arrUserInfo = require_once( DATA_ROOT . 'user.php' );		// 获取用户列表

	$url = 'login.php';
	$tip = '您输入的帐号和（或）密码有误！';

	foreach( $arrUserInfo as $UserInfo )
	{
		if ( $username == $UserInfo['name'] && $pwd == $UserInfo['pwd'] )
		{
			$url = 'index.php';
			$tip = '登录成功！';
			$_SESSION['marketAdmin']   = $UserInfo;
			break;
		}
	}

	redirect( $url,$tip);
}

function logout()
{
	$_SESSION['marketAdmin'] = null;
	redirect( "login.php",'退出成功！');
}



?>

