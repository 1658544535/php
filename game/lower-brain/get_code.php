<?php
	// 获取兑换码操作

	define('HN1', true);
	define('SCRIPT_ROOT',  dirname(dirname(dirname(__FILE__))).'/game/lower-brain/');

	require_once( SCRIPT_ROOT . 'global.php' );
	require_once ( SCRIPT_ROOT . 'logic/game_brain_scoreBean.php');
	require_once ( SCRIPT_ROOT . 'logic/game_brain_exchange_codeBean.php');
	require_once ( SCRIPT_ROOT . 'logic/game_brain_userBean.php');


	$scoreBean 					= new game_brain_scoreBean();
	$scoreBean->conn 			= $db;

	$exchange_codeBean 			= new game_brain_exchange_codeBean();
	$exchange_codeBean->conn 	= $db;

	$userBean 					= new game_brain_userBean();
	$userBean->conn 			= $db;


	if ( $user_info == null )
	{
		redirect( $site_game . '/login.php?' . $_SERVER['QUERY_STRING'] );
	}


	$act = isset( $_GET['type'] ) ? $_GET['type'] : null;


	/*
	 * 	兑换提示信息
	 * */
	$tempTip = array(
		'1'  => "恭喜您！获得一个兑换码：%s，感谢您的关注与参与！",
		'-1' => "很遗憾，您还未能领取兑换码，请继续修炼！",
		'-2' => "您已经领取过兑换码，您的兑换码为：%s，感谢您的关注与参与！"
	);


	/*
	 * 	功能：用户关注微信后获取兑换码
	 *
	 * 	流程：
	 *  1、判断是否允许获取兑换码
	 *  2、判断是否该用户已兑换过
	 *  3、去兑换码库中获取兑换码
	 *  4、修改相应兑换码的状态
	 *  5、填写user_score.exchange_code的值
	 *  6、修改用户的关注状态(user表中的is_attention = 1)
	 *
	 *  返回：
	 *  1 ： 获取兑换码
	 *  -1： 该用户不允许申请兑换码
	 *  -2: 该用户已兑换
	 * */

	do
	{
		$status = 1;												// 返回状态

		$scoreBean->openid 	= $user_info->openid;
		$user_game_info 	= $scoreBean->get_one();				// 获取用户游戏记录
		$is_allow 			= $user_game_info->is_allow;			// 是否允许兑换
		$user_score 		= $user_game_info->score; 				// 游戏分数
		$get_exchange_code 	= $user_game_info->exchange_code;		// 获取兑换码


		// 1、如果不允许兑换，则退出
		if ( $is_allow == 0 )
		{
			$status = -1;
			$strTip = $tempTip[$status];
			break;
		}

		// 2、如果已经兑换，则退出
		if ( $get_exchange_code != null )
		{
			$status = -2;
			$strTip = sprintf($tempTip[$status], $get_exchange_code);
			break;
		}

		// 3、设置随机获取二维码
		$set_exchange_code = $exchange_codeBean->get_code();

		// 4、修改相应兑换码的状态
		$exchange_codeBean->value 	= $set_exchange_code;
		$exchange_codeBean->openid 	= $user_info->openid;
		$exchange_codeBean->from 	= 1;
		$exchange_codeBean->set_code_status();

		// 5、填写user_score.exchange_code的值
		$scoreBean->openid 			= $user_info->openid;
		$scoreBean->exchange_code 	= $set_exchange_code;
		$scoreBean->set_exchange_code();

		// 6、修改用户的关注状态
		$userBean->openid 			= $user_info->openid;
		$userBean->set_attention();


		$strTip = sprintf($tempTip[$status], $set_exchange_code);
	}
	while(0);

	echo $strTip;


?>