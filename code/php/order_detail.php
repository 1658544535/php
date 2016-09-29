<?php
define('HN1', true);
require_once('./global.php');



$Oid            = CheckDatas( 'oid', '' );

$OrderDetail = apiData('orderdetail.do', array('oid'=>$Oid));






include_once('tpl/order_detail_web.php');
?>