<?php

define('HN1', true);
require_once('../global.php');

$TmallModel = M('tmall');

$market_admin = isset( $_SESSION['marketAdmin'] ) ? $_SESSION['marketAdmin'] : '';
$act 		  = isset( $_REQUEST['act'] ) 	? $_REQUEST['act'] : '';

if( $market_admin != null || $act == 'add' )			// 如果用户已登录
{
	$market_type 	 = $market_admin['type'];
	$market_name 	 = $market_admin['name'];
}
else													// 否则跳转到登录页面
{
	redirect("login.php");
	return;
}

$tList = $TmallModel ->getAll();

require_once('tpl/header.php');
require_once('tpl/index.php');



?>

