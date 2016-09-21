<?php
define('HN1', true);
require_once('./global.php');
require_once('./logic/shake_activityBean.php');
require_once('./logic/shake_prize_recordsBean.php');

$act = isset( $_GET['act'] ) ? $_GET['act'] : '';
$shake_activityBean 		= new shake_activityBean( $db, 'shake_activity' );
$shake_prize_recordsBean 	= new shake_prize_recordsBean( $db, 'shake_prize_records' );

$objActivityInfo = get_activity_info($shake_activityBean);		// 获取进行中的活动ID
$_SESSION['shake_activity_id'] = ( $objActivityInfo != null ) ? $objActivityInfo->id : 0;

switch( $act )
{
	case "share":							// 抽奖次数用完，分享页面
		require_once('./tpl/share.html');
	break;

	case "record":
		$uid = $_SESSION['shake_info']['openid'];
		$arrRecord = $shake_prize_recordsBean->get_user_record( $uid, $_SESSION['shake_activity_id'] );
		require_once('./tpl/record.php');
	break;

	default:
		if ( !isset($_SESSION['shake_info']) || $_SESSION['shake_info'] == "" )
		{
			$_SESSION['oid'] 	= isset($_GET['oid']) ? $_GET['oid'] : "";
			$_SESSION['unid'] 	= isset($_GET['unid']) ? $_GET['unid'] : "";
			$dir = $_SERVER['REQUEST_URI'];
			redirect( $site . "login.php?&dir=" . $dir);
			exit;
		}

		// 否则跳转到主页
		require_once('./tpl/index.php');
}


/*
 * 功能：获取活动信息
 * */
function get_activity_info($shake_activityBean)
{
	$arrWhere['status'] = 1;
	$arrCol = array('id','title','starttime','endtime');
	$strOrderBy = '`id` DESC';
	return $shake_activityBean->get_one( $arrWhere, $arrCol, $strOrderBy );
}



?>

