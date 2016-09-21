<?php
define('HN1', true);
require_once('./global.php');
require_once('./logic/shake_activityBean.php');
require_once('./logic/shake_prize_recordsBean.php');
require_once('./logic/shake_prizeBean.php');
require_once('./logic/shake_linkBean.php');
require_once('./model/shake_api.php');


/*================================== 实例化数据类  ==============================================*/
$shake_activityBean 		= new shake_activityBean( $db, 'shake_activity' );
$shake_prize_recordsBean 	= new shake_prize_recordsBean( $db, 'shake_prize_records' );
$shake_prizeBean 			= new shake_prizeBean( $db, 'shake_prize' );
$shake_linkBean 			= new shake_linkBean( $db, 'shake_link');


/*================================== 实例化接口类  ==============================================*/
$objApi = new api( $shake_activityBean, $shake_prize_recordsBean, $shake_prizeBean, $shake_linkBean );
$objApi->nUserID = $_SESSION['shake_info']['openid'];


/*================================== 根据act获取相应的操作  ==============================================*/
$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';


switch( $act )
{
	/*=============================== 获取正在进行的活动的信息  ===============================*/
	case 'get_activity_info':
		// 获取数据表信息
		$rs = $objApi->now_activity;

		// 判断有效性
		$enable =  $objApi->check_activity_status();

		$data = array(
			'id' 		=> $rs->id,
			'title'		=> $rs->title,
			'starttime'	=> date( 'Y-m-d H:i:s', $rs->starttime ),
			'endtime'	=> date( 'Y-m-d H:i:s', $rs->endtime ),
			'enable'	=> $enable
		);
		echo get_api_data( $data, 200, $rs->title );
	break;

	/*=============================== 获取此次抽奖的结果  ===============================*/
	case 'get_activity_result':

		do
		{
			if ( $objApi->check_activity_status() == 0 )
			{
				// 先判断活动的有效性
				echo get_api_data( -101, -101, '该活动已结束！' );
				break;
			}

			if ( ! $objApi->is_allow_lottery_draw() )
			{
				// 先判断是否允许抽奖
				echo get_api_data( -102, -102, '您的抽奖次数已用完！' );
				break;
			}

			$activity_info = $objApi->now_activity;
			$arrWhere = array( 'shake_id' => $activity_info->id, 'openid'=> $_SESSION['shake_info']['openid'] );
			$arrCol = array( 'subscribe' );
			$arrShakeUserInfo = $shake_linkBean->get_one( $arrWhere, $arrCol );

			if ( $arrShakeUserInfo->subscribe  == 0 )
			{
				$data = array(
					'name' 		=> '您还未关注',
					'introduce' => '您需要关注后才可以看到奖品哦！',
					'image'		=> 'qrcode.png'
				);
				echo get_api_data( $data, -103, '您需要先关注后才可以看到奖品哦！' );
				break;
			}

			$data = $objApi->set_prize_record();

			if ( $data['prize_no'] == 0 )
			{
				// 未中奖
				echo get_api_data( -104, -104, '很遗憾，没得到奖品！' );
				break;
			}

			echo get_api_data( $data, 200, '成功获得奖品！' );
		}
		while(0);
	break;

	/*================================= 默认状态下的信息  ===================================*/
	default:
		echo get_api_data( '欢迎您！', 200, '欢迎您！' );
}



/*================================= code代码说明  ===================================*/
/*
 * -101：活动已结束
 * -102：抽奖次数已用完
 * -103：用户未关注
 * -104:未中奖
 * 	200: 获取数据成功
 */



?>

