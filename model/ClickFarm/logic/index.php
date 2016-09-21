<?php

define('HN1', true);
require_once('../global.php');

require_once( LOGIC_ROOT . 'ProductBean.php');
require_once( LOGIC_ROOT . 'SysLoginBean.php');
require_once( LOGIC_ROOT . 'UserOrderBean.php');
require_once( LOGIC_ROOT . 'UserOrderDetailBean.php');

$market_admin = isset( $_SESSION['marketAdmin'] ) ? $_SESSION['marketAdmin'] : '';
$act 		  = isset( $_REQUEST['act'] ) 	? $_REQUEST['act'] : '';

if( $market_admin != null )								// 如果用户已登录
{
	$market_id 		 = $market_admin['id'];
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
	 * 刷单操作！！
	 * */
	case "add":
		echo 'wating....';

		// 获取配置信息
		$strData = file_get_contents('config.ini');
		$arrData = json_decode( $strData, true );

		// 获取待刷商品
		$arrProductList = getProductList($db,$arrData);
		foreach( $arrProductList as $arrProduct )
		{
			$product[] = $arrProduct->id;
		}

		// 获取待刷用户
		$arrUserList	= getUserList($db,$arrData);
		foreach( $arrUserList as $arrUser )
		{
			$user[] = $arrUser->id;
		}

		//shuffle($user);			// 打乱用户顺序
		//shuffle($product);		// 打乱商品顺序


		$UserOrderBean 	= new UserOrderBean( $db,  'user_order' );
		$num   = rand( 1, $arrData['count'] );
		$p_key = rand( 0, count($product) -1 );
		$u_key = rand( 0, count($user) -1 );

		$rs  = $UserOrderBean->getInfo( $user[$u_key], $product[$p_key], $num );

		$msg = $rs === FALSE ? '添加失败！' : '添加成功！';
		Log::DEBUG( "user_id:{$user[$u_key]} -- product_id:{$product[$p_key]} -- num:{$num} -- msg:{$msg} ");

// 		批量添加
//		$UserOrderBean 	= new UserOrderBean( $db,  'user_order' );
//		for( $i=0; $i<count($user); $i++ )
//		{
//			$num   = rand( 1, $arrData['count'] );
//			$p_key = rand( 0, count($product) -1 );
//
//			$rs  = $UserOrderBean->getInfo( $user[$i], $product[$p_key], $num );
//			$msg = $rs === FALSE ? '添加失败！' : '添加成功！';
//			Log::DEBUG( "user_id:{$user[$i]} -- product_id:{$product[$p_key]} -- num:{$num} -- msg:{$msg} ");
//		}

		redirect( $site . 'admin/order.php?act=list','刷单结束！' );
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
function getProductList($db,$arrData)
{
	$ProductBean 	= new ProductBean( $db,  'product' );
	return $ProductBean->get_list(array('user_id'=>220),array('id', 'product_name', 'distribution_price', 'image','location'), 'sell_number ASC', array($arrData['product_num']));
}

// 获取待刷用户
function getUserList($db,$arrData)
{
	$SysLoginBean 	= new SysLoginBean( $db, 'sys_login' );
	$arrWhere = array(
		'id' => array( '>='=>$arrData['start_id'], '<='=>$arrData['end_id'] ),
		'create_by' => -1
	);
	return $SysLoginBean->get_list( $arrWhere, array('id','loginname','name'), '', array($arrData['user_num']) );
}




?>

