<?php

define('HN1', true);
require_once('../global.php');
require_once( LOGIC_ROOT . 'shake_prizeBean.php' );

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

$shake_prizeBean = new shake_prizeBean( $db, 'shake_prize' );


switch ( $act )
{
	/*=========================== 添加页面  ===========================*/
	case "add":
		require_once("tpl/header.php");
		require_once("tpl/prize_add.php");
	break;

	/*=========================== 添加处理页面  ===========================*/
	case "add_save":
		// 提交添加操作！！
		$arrData['shake_id'] 		= $_POST['shake_id'];
		$arrData['prize_no'] 		= $_POST['prize_no'];
		$arrData['price'] 			= $_POST['price'];
		$arrData['name'] 			= $_POST['name'];
		$arrData['probability'] 	= $_POST['probability'];
		$arrData['introduce'] 		= $_POST['introduce'];
		$arrData['addTime'] 		= time();
		$arrData['status'] 			=( $_POST['status'] == 1 ) ? 1 : 0;

		$arrData['image'] 			= uploadfile( 'image', $path = '../upfiles/');

		$rs = $shake_prizeBean->create( $arrData );

		$tip = ( $rs > 0 ) ? '添加成功！' : '添加失败';
		redirect( $site_admin . 'prize.php?act=list&id=' . $arrData['shake_id'], $tip );

	break;

	/*=========================== 修改页面  ===========================*/
	case "edit":
		$id = isset( $_GET['id'] ) ? $_GET['id'] : -1;

		if ( $id > 0 && $id != NULL )
		{
			$arrWhere = array( 'id'=> $_GET['id'] );
			$rs = $shake_prizeBean->get_one( $arrWhere );
		}
		else
		{
			redirect( $site_admin . 'prize.php?act=list&id='.$_GET['aid'], '您查看的信息有误！' );
		}


		require_once("tpl/header.php");
		require_once("tpl/prize_edit.php");
	break;

	/*=========================== 修改处理页面  ===========================*/
	case "edit_save":
		// 提交修改操作！！
		$arrData['price'] 			= $_POST['price'];
		$arrData['prize_no'] 			= $_POST['prize_no'];
		$arrData['name'] 			= $_POST['name'];
		$arrData['probability'] 	= $_POST['probability'];
		$arrData['introduce'] 		= $_POST['introduce'];
		$arrData['status'] 			=( $_POST['status'] == 1 ) ? 1 : 0;

		$newImg = uploadfile( 'image', $path = '../upfiles/');

		 if ( $newImg != null )
		 {
		 	$arrData['image']		= $newImg;
		 }

		$arrWhere['id']			= $_POST['id'];

		$rs = $shake_prizeBean->update( $arrData, $arrWhere);

		$tip = ( $rs >= 0 ) ? '更新成功！' : '更新失败';
		redirect( $site_admin . 'prize.php?act=list&id=' . $_POST['aid'], $tip );
	break;

	/*=========================== 删除处理页面  ===========================*/
	case "del":
		// 提交删除操作！！
	break;

	/*=========================== 默认列表页  ===========================*/
	default:

		$arrRecord = $shake_prizeBean->get_list();

		require_once("tpl/header.php");
		require_once("tpl/prize_list.php");

}



?>

