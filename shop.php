<?php

define('HN1', true);
require_once('./global.php');

require_once  LOGIC_ROOT.'user_shopBean.php';
require_once  LOGIC_ROOT.'sys_loginBean.php';


$type = ! isset($_GET['type']) ? -1 : intval($_GET['type']);

$user = $_SESSION['userinfo'];

/*
if($user != null)
{
	$userid = $user->id;
}
else
{
	redirect("login.php?dir=shop");
	return;
}
*/


$user_shop 			= new user_shopBean();
$sys_login 			= new sys_loginBean();


$obj_user = $sys_login->detail($db,$userid);


if ( $type != null )
{
	//$shopList = $user_shop->searchs($db,$page,10,$type);
	$shopList = $user_shop->search($db,$type);
	include "tpl/shop_web.php";
}
else
{

	//$shopList = $user_shop->search($db,$page,4,$type);
	$shopList = $user_shop->search($db,$type);
	include "tpl/shop_web.php";
}



?>
