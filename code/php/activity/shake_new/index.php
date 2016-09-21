<?php

define('HN1', true);
require_once('./global.php');
require_once('./logic/shake_activityBean.php');
require_once('./logic/shake_prize_recordsBean.php');

$act = isset( $_GET['act'] ) ? $_GET['act'] : '';
$shake_activityBean 		= new shake_activityBean( $db, 'shake_activity' );
$shake_prize_recordsBean 	= new shake_prize_recordsBean( $db, 'shake_prize_records' );

if ( !isset($_SESSION['shake_info']) || $_SESSION['shake_info'] == "" )
{
	$_SESSION['oid'] 	= isset($_GET['oid']) ? $_GET['oid'] : "";
	$_SESSION['unid'] 	= isset($_GET['unid']) ? $_GET['unid'] : "";
	$dir = $_SERVER['REQUEST_URI'];
	redirect( $site . "login.php?&dir=" . $dir);
	exit;
}

if ( !isset($_SESSION['is_new_user']) || $_SESSION['is_new_user'] == true )
{
	redirect($site . "reg.php");
	exit;
}



switch( $act )
{
	case "share":							// 抽奖次数用完，分享页面
		require_once('./tpl/share.html');
	break;

	case "record":
		$uid = $_SESSION['shake_info']['openid'];
		$arrRecord = $shake_prize_recordsBean->get_user_record( $uid );
		require_once('./tpl/record.php');
	break;

	case "record_save":
		$id = isset( $_GET['id'] ) ? $_GET['id'] : '';
		$arrParam = array('is_used'	=> 1, 'used_time' => time() );
		$arrWhere = array( 'id' => $id, 'userid' => $_SESSION['shake_info']['openid'], 'is_used' => 0 );
		$rs  = $shake_prize_recordsBean->update( $arrParam, $arrWhere );
		redirect( $site . 'index.php?act=record');
	break;

	default:
		// 否则跳转到主页
		$rs = $shake_activityBean->get_one(array('status'=>1));
		require_once('./tpl/index.php');
}

?>

