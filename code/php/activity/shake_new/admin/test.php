<?php

define('HN1', true);
require_once('../global.php');


$market_admin = isset( $_SESSION['marketAdmin'] ) ? $_SESSION['marketAdmin'] : '';
$act 		  = isset( $_GET['act'] ) 	? $_GET['act'] : '';

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


switch ( $act )
{
	/*=========================== 添加页面  ===========================*/
	case "add":
		require_once("tpl/header.php");
		require_once("tpl/add.php");
	break;
	
	/*=========================== 添加处理页面  ===========================*/
	case "add_save":
		// 提交添加操作！！
	break;
	
	/*=========================== 修改页面  ===========================*/
	case "edit":
		require_once("tpl/header.php");
		require_once("tpl/edit.php");
	break;
	
	/*=========================== 修改处理页面  ===========================*/
	case "edit_save":
		// 提交修改操作！！
	break;
	
	/*=========================== 删除处理页面  ===========================*/
	case "del":
		// 提交删除操作！！
	break;
	
	/*=========================== 默认列表页  ===========================*/
	default:
		require_once("tpl/header.php");
		require_once("tpl/list.php");
		
}



?>

