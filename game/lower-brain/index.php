<?php
	define('HN1', true);
	define('SCRIPT_ROOT',  dirname(dirname(dirname(__FILE__))).'/game/lower-brain/');
	require_once( SCRIPT_ROOT . 'global.php' );
	require_once( SCRIPT_ROOT . 'logic/game_brain_scoreBean.php' );
	require_once( SCRIPT_ROOT . 'logic/game_brain_recordBean.php' );

	define('LOG_PATH',  dirname(dirname(dirname(__FILE__))).'/logs');

	$scoreBean  				= new game_brain_scoreBean();
	$scoreBean->conn 			= $db;
	$recordBean 				= new game_brain_recordBean();
	$recordBean->conn 			= $db;

	if ( $user_info == null )
	{
		redirect( $site_game . '/login.php?' . $_SERVER['QUERY_STRING'] );
	}

	$_SESSION['pass_question']	= array();																// 默认已答过题库信息为空
	$_SESSION['record_id'] 		= 0;																	// 默认对战id为0；
	$_SESSION['sponsor_score']	= 0;																	// 默认分享者分数为0;
	$game_from 					= isset( $_GET['from'] ) ? $_GET['from'] : null;						// 游戏来源
	$sponsor_openid 			= isset( $_GET['cid'] )  ? $_GET['cid'] : null;							// 获取分享者的openid
 	$sponsor_openid 			= mc_decrypt($sponsor_openid, MCKEY);

	/*
	 * 	功能：判断是否为PK赛，识别标识为是否存在openid,如果是则创建record记录，并记录recordid在session中
	 * 	返回：
	 *  0 ： 显示PK的页面
	 *  -1： 显示单机的页面
	 *  -2： 显示当日已对战的页面
	 * */
	if ( ! is_null( $sponsor_openid ) && $sponsor_openid != $user_info->openid )						// 如果存在，则说明入口为分享连接； 且分享者不是自己，则为PK
	{
		$status = 0;

		do
		{
			$scoreBean->openid 	= $sponsor_openid;
			$sponsor_info 		=  $scoreBean->get_user_info();											// 1、获取分享者的信息

			if ( $sponsor_info == null )																// 2、判断分享者是否存在，如果分享者信息不存在，则退出
			{
				$status = -1;
				break;
			}

			if ( $sponsor_info->exchange_code == null )													// 3、判断分享者是否已关注服务号（关注服务号才可以获取兑换码），如果还没关注，则退出
			{
				$status = -1;
				break;
			}

			if( $sponsor_info->score < GAME_SUCCESS_SCROE )												// 4、判断分享者的分值是否达到通关分数，如果没有达到，则退出
			{
				$status = -1;
				break;
			}

			$recordBean->sponsor 	 = $sponsor_openid;													// 获取分享者id
			$recordBean->challenger  = $user_info->openid;												// 获取挑战者id

			$last_game_info 		= $recordBean->get_last_game_info();								// 获取最后一次比赛的时间

			if ( $last_game_info != null && time() - $last_game_info->time <= ALLOW_MATH_GAME_TIME )	// 5、判断两人最近一次比赛的时候，如果未超过，则不允许再次比较，退出
			{
				$status = -2;
				break;
			}

			$record_id = $recordBean->get_no_game_record();												// 6、判断是否存在未开始的场次

			if ( $record_id == null )
			{
				$recordBean->from = $game_from;
				$record_id = $recordBean->creat();														// 7、如果没有，则创建对战记录id
			}
			else
			{
				$record_id = $record_id->id;															//  8、如果存在则保存场次id
			}

			$_SESSION['sponsor_score'] 	= $sponsor_info->score;											//  9、 将分享者分数存入session
			$_SESSION['record_id'] 		= $record_id;													//  10、将对战id存入session
			$_SESSION['sponsor_id']		= $sponsor_openid; 												//  11、分享者id

		}while(0);

		switch ( $status )
		{
			case 0:
				include "./tpl/index.php";
			break;

			case -1:
				include "./tpl/index.php";
			break;

			case -2:
				$result = $last_game_info->result;
				include "./tpl/tip_page.php";
			break;
		}

		exit;
	}
	else																									// 否则入口为直接进入游戏;
	{
		include "./tpl/index.php";
	}



?>
