<?php
define('HN1', true);
require_once('../global.php');

$act  = CheckDatas( 'act', 'info' );
$productId   	= CheckDatas( 'pid', '' );
$gId   	        = CheckDatas( 'gid', '' );
$page           = max(1, intval($_POST['page']));
$OrderType      = CheckDatas( 'type', '' );
$OrderId        = CheckDatas( 'oid', '' );
$OrderStatus    = CheckDatas( 'status', '' );


//获取个人订单列表数据
$orders = apiData('myorder.do', array('orderStatus'=>$OrderType,'pageNo'=>$page,'uid'=>$userid));


if($orders['result'] !='')
{
	echo	ajaxJson( 1,'获取成功',$orders['result'],$page);
}
else
{
	echo	ajaxJson( 0,'获取失败');
}




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