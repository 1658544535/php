<?php
	// 获取题目的页面
	define('HN1', true);
	define('SCRIPT_ROOT',  dirname(dirname(dirname(__FILE__))).'/game/lower-brain/');

	require_once ( SCRIPT_ROOT . 'global.php' );
	require_once ( SCRIPT_ROOT . 'logic/game_brain_question_bankBean.php');
	require_once ( SCRIPT_ROOT . 'logic/game_brain_answer_bankBean.php');
	require_once ( SCRIPT_ROOT . 'logic/game_brain_scoreBean.php');
	require_once ( SCRIPT_ROOT . 'logic/game_brain_recordBean.php');
	require_once ( SCRIPT_ROOT . 'logic/game_brain_exchange_codeBean.php');

	if ( $user_info == null )
	{
		redirect( $site_game . '/login.php?' . $_SERVER['QUERY_STRING'] );
	}

	$game_brain_question 		= new game_brain_question_bankBean();
	$game_brain_question->conn 	= $db;
	$game_brain_answer   		= new game_brain_answer_bankBean();
	$scoreBean 			 		= new game_brain_scoreBean();
	$scoreBean->conn 	 		= $db;
	$recordBean 			 	= new game_brain_recordBean();
	$recordBean->conn 	 		= $db;
	$exchange_codeBean 			= new game_brain_exchange_codeBean();
	$exchange_codeBean->conn 	= $db;



	if (  !isset($_SESSION['questiong_num']) )
	{
		$question_num = $game_brain_question->get_question_count($db);
		$_SESSION['questiong_num'] = $question_num;
	}

	$act  = isset($_GET['act']) ? $_GET['act'] : "";


	switch( $act )
	{
		case "check":
			check( $db,$scoreBean,$game_brain_answer,$recordBean,$exchange_codeBean,$user_info, $site_game );
		break;

		default:
//			default_fun( $db,$game_brain_question,$game_brain_answer, $site_game );
			default_fun( $db,$game_brain_question,$game_brain_answer, $scoreBean, $recordBean,$exchange_codeBean,$user_info, $site_game );
	}


	/*
	 * 	功能： 检测问题的方法
	 *  流程：
	 *  1、判断用户输入的答案是否正确
	 *
	 *  2-1、如果错误
	 *  2-1-1、累计错误数并判断是否已经达到错误的上限，
	 *  2-1-1-1、如果没有达到上限，并继续答题(需判断题目是否在本次已被答过)
	 *  2-1-1-2、如果达到上限，则退出游戏(清空错误题数和当前累计的分数值)
	 *  2-1-1-3、判断是否达到通关的分数，如果没有则显示失败的页面，否则显示关注的页面
	 *
	 *  2-2、如果正确
	 *  2-2-1、 累计分数 并继续答题(需判断题目是否在本次已被答过)
	 * */
	function check( $db,$scoreBean,$game_brain_answer,$recordBean,$exchange_codeBean,$user_info, $site_game )
	{
		$_SESSION['begin_game'] = 1;																		// 游戏开始
		$question_id 			= $_GET['qid'];
		$answer_id		 		= $_GET['aid'];
		$result 	 			= $game_brain_answer->get_answer_result($db, $question_id, $answer_id);		// 获取结果 1:正确 0：错误


		if ( $result )																				// 如果正确
		{
			$_SESSION['scoreCount'] += 1;															// 累计分数
		}
		else																						// 如果错误
		{
			$_SESSION['errorCount']  += 1;															// 累计错误的次数

			if ( $_SESSION['errorCount'] >= GAME_ERROR_NUM )										// 如果达到错误的次数,则游戏结束，记录分数
			{
				$isPK  					= ( $_SESSION['record_id'] > 0 ) ? true : false;			// 判断是否为PK赛
				$scoreBean->openid 		= $user_info->openid;
				$scoreBean->uid 		= $user_info->id;
				$scoreBean->score 		= $_SESSION['scoreCount'];
				$scoreBean->is_allow 	= 0;
				$scoreInfo 				= $scoreBean->get_one();									// 获取该用户的分数值


				if ( $scoreInfo == null )															// 如果该用户的分数值为空，则增加
				{
					$scoreBean->creat();
				}
				else
				{
					if ( $scoreBean->score > $scoreInfo->score )									// 如果当前得到的分数比数据表记录高，则更新
					{
						if ( $scoreBean->score >= GAME_SUCCESS_SCROE )
						{
							$scoreBean->is_allow 	= 1;
						}
						$scoreBean->update();
					}
				}

				if( $isPK )																						// 如果为对战游戏
				{
					$result 						= $_SESSION['sponsor_score'] - $_SESSION['scoreCount'];		// ( 分享者分数 - 应战者分数 ) 结果

					if ( $result > 0  )
					{
						$recordBean->result = 1;
						$pageType 			= 'lose';															// 要跳转的页面
						$winOpenid 			= $_SESSION['sponsor_id'];											// 获取获胜者的id
					}
					else if ( $result == 0 )
					{
						$recordBean->result = 0;
						$pageType 			= 'draw';															// 要跳转的页面
					}
					else
					{
						$recordBean->result = -1;
						$pageType 			= 'win';															// 要跳转的页面
						$winOpenid   		= $user_info->openid;												// 获取获胜者的id
					}


					$recordBean->id 				= $_SESSION['record_id'];
					$recordBean->sponsor_scroe		= $_SESSION['sponsor_score'];
					$recordBean->challenger_score	= $_SESSION['scoreCount'];
					$recordBean->challenger			= $user_info->openid;
					$recordBean->exchange_code 		= '';																		// 兑换码默认为空

					if ($recordBean->result != 0 )																				// 如果非平局才生成兑换码
					{
						$exchange_code  			= $exchange_codeBean->get_code();											// 从兑换码库获取兑换码
						$recordBean->exchange_code  = $exchange_code;															// 得到的兑换码（recordBean用）
						$exchange_codeBean->value 	= $exchange_code;															// 需修改的兑换码（exchange_codeBean用）
		 				$exchange_codeBean->openid 	= $winOpenid;																// 获得兑换码的openid
		 				$exchange_codeBean->from 	= 2;																		// 兑换码来源：PK赛
						$exchange_codeBean->set_code_status();																	// 改变该兑换码的状态
					}

					$recordBean->update();																						// 更新相应场次的记录

				}
				else																											// 如果为单机游戏
				{
					$scoreCount = sprintf( '%d', $_SESSION['scoreCount']);
					$pageType = ( $scoreBean->score < GAME_SUCCESS_SCROE ) ? 'failt&score=' . $scoreCount : 'share&score=' . $scoreCount;  // 分数未达到通关值，则显示失败页面，否则显示分享页面
				}

				flush_game_data();			// 清空游戏数据

				redirect( '/game/lower-brain/page.php?&type=' . $pageType );
				return;
			}
		}

		redirect( '/game/lower-brain/problem.php' );																			// 继续答题

	}


	// 默认的显示页面
	function default_fun( $db,$game_brain_question,$game_brain_answer, $scoreBean, $recordBean,$exchange_codeBean,$user_info, $site_game )
	{

		$errorCount   = $_SESSION['errorCount'];
		$scoreCount   = $_SESSION['scoreCount'];

//		if ( $_SESSION['begin_game'] == 1  )																					// 判断是否在答题过程中刷新跳题
//		{
//			$_SESSION['errorCount'] = $errorCount + 1;																			// 如果是，则错误+1
//
//			if ( $_SESSION['errorCount'] >= GAME_ERROR_NUM )																	// 如果达到错误的次数,则游戏结束，记录分数
//			{
//				redirect( '/game/lower-brain/problem.php?act=check' );
//				return;
//			}
//		}


		if ( count($_SESSION['pass_question']) == $_SESSION['questiong_num'] )													// 如果已答题数量与题库数量一致，说明已答完全部题目，游戏结束
		{
			$score = $_SESSION['scoreCount'];
			flush_game_data();			// 清空游戏数据
			redirect( '/game/lower-brain/page.php?score='. $score .'&type=share' );
		}


		$now_question_id = 	get_question_id();																					// 获取题库id
		$problem_info 	 = $game_brain_question->get_question($db, $now_question_id);
		$answer_list  	 = $game_brain_answer->get_answer_list($db, $problem_info->id);
		shuffle($answer_list);																									// 随机出现答案

		include SCRIPT_ROOT . "tpl/problem.php";
	}


		/*
	 * 功能：获取题库ID
	 * */
	function get_question_id( )
	{
//		flush_game_data();
		$now_question_id = 	rand(1,$_SESSION['questiong_num']);																	// 获取题库id
		$pass_question 	 =  $_SESSION['pass_question'];																			// 已答题库值

		if ( in_array( $now_question_id, $pass_question) )																		// 判断获取到的题库id是否在已答的内存中,如果是返回false
		{
			//echo "</br> 重复：". $now_question_id;
			$result = false;
		}
		else																													// 判断获取到的题库id是否在已答的内存中，如果否返回true
		{
			//echo "</br> 新值：". $now_question_id;
			array_push($pass_question, $now_question_id);																		// 将获取到的题库id添加到已答内存中
			$_SESSION['pass_question'] = $pass_question;
			$result = true;
		}

		if ( ! $result )
		{
			$now_question_id = get_question_id( );
		}

		return $now_question_id;
	}


	/*
	 * 清空游戏数据
	 * */
	function flush_game_data()
	{
		$_SESSION['scoreCount'] 		=	null;																		// 得分记录清空
		$_SESSION['errorCount'] 		=	null;																		// 错误记录清空
		$_SESSION['record_id'] 			=	null;																		// 对战记录清空
		$_SESSION['sponsor_score'] 		=	null;																		// 分享者记录清空
		$_SESSION['sponsor_id'] 		=   null;																		// 分享者id清空
		$_SESSION['pass_question'] 		= 	array();																	// 清空已答题库
		$_SESSION['begin_game'] 		= 	null;																		// 游戏结束
	}



?>