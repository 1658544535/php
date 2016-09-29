<?php
define('HN1', true);
require_once('../global.php');

$act  = CheckDatas( 'act', 'info' );
$productId   	= CheckDatas( 'pid', '' );
$gId   	        = CheckDatas( 'gid', '' );
$page           = max(1, intval($_POST['page']));
$OrderStatus    = CheckDatas( 'type', '' );
$OrderId        = CheckDatas( 'oid', '' );



//获取个人订单列表数据
$orders = apiData('myorder.do', array('orderStatus'=>$OrderStatus,'pageNo'=>$page,'uid'=>$userid));


if($orders['result'] !='')
{
	echo	ajaxJson( 1,'获取成功',$orders['result'],$page);
}
else
{
	echo	ajaxJson( 0,'获取失败');
}






include "tpl/user_orders_web.php";
?>