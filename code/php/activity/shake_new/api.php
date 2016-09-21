<?php
define('HN1', true);
require_once('./global.php');
require_once('./logic/shake_activityBean.php');
require_once('./logic/shake_prize_recordsBean.php');
require_once('./logic/shake_prizeBean.php');
require_once('./logic/shake_linkBean.php');
require_once('./model/shake_api.php');
require_once('./wxpay/redpack/RedPackCore.php');


/*================================== 实例化数据类  ==============================================*/
$shake_activityBean 		= new shake_activityBean( $db, 'shake_activity' );
$shake_prize_recordsBean 	= new shake_prize_recordsBean( $db, 'shake_prize_records' );
$shake_prizeBean 			= new shake_prizeBean( $db, 'shake_prize' );
$shake_linkBean 			= new shake_linkBean( $db, 'shake_link');
$RedPackCore				= new RedPackCore('cash');


/*================================== 实例化接口类  ==============================================*/
$objApi = new api( $db, $shake_activityBean, $shake_prize_recordsBean, $shake_prizeBean, $shake_linkBean );
$objApi->nUserID = $_SESSION['shake_info']['openid'];


/*================================== 根据act获取相应的操作  ==============================================*/
$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

switch( $act )
{
	/*=============================== 获取此次抽奖的结果  ===============================*/
	case 'get_activity_result':

		do
		{
			if (  !isset($_SESSION['is_new_user']) ||  $_SESSION['is_new_user'] == true )
			{
				// 判断是否为新用户
			 	echo get_api_data( -100, -100, '请您先进行注册' );
			 	break;
			}

			// 判断活动状态
			$activity_info = $objApi->now_activity;

			if ( $activity_info == null )
			{
				// 先判断活动的有效性
				echo get_api_data( -101, -101, '没有进行中的活动！' );
				break;
			}

			if ( $activity_info->starttime > time() )
			{

				echo get_api_data( -101, -101, '该活动还未开始！' );
				break;
			}

			if ( $activity_info->endtime < time() )
			{
				// 先判断活动的有效性
				echo get_api_data( -101, -101, '该活动已结束！' );
				break;
			}

			if ( $activity_info->status == 0 )
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


			// 抽奖
			$data = $objApi->set_prize_record();

			if ( $data == 0 )
			{
				// 未中奖
				echo get_api_data( -104, -104, '您获得再来一次的机会！' );
				break;
			}

			if( $data == -1 )
			{
				// 全部奖品结束
				echo get_api_data( -101, -101, '奖品都发完咯，活动结束！' );
				break;
			}

			if ( $data['prize_no'] == 0 )
			{
				// 未中奖
				echo get_api_data( -104, -104, '很遗憾，没得到奖品！' );
				break;
			}

			if ( $data['prize_no'] == 1 )
			{
				// 发送红包
				send_redpack( $RedPackCore, $objApi->nUserID, $data['price']*100 );
			}

			echo get_api_data( $data, 200, '成功获得奖品！' );
		}
		while(0);
	break;


	case "test":

		for( $i=1; $i<=200; $i++ )
		{
			$objApi->nUserID = $i;
			$data = $objApi->set_prize_record();
		}

	break;

	case "test2":

		for( $i=200; $i<=400; $i++ )
		{
			$objApi->nUserID = $i;
			$data = $objApi->set_prize_record();
		}

	break;

	case "test3":

		for( $i=400; $i<=600; $i++ )
		{
			$objApi->nUserID = $i;
			$data = $objApi->set_prize_record();
		}

	break;

	/*================================= 默认状态下的信息  ===================================*/
	default:
		echo get_api_data( '欢迎您！', 200, '欢迎您！' );
}



/**
 * 发送红包
 * */

 function send_redpack( $RedPackCore, $openid, $totalAmount )
 {
 	// 发送红包
	$RedPackCore->setSendName( '淘竹马' );
	$RedPackCore->setReOpenID( $openid );
	$RedPackCore->setTotalAmount( $totalAmount );
	$RedPackCore->setWishing( '不管平常多么忙碌，请一定要幸福，红包略表心意，祝你圣诞快乐！' );
	$RedPackCore->setActName( '圣诞乐翻天'  );
	$RedPackCore->setRemark( '全宇圣诞晚会'  );

	$rs = $RedPackCore->cash_option();

	if ( $rs['return_code'] != 'SUCCESS' || $rs['result_code'] != 'SUCCESS' )
	{
		Log::DEBUG("\n红包发送失败，原因：\nerr_code：{$rs['err_code']}\nreturn_msg：{$rs['return_msg']}\nerr_code_des：{$rs['err_code_des']}\nmch_billno:{$rs['mch_billno']}\nre_openid:{$rs['re_openid']}\ntotal_amount:{$rs['total_amount']}");
	}
	else
	{
		Log::DEBUG("\n红包发送成功，结果：\nreturn_msg：{$rs['return_msg']}\nmch_billno:{$rs['mch_billno']}\nre_openid:{$rs['re_openid']}\ntotal_amount:{$rs['total_amount']}\nsend_time:{$rs['send_time']}\nsend_listid:{$rs['send_listid']}");
	}


	return $rs;



 }



/*================================= code代码说明  ===================================*/
/*
 * -100: 用户需要注册
 * -101：活动状态（  没有进行中的活动！！  该活动还未开始！！  该活动已结束！！  奖品都发完咯，活动结束！  ）
 * -102：抽奖次数已用完
 * -103：用户未关注
 * -104:未中奖
 * 	200: 获取数据成功
 */



?>

