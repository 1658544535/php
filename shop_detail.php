<?php

define('HN1', true);
require_once('./global.php');

require_once  LOGIC_ROOT.'productBean.php';
require_once  LOGIC_ROOT.'user_shop_collectBean.php';


$id = $_REQUEST['id'] == null ? -1 : intval($_REQUEST['id']);


$pb 				= new productBean();
$user 				= $_SESSION['userinfo'];
$user_type 			= $user->type;


$shop 				= $db->get_row("select * from user_shop where  id='".$id."'");
$main_category		= $db->get_var("select name from sys_dict where type ='main_category'and value='".$shop->main_category."' ");
$province			= $db->get_var("select name from sys_area  where id = '".$shop->province."' ");
$city				= $db->get_var("select name from sys_area  where id = '".$shop->city."' ");
$area				= $db->get_var("select name from sys_area  where id = '".$shop->area."' ");
$address			= $province.$city.$area;

$similar_products 	= $pb->get_results_userid($db,$shop->user_id);

$user_shop_collect 	= new user_shop_collectBean();
$is_collect  		= 	$user_shop_collect->is_collect($db,$user->id, $id);

include "tpl/shop_detail_web_new.php";
?>
