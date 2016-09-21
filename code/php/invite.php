<?php

define('HN1', true);
require_once('./global.php');


/*----------------------------------------------------------------------------------------------------
	-- 判断登录
-----------------------------------------------------------------------------------------------------*/
if ( ! $bLogin )
{
	IS_USER_LOGIN();
}

/*----------------------------------------------------------------------------------------------------
	-- 配置
-----------------------------------------------------------------------------------------------------*/
$act 			= CheckDatas( 'act', '' );


switch( $act )
{

	/*----------------------------------------------------------------------------------------------------
		-- 显示页面
	-----------------------------------------------------------------------------------------------------*/
	case 'add':
		include "tpl/invite_code_web.php";
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 绑定推荐人
		流程：
		1、判断用户是否已经被邀请
		2、判断推荐码是否存在
		3、更新绑定者ID
		4、获取今日的邀请倍率，并计算今天邀请可得的金额
		5、更新用户钱包数据
		6、添加记录
		7、重新获取用户信息并更新session
	-----------------------------------------------------------------------------------------------------*/
	case 'add_save':
		$invite_code 			= CheckDatas( 'code', '' );
		$SysLoginModel			= M('sys_login');
		$SysDictModel			= M('sys_dict');
		$UserWalletModel		= D('UserWallet');

		if ( $invite_code == '' )
		{
			echo get_json_data_public( -1, '您的推荐码为空！' );
			return;
		}

		// 1、通过推荐码获取推荐者的id
		if ( $user->invitation_code != null )
		{
			echo get_json_data_public( -1, '您已绑定用户，请不要重复操作！' );
			return;
		}

		// 2、通过推荐码获取推荐者的id
		$SysLoginInfo = $SysLoginModel->get( array('invitation_code'=>$invite_code),'id');

		if ( $SysLoginInfo == NULL )
		{
			echo get_json_data_public( -1, '您输入的推荐码不存在！' );
			return;
		}

		// 3、更新绑定者ID
		$rs = $SysLoginModel->modify( array('inviter_id'=>$SysLoginInfo->id, 'update_date'=>date('Y-m-d H:i:s')), array('id'=>$userid) );

		if ( $rs < 1 )
		{
			echo get_json_data_public( -1, '信息处理有误，请重试！' );
			return;
		}

		//4、获取今日的邀请倍率，并计算今天邀请可得的金额
		$objSysDictInfo = $SysDictModel->get( array('type'=>'share_ratio'), 'value' );
		$fAmount		= $objSysDictInfo->value * 3;

		// 5、更新用户钱包数据,并添加日志记录
		$arrParam = array(
			'user_id'	=> $SysLoginInfo->id,
			'type'		=> 0,
    	 	'trade_amt'	=> $fAmount,
    	 	'source'	=> $userid,
     		'remarks'	=> '领取了你分享的邀请码'
		);
		$UserWalletModel->WalletBuilder($arrParam);
		$UserWalletModel->changeUserWallet();


		// 7、重新获取用户信息，更新session
		$rs = $SysLoginModel->get(array('id'=>$userid));
		$_SESSION['userinfo'] = $rs;
		echo get_json_data_public( 1, '推荐操作成功！', $rs );
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 显示页面
	-----------------------------------------------------------------------------------------------------*/
	default:
		$SysDictModel			= M('sys_dict');
		$UserWalletModel		= D('UserWallet');

		//获取今日的邀请倍率，并计算今天邀请可得的金额
		$objSysDictInfo = $SysDictModel->get( array('type'=>'share_ratio'), 'value' );
		$fMultiple		= $objSysDictInfo->value;
		$fAmount		= $objSysDictInfo->value * 3;

		// 获取邀请的列表
		$objInviterList = $UserWalletModel->getUserInviterList();

		include "tpl/invite_friend_web.php";
}

?>
