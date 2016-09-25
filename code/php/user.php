<?php
define('HN1', true);
require_once('./global.php');

/*----------------------------------------------------------------------------------------------------
	-- 判断是否登录
-----------------------------------------------------------------------------------------------------*/
//$bLogin = $_SESSION['is_login'];

/*----------------------------------------------------------------------------------------------------
	-- 配置
-----------------------------------------------------------------------------------------------------*/
$return_url   		        = CheckDatas( 'return_url', '/index' );

$UserInfoModel 				= M('user_info');
$UserCollectModel 			= D('UserCollect');
$UserSpecialCollectModel 	= D('UserSpecialCollect');
$HistoryModel 				= D('History');
$UserOrderModel 			= D('UserOrder');

/*----------------------------------------------------------------------------------------------------
	-- 基本资料
-----------------------------------------------------------------------------------------------------*/

$objUserInfo   				= $UserInfoModel->get( array('user_id'=>$userid) );

// 商品收藏数量
$count_product = $UserCollectModel->getCollectNum( $userid );

// 专场收藏数量
$count_special = $UserSpecialCollectModel->getCollectNum( $userid );

// 足迹浏览数量
$count_history = $HistoryModel->getHistoryCount( $userid );

// 订单数
$onway_orders1 	  = $UserOrderModel->getOrderStatus( $userid, 1 );	 				// 待付款
$onway_orders2 	  = $UserOrderModel->getOrderStatus( $userid, 2 );	 				// 待发货订单
$onway_orders3 	  = $UserOrderModel->getOrderStatus( $userid, 3 );	 				// 待收货订单
$onway_orders4 	  = $UserOrderModel->getOrderStatus( $userid, 4 );	 				// 待评价订单

// 售后
$UserOrderRefundModel = D('UserOrderRefund');
$order_refund_num 	  = $UserOrderRefundModel->getUserOrderRefundCount( $userid );	 // 我的足迹

$objLogin = M('sys_login');
$user = $objLogin->get(array('id'=>$userid));

$footerNavActive = 'user';

include "tpl/user_web.php";
?>
