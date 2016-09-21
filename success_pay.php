<?php
define('HN1', true);
require_once('./global.php');

require_once  LOGIC_ROOT.'user_orderBean.php';
require_once  LOGIC_ROOT.'sys_loginBean.php';
require_once  LOGIC_ROOT.'user_order_detailBean.php';
require_once  LOGIC_ROOT.'productBean.php';

$user_order 			= new user_orderBean();
$sys_login 				= new sys_loginBean();
$user_order_detail 		= new user_order_detailBean();
$product 				= new productBean();
$order_id 				= $_REQUEST['order_id'] == null ? "" : $_REQUEST['order_id'];
$order_ids 				= ( $order_id == "" ) ?  null : explode(",",$order_id);
$exp_value 				= $_GET['exp_value'] == null ? 0 : intval($_GET['exp_value']);
$pay_method 			= $_GET['pay_method'] == null ? 1 : intval($_GET['pay_method']);
$user 					= $_SESSION['userinfo'];

if($openid != null)
{
	$userid = $user->id;
}
else
{
	redirect("login?dir=orders");
	return;
}

/*
 * 功能：更新状态流程：
 * 1、更新订单的状态
 * 2、如果状态更新成功，则更新产品销量
 * */

if ( $order_ids != null )
{
	//更改订单状态为待发货和支付转态。
	foreach( $order_ids as $order_id )
	{
		$obj_order = $user_order->get_order_info($db,$order_id,$userid);
		if ( $obj_order != null )
		{
			$change_status = $user_order->pay_change_order_status( $db, $order_id, $userid ); 				// 更新用户订单状态

			if ($change_status)
			{
				$carts = $user_order_detail->get_results_order($db,$order_id);

				//更新产品购买数
				foreach($carts as $cart)
				{
					$product->update_sell_number($db,$cart->num,$cart->product_id);
				}
			}
		}
	}
}
include "tpl/success_pay_web.php";

?>
