<?php

define('HN1', true);
require_once('../global.php');
require_once( LOGIC_ROOT . 'shake_activityBean.php' );

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

$shake_activityBean = new shake_activityBean( $db, 'shake_activity' );


switch ( $act )
{
	/*=========================== 添加页面  ===========================*/
	case "add":
		require_once("tpl/header.php");
		require_once("tpl/activity_add.php");
	break;

	/*=========================== 添加处理页面  ===========================*/
	case "add_save":
		// 提交添加操作！！
		$arrData['title'] 		= $_POST['title'];
		$arrData['play_num'] 	= $_POST['playnum'];
		$arrData['starttime'] 	= strtotime($_POST['starttime']);
		$arrData['endtime'] 	= strtotime($_POST['endtime']);
		$arrData['addTime'] 	= time();
		$arrData['status'] 		=( $_POST['status'] == 1 ) ? 1 : 0;

		$rs = $shake_activityBean->create( $arrData );

		$tip = ( $rs > 0 ) ? '添加成功！' : '添加失败';
		redirect( $site_admin . 'activity.php?act=list', $tip );

	break;

	/*=========================== 修改页面  ===========================*/
	case "edit":
		$id = isset( $_GET['id'] ) ? $_GET['id'] : -1;

		if ( $id > 0 && $id != NULL )
		{
			$arrWhere = array( 'id'=> $_GET['id'] );
			$rs = $shake_activityBean->get_one( $arrWhere );
		}
		else
		{
			redirect( $site_admin . 'activity.php?act=list', '您查看的信息有误！' );
		}


		require_once("tpl/header.php");
		require_once("tpl/activity_edit.php");
	break;

	/*=========================== 修改处理页面  ===========================*/
	case "edit_save":
		// 提交修改操作！！
		$arrData['title'] 		= $_POST['title'];
		$arrData['play_num'] 	= $_POST['playnum'];
		$arrData['starttime'] 	= strtotime($_POST['starttime']);
		$arrData['endtime'] 	= strtotime($_POST['endtime']);
		$arrData['status'] 		=( $_POST['status'] == 1 ) ? 1 : 0;

		$arrWhere['id']			= $_POST['id'];

		$rs = $shake_activityBean->update( $arrData, $arrWhere);

		$tip = ( $rs >= 0 ) ? '更新成功！' : '更新失败';
		redirect( $site_admin . 'activity.php?act=list', $tip );
	break;

	/*=========================== 删除处理页面  ===========================*/
	case "del":
		// 提交删除操作！！
	break;

	/*=========================== 默认列表页  ===========================*/
	default:

		$arrRecord = $shake_activityBean->get_list();

		require_once("tpl/header.php");
		require_once("tpl/activity_list.php");

}



?>

