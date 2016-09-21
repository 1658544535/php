<?php

define('HN1', true);
require_once('./global.php');


require_once( MODEL_INC .'SysLoginlModel.class.php' );

if( !isset($_SESSION['user_info']) || $_SESSION['user_info'] == null )
{
	redirect( $WEB_SIZE . 'login.php', '请登录');
	return;
}

class Index
{
	private $UmengChannelModel;
	private $nowModel;

	public function __construct( $db,$WEB_SIZE )
	{
		$this->SysLoginModel = new SysLoginlModel($db);
		$this->nowModel = $WEB_SIZE;
	}

	/*
	 * 功能：页面显示
	 * */
	public function show( $type )
	{
		switch( $type )
		{
			case 'list':
				$userinfo = $_SESSION['user_info'];
				$get_count = $this->SysLoginModel->getAll(  array( 'reg_channel' => $userinfo->Name ) );
		 		$sql = "SELECT DATE_FORMAT( `create_date`, '%d' ) AS day FROM `sys_login` WHERE `reg_channel`= '{$userinfo->Name}' AND DATE_FORMAT( `create_date`, '%Y%m' ) = DATE_FORMAT( CURDATE( ) , '%Y%m' )";
				$arrData = $this->SysLoginModel->query($sql);

				for( $i=1; $i<=date('t',time()); $i++ )
				{
					$rs['day'][$i-1] = $i . "号";
					$rs['count'][$i-1] = 0;
				}

				foreach( $arrData as $data )
				{
					$key = (int)$data->day -1;
					$count = $rs['count'][$key];
					$rs['count'][$key] = $count +1 ;
				}

				$day = json_encode( $rs['day'] );
				$num = json_encode( $rs['count'] );


				include_once "tpl/header.php";
				include_once "tpl/index_list.php";
			break;

			default:
				$userinfo = $_SESSION['user_info'];
				$get_count = $this->SysLoginModel->getCount(  array( 'reg_channel' => $userinfo->Name ) );
				include_once "tpl/header.php";
				include_once "tpl/index.php";
		}
	}


}



$act 	= !isset($_REQUEST['act']) 	? "list" : $_REQUEST['act'];
$Index  = new Index($db,$WEB_SIZE);
$Index->show( $act );




?>

