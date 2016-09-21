<?php

define('HN1', true);
require_once('./global.php');

require_once( MODEL_INC .'SysLoginlModel.class.php' );


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

				$from = 'statistics';
				$userinfo = $_SESSION['user_info'];
				$get_count = $this->SysLoginModel->getAll(  array( 'reg_channel' => $userinfo->Name ) );

//		 		$sql = "SELECT DATE_FORMAT( `create_date`, '%d' ) AS day, `reg_channel` FROM `sys_login` WHERE `reg_channel`!='' AND DATE_FORMAT( `create_date`, '%Y%m' ) = DATE_FORMAT( CURDATE( ) , '%Y%m' )";
		 		$sql = "SELECT DATE_FORMAT( `create_date`, '%d' ) AS day FROM `sys_login` WHERE DATE_FORMAT( `create_date`, '%Y%m' ) = DATE_FORMAT( CURDATE( ) , '%Y%m' )";
				$arrData = $this->SysLoginModel->query($sql);


var_dump($arrData);
exit;

				for( $i=1; $i<=date('t',time()); $i++ )
				{
					$rs['day'][$i-1] = $i . "号";
					$rs['count'][$i-1] = 0;
					$rs['count3'][$i-1] = 0;
					$rs['count4'][$i-1] = 0;
					$rs['count5'][$i-1] = 0;
				}

				foreach( $arrData as $data )
				{
					$sql = "SELECT DATE_FORMAT( `create_date`, '%d' ) AS day, `reg_channel` FROM `sys_login` WHERE  AND DATE_FORMAT( `create_date`, '%Y%m' ) = DATE_FORMAT( CURDATE( ) , '%Y%m' )";
					$arrData = $this->SysLoginModel->query($sql);

					$key = (int)$data->day -1;
					$count = $rs['count'][$key];
					$rs['count'][$key] = $count +1 ;

					preg_match_all('#[a-zA-z ]+#',$data->reg_channel,$output);

					switch ( $output[0][0] )
					{
						case 'TaoZhuMa':
							$count = $rs['count3'][$key];
							$rs['count3'][$key] = $count +1 ;
						break;

						case 'umeng_channel':
							$count = $rs['count4'][$key];
							$rs['count4'][$key] = $count +1 ;
						break;
					}
				}

				foreach( $rs['count'] as $key=>$data )
				{
					$rs['count5'][$key] = $rs['count'][$key] - $rs['count3'][$key] - $rs['count4'][$key];
				}

				$day  = json_encode( $rs['day'] );
				$num  = json_encode( $rs['count'] );
				$num3 = json_encode( $rs['count3'] );
				$num4 = json_encode( $rs['count4'] );
				$num5 = json_encode( $rs['count5'] );

				include_once "tpl/header.php";
				include_once "tpl/statistics_list.php";
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

