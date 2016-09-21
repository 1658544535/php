<?php

define('HN1', true);
require_once('../global.php');

require_once( LOGIC_ROOT . 'ProductBean.php');
require_once( LOGIC_ROOT . 'SysLoginBean.php');
require_once( LOGIC_ROOT . 'UserOrderBean.php');
require_once( LOGIC_ROOT . 'UserOrderDetailBean.php');

$market_admin = isset( $_SESSION['marketAdmin'] ) ? $_SESSION['marketAdmin'] : '';
$act 		  = isset( $_REQUEST['act'] ) 	? $_REQUEST['act'] : '';

if( $market_admin != null || $act == 'add' )			// 如果用户已登录
{
	$market_type 	 = $market_admin['type'];
	$market_name 	 = $market_admin['name'];
}
else													// 否则跳转到登录页面
{
	redirect("login.php");
	return;
}

switch( $act )
{

	/**
	 * 手动刷单操作！！
	 * */
	case "add":
		echo 'begin....';

		$refresh = rand(1,90);
		echo '<meta http-equiv="refresh" content="'.$refresh.'">';
		$rs = ClickFarm();			// 手动刷单

		//redirect( $site . 'admin/order.php?act=list','刷单结束！' );
	break;

	/**
	 * 自动刷单操作！！
	 * */
	case "auto":

		// 获取刷单时间
		$time = ! isset( $_REQUEST['time'] ) || $_REQUEST['time'] == '' ?  '' : $_REQUEST['time'];

		// 检测刷单时间格式有效性
		$rs = preg_match( '#\d{4}-\d{1,2}-\d{1,2}#', $time );
		if ( $rs === 0 )
		{
			echo 'error:time format errro';
		}

		echo 'begin....</br>';

		$nNum	= rand( 3000,3500 );
//		$nNum	= rand( 2,5 );

		for ( $i=1; $i<=$nNum; $i++ )
		{
			$nHour  = rand( 8,22 );
			$nMin   = rand( 0,59 );
			$nSec   = rand( 0,59 );
			$arrAutoData['date']   =  $time . ' ' . sprintf('%02d',$nHour) . ':' . sprintf('%02d',$nMin) . ':' . sprintf('%02d',$nSec);
			ClickFarm( TRUE, $arrAutoData );
		}

		echo 'end....</br>';
	break;

	default:
		// 获取配置信息
		$strData = file_get_contents('config.ini');
		$arrData = json_decode( $strData, true );

		// 获取待刷商品
		$arrProductList = getProductList($db,$arrData);

		// 获取待刷用户
		$arrUserList	= getUserList($db,$arrData);

		require_once('tpl/header.php');
		require_once('tpl/index.php');
}




// 获取待刷商品
function getProductList( $db, $arrData, $price='' )
{
	$ProductBean 	= new ProductBean( $db,  'product' );
	$rs = $ProductBean->getProductList( $arrData['product_num'], $price );
	return $rs;
}

// 获取待刷用户
function getUserList($db,$arrData)
{
	$SysLoginBean 	= new SysLoginBean( $db, 'sys_login' );
	$arrWhere = array(
		'id' => array( '>='=>$arrData['start_id'], '<='=>$arrData['end_id'] ),
		'create_by' => -1
	);
	//return $SysLoginBean->get_list( $arrWhere, array('id','loginname','name'), '', array($arrData['user_num']) );
	return $SysLoginBean->get_list( $arrWhere, array('id','loginname','name'), '', '' );
}


// 刷单操作
function ClickFarm( $fAuto = FALSE, $arrAutoData = '' )
{
	global $db;

	//8点-9点、12点-13点，三次随机过滤一次
	$curHour = date('G', time());
	if(in_array($curHour, array(8, 12))){
		$_rand = rand(1,3);
		if($_rand == 1) return;
	}

	// 判断订单数是否超出限制
	$UserOrderBean 	= new UserOrderBean( $db,  'user_order' );
	$nTodayOrderNum = $UserOrderBean->getTodayOrderNum();

	if ( $nTodayOrderNum > getTodayClickFarmNum() )
	{
		Log::DEBUG( "msg:添加失败,原因：已超过限制的刷单数量 ");
		return;
	}

	// 获取配置信息
	$strData = file_get_contents('config.ini');
	$arrData = json_decode( $strData, true );
	$MaxPrice = rand( 1, 10 ) >=8 ? 100 : 40;
//	$MaxPrice = rand( 1, 10 ) >=8 ? 100 : 100;

	// 获取待刷用户
	$arrUserList	= getUserList($db,$arrData);

	if($arrUserList == NULL)
	{
		return FALSE;
	}

	foreach( $arrUserList as $arrUser )
	{
		$user[] = $arrUser->id;
	}

	// 获取待刷商品
	$arrProductList = getProductList($db,$arrData, $MaxPrice);
	if ( $arrProductList == NULL )
	{
		return FALSE;
	}

	foreach( $arrProductList as $arrProduct )
	{
		$product[] = $arrProduct->id;
	}

	$UserOrderBean 	= new UserOrderBean( $db,  'user_order' );
	$num   = rand( 1, $arrData['count'] );
	$p_key = rand( 0, count($product) -1 );
	$u_key = rand( 0, count($user) -1 );

	$rs  = $UserOrderBean->getInfo( $user[$u_key], $product[$p_key], $num, $fAuto, $arrAutoData );

	$msg = $rs === FALSE ? '添加失败！' : '添加成功！';
	Log::DEBUG( "user_id:{$user[$u_key]} -- product_id:{$product[$p_key]} -- num:{$num} -- msg:{$msg} ");
}


/**
 *	获取今天规定的总刷单数
 */
function getTodayClickFarmNum()
{
	$fileDate = strtotime(date('Y-m-d',filemtime('count.txt')));
	$toDay    = strtotime(date('Y-m-d'));

	if ( $fileDate != $toDay )
	{
		$nCount = rand( 2800, 3500 );
		file_put_contents('count.txt', $nCount);
	}
	else
	{
		$nCount = $strData = file_get_contents('count.txt');
	}

	return $nCount;
}


?>

