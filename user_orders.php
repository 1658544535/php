<?php
define('HN1', true);
require_once('./global.php');

IS_USER_LOGIN();

$act  = CheckDatas( 'act', 'info' );
$productId   	= CheckDatas( 'pid', '' );
$gId   	        = CheckDatas( 'gid', '' );
$page           = max(1, intval($_POST['page']));
$OrderType      = CheckDatas( 'type', '' );
$OrderId        = CheckDatas( 'oid', '' );
$OrderStatus    = CheckDatas( 'status', '' );


switch($act)
{
	case 'cancel':
		//取消订单

		$ObjOrderCancel    = apiData('cancelOrder.do', array('oid'=>$OrderId));

		if($ObjOrderCancel !=null)
		{
			echo	ajaxJson('1','取消成功',$ObjOrderCancel);
		}
		else
		{
			echo    ajaxJson('0','取消失败');
		}
		break;


	case 'edit':
		//确认订单
		$ObjOrderEdit    = apiData('editOrderStatus.do', array('oid'=>$OrderId,'status'=>$OrderStatus,'uid'=>$userid));

		if($ObjOrderEdit !=null)
		{
			echo	ajaxJson('1','确认收货成功',$ObjOrderEdit);
		}
		else
		{
			echo    ajaxJson('0','确认收货失败');
		}
		break;

}




include "tpl/user_orders_web.php";




















































?>