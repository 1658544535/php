<?php

define('HN1', true);
require_once('./global.php');
require_once( MODEL_INC .'UmengChannelModel.class.php' );

$act 		= !isset($_REQUEST['act']) 	? "list" : $_REQUEST['act'];

if( isset($_SESSION['user_info']) && $_SESSION['user_info'] != null && $act != 'logout' )					// 如果用户已登录
{
	redirect( $WEB_SIZE, '您已登录！无需重复登录');
	return;
}


class Login
{
	private $UmengChannelModel;
	private $nowModel;

	public function __construct( $db,$WEB_SIZE )
	{
		$this->UmengChannelModel = new UmengChannelModel($db);
		$this->nowModel = $WEB_SIZE;
	}

	/*
	 * 功能：页面显示
	 * */
	public function show( $type )
	{
		switch( $type )
		{
			default:
				include_once "tpl/login.php";
		}
	}


	function logout()
	{
		$_SESSION['user_info'] = null;
		redirect( $this->nowModel . "login.php",'退出成功！');
	}

	function check()
	{
		$username	= isset($_POST['username']) ? sqlUpdateFilter($_POST['username']) 	: '';
		$pwd 		= isset($_POST['pwd']) 		? $_POST['pwd'] 					 	: '';

		$arrWhere = array(
			'Email'		=> $username,
			'Password'	=> $pwd
		);

		$rs = $this->UmengChannelModel->get( $arrWhere );

		if ( $rs == null )
		{
			redirect( $this->nowModel . "login.php",'您输入的帐号和（或）密码有误！');
		}
		else
		{
			$_SESSION['user_info'] = $rs;
			redirect( $this->nowModel . "index.php",'登录成功！');
		}

	}



}




$login  = new login($db,$WEB_SIZE);

if ( $act == 'post' )
{
	$login->check();
}
elseif ( $act == 'logout' )
{
	$login->logout();
}
else
{
	$login->show( $act );
}



?>

