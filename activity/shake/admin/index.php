<?php

define('HN1', true);
require_once('../global.php');

$market_admin = isset( $_SESSION['marketAdmin'] ) ? $_SESSION['marketAdmin'] : '';


if( $market_admin != null )								// 如果用户已登录
{
	$market_id 		 = $market_admin['id'];
	$market_type 	 = $market_admin['type'];
	$market_name 	 = $market_admin['name'];
}
else													// 否则跳转到登录页面
{
	redirect("login.php");
	return;
}


require_once('tpl/header.php');

?>

