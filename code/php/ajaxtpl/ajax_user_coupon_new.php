<?php
define('HN1', true);
require_once('../global.php');


$page = max(1, intval($_POST['page']));
$Type = CheckDatas( 'type', '' );

$coupon = apiData('getUserCouponList.do', array('type'=>$Type,'uid'=>$userid,'pageNo'=>$page));



if($coupon !='')
{
	echo	ajaxJson( 1,'获取成功',$coupon['result']['couponList'],$page);
}
else
{
	echo	ajaxJson( 0,'获取失败');
}





























?>