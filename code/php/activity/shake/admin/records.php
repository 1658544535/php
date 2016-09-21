<?php

define('HN1', true);
require_once('../global.php');
require_once( LOGIC_ROOT . 'shake_prize_recordsBean.php' );

$market_admin = isset( $_SESSION['marketAdmin'] ) ? $_SESSION['marketAdmin'] : '';
$act 		  = isset( $_REQUEST['act'] ) 	? $_REQUEST['act'] : '';

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

$shake_prize_recordsBean = new shake_prize_recordsBean( $db, 'shake_prize_records' );


switch ( $act )
{
	case 'del':
		$arrWhere = array( 'id'=> $_GET['rid'] );
		$rs = $shake_prize_recordsBean->del( $arrWhere );
	break;
	/*=========================== 默认列表页  ===========================*/
	default:

		$arrWhere['shake_id'] = $_GET['id'];
		$arrRecord = $shake_prize_recordsBean->get_record_list( $_GET['id'] );

		require_once("tpl/header.php");
		require_once("tpl/record_list.php");

}



?>

