<?php

define('HN1', true);
require_once('../global.php');


$market_admin = isset( $_SESSION['marketAdmin'] ) ? $_SESSION['marketAdmin'] : '';
$act 		  = isset( $_REQUEST['act'] ) 	? $_REQUEST['act'] : '';

if( $market_admin != null )								// 如果用户已登录
{
	$market_type 	 = $market_admin['type'];
	$market_name 	 = $market_admin['name'];
}
else													// 否则跳转到登录页面
{
	redirect("login.php");
	return;
}

switch( $act )
{
	/*=========================== 修改逻辑页  ===========================*/
	case 'edit_save':
		$arr['start_id'] 		= intval($_REQUEST['start_id']);
		$arr['end_id'] 			= intval($_REQUEST['end_id']);
		$arr['product_num'] 	= intval($_REQUEST['product_num']);
		$arr['count'] 			= intval($_REQUEST['count']);
		$arr['time'] 			= intval($_REQUEST['time']);
		$arr['user_num']		= intval($_REQUEST['user_num']);

		file_put_contents('config.ini', json_encode($arr));
		redirect( $site_admin . 'setting.php', '设置成功' );

	break;

	/*=========================== 修改临时逻辑页  ===========================*/
	case 'temp_edit_save':
		require_once( LOGIC_ROOT . 'UserOrderBean.php');
		require_once( LOGIC_ROOT . 'UserOrderDetailBean.php');

		$arr['start_id'] 		= intval($_REQUEST['start_id']);
		$arr['end_id'] 			= intval($_REQUEST['end_id']);
		$arr['time'] 			= $_REQUEST['time'];
		$UserOrderBean 			= new UserOrderBean( $db,  'user_order' );
		$UserOrderDetailBean 	= new UserOrderDetailBean( $db,  'user_order_detail' );

		$arrData = $UserOrderBean->getTempOrder($arr);							// 获取条件符合的数据

		if ( $arrData != null )
		{
			foreach ( $arrData as $Data )
			{
				$arrTime = preg_split( '# #', $Data->create_date );
				$date = $arr['time'] . ' ' . $arrTime[1];						// 组合新的订单时间
				$UserOrderBean->changeOrderData( $date, $Data->id );			// 修改订单时间
				$UserOrderDetailBean->changeOrderData( $date, $Data->id );		// 修改订单详情时间
			}
		}

		redirect( $site_admin . 'setting.php?act=temp_edit', '设置成功' );

	break;

	/*=========================== 修改临时页  ===========================*/
	case 'temp_edit':
		require_once("tpl/header.php");
		require_once("tpl/temp_setting.php");
	break;

	/*=========================== 自动刷单设置页  ===========================*/
	case 'auto':
		require_once("tpl/header.php");
		require_once("tpl/auto_setting.php");
	break;

	/*=========================== 显示页  ===========================*/
	default:
		$strData = file_get_contents('config.ini');
		$arrData = json_decode( $strData, true );

		require_once("tpl/header.php");
		require_once("tpl/setting.php");

}

?>

