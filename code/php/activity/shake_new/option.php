<?php

define('HN1', true);
require_once('./global.php');
require_once('./logic/shake_activityBean.php');
require_once('./logic/shake_prize_recordsBean.php');

$act = isset( $_GET['act'] ) ? $_GET['act'] : '';
$shake_activityBean 		= new shake_activityBean( $db, 'shake_activity' );
$shake_prize_recordsBean 	= new shake_prize_recordsBean( $db, 'shake_prize_records' );


switch( $act )
{

	case "option_save":

		$aid = isset( $_GET['aid'] ) ? $_GET['aid'] : 0;

		if ( $aid == 0 )
		{
			$shake_activityBean->update(array('status'=>0));
		}
		else
		{
			$shake_activityBean->update(array('status'=>0));
			$shake_activityBean->update( array('status'=>1), array('id'=>$aid) );
		}

		redirect( $site . 'option.php');

	break;

	default:
		// 否则跳转到主页
		$rs = $shake_activityBean->get_one(array('status'=>1));
		require_once('./tpl/option.php');
}

?>

