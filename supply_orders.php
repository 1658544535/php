<?php

define('HN1', true);
require_once('./global.php');

require_once  LOGIC_ROOT.'user_orderBean.php';
require_once  LOGIC_ROOT.'sys_loginBean.php';
require_once  LOGIC_ROOT.'user_order_detailBean.php';
require_once  LOGIC_ROOT.'user_commentBean.php';
require_once  LOGIC_ROOT.'productBean.php';

$ib = new user_orderBean();
$ub = new sys_loginBean();
$c2b = new user_order_detailBean();
$cb = new user_commentBean();
$pb = new productBean();

$user = $_SESSION['userinfo'];
if($openid != null){
	$userid = $user->id;
}else{
	redirect("login?dir=orders");
	return;
}

$act = $_GET['act'] == null ? '' : $_GET['act'];

switch($act){
case 'confirm':
confirm_order($db);
break;
case 'user_del':
ustatus($db);
break;
default:
$ordersList = $ib->get_results_suserid($db,$userid);

break;
}

function confirm_order($db){
	$ib = new user_orderBean();

	$order_id = $_GET['order_id'] == null ? 0 : $_GET['order_id'];
	$userid = $_REQUEST['userid'] == null ? 0 : $_REQUEST['userid'];

	$ib->update_order_status($db,$status=3,$order_id);

	//更新用户积分获取数(按金额5%),添加用户积分获取记录
	$obj_order = $ib->detail($db,$order_id);

	get_integral($db,$userid,floor($obj_order->all_price),$type=1,$order_id);
	//更新上线推荐用户的积分数
	update_connection_integral($db,$userid,$order_id,floor($obj_order->all_price));
	redirect("orders");
	return;
}


function ustatus($db)
{
		$ib = new user_orderBean();
		$order_id = array();
		$order_id = $_GET['order_id'] == null ? 0 : $_GET['order_id'];


		if($ib->user_del($db,$order_id,'1'))
		{
		redirect("orders","删除成功");
			return;
	}
//else{
//			redirect('?module='.nowmodule,"系统忙,操作失败");
//			return;
//		}
	}
include "tpl/supply_orders_web.php";
?>
