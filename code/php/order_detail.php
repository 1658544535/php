<?php
define('HN1', true);
require_once('./global.php');


$act  = CheckDatas( 'act', 'info' );
$productId   	= CheckDatas( 'pid', '' );
$gId   	        = CheckDatas( 'gid', '' );
$page           = max(1, intval($_POST['page']));
$OrderStatus    = CheckDatas( 'type', '' );
$Oid            = CheckDatas( 'oid', '' );

$OrderDetail = apiData('orderdetail.do', array('oid'=>$Oid));

switch($act)
{
	case 'cancel':
		//取消订单
		$ObjOrderCancel    = apiData('cancelOrder.do', array('oid'=>$Oid));

		if($ObjOrderCancel !=null)
		{
			echo	ajaxJson('','',$ObjOrderCancel);
		}
		else
		{
			echo    ajaxJson('0','取消失败');
		}
		break;


	case 'edit':
		//确认订单
		$ObjOrderEdit    = apiData('editOrderStatus.do', array('oid'=>$Oid,'status'=>$OrderStatus,'uid'=>$userid));

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
//include_once('order_detail_judgeStatus.php'); //订单状态判断
include_once('tpl/order_detail_web.php');
?>