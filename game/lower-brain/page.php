<?php
	define('HN1', true);
	define('SCRIPT_ROOT',  dirname(dirname(dirname(__FILE__))).'/game/lower-brain/');

	require_once( SCRIPT_ROOT . 'global.php' );
	require_once ( SCRIPT_ROOT . 'logic/game_brain_scoreBean.php');
	require_once ( SCRIPT_ROOT . 'logic/game_brain_recordBean.php');
	require_once ( SCRIPT_ROOT . 'logic/game_brain_exchange_codeBean.php');

	$scoreBean 	 = new game_brain_scoreBean();
	$scoreBean->conn 			= $db;

	$recordBean 			 	= new game_brain_recordBean();
	$recordBean->conn 	 		= $db;

	$exchange_codeBean 			= new game_brain_exchange_codeBean();
	$exchange_codeBean->conn 	= $db;


	if ( $user_info == null )
	{
		redirect( $site_game . '/login.php?' . $_SERVER['QUERY_STRING'] );
	}


	$act = $_GET['type'];

	switch( $act )
	{
		case "failt":			// 单机游戏结束（没有达到通关的页面）
			include "./tpl/failt_page.php";
		break;

		case "share":			// 单机游戏结束（达到通关的页面）
			$scoreBean->openid 	= $user_info->openid;
			$user_game_info 	= $scoreBean->get_user_info();
			include "./tpl/share_page.php";
		break;

		case "rank":			// 排行榜
			$arrRankList = $scoreBean->get_rank_list();				// 获取前20名的分数
			$scoreBean->openid = $user_info->openid;
			$getMyRank 	 = $scoreBean->get_my_rank();				// 你当前排名的信息
			include "./tpl/rank_page.php";
		break;

		case "rule":			// 说明
			include "./tpl/rule_page.php";
		break;

		case "share_info":		// 分享游戏界面
			include "./tpl/share_info_page.php";
		break;

		case "win":				// PK游戏结束（成功页面）
			include "./tpl/win_page.php";
		break;

		case "lose":			// PK结束（失败页面）
			include "./tpl/lose_page.php";
		break;

		case "draw":				// PK游戏结束（打平页面）
			include "./tpl/draw_page.php";
		break;

		case "battle_index":	// 战绩首页
			$recordBean->sponsor = $user_info->openid;
		 	$recordBean->challenger = $user_info->openid;
			$BattleResult = $recordBean->get_battle_result();		// 获取战绩结果

			$recordBean->sponsor = $user_info->openid;
		 	$recordBean->challenger = $user_info->openid;
			$BattleList   = $recordBean->get_battle_list();		// 获取战绩结果
			include "./tpl/battle_index_page.php";
		break;

//		case "battle_list":		// 战绩列表
//		 	$recordBean->sponsor = $user_info->openid;
//		 	$recordBean->challenger = $user_info->openid;
//			$BattleResult = $recordBean->get_battle_list();		// 获取战绩结果
//	 		var_dump($arrExchangeCodeList);
//
//			include "./tpl/battle_list_page.php";
//		break;

		case "exchange_code":	// 兑换码列表
			$exchange_codeBean->openid = $user_info->openid;
			$exchange_codeBean->openid = "o6MuHtzGVyS8xi5VxCs3RjhEhQfk";
	 		$arrExchangeCodeList = $exchange_codeBean->get_my_exchange_code();
	 		include "./tpl/exchange_code_list_page.php";
		break;
	}

?>