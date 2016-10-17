<?php
define('HN1', true);
require_once('../global.php');

$act = CheckDatas('act', '');
$Name 		            = CheckDatas( 'name', '' );
$Phone		            = CheckDatas( 'phone', '' );
$cardNo 		        = CheckDatas( 'cardNo', '' );
$Number 		        = CheckDatas( 'number', '' );
$Content 		        = CheckDatas( 'content', '' );
$Type 		            = CheckDatas( 'type', '' );
$Price 		            = CheckDatas( 'price', '' );
$page                   = max(1, intval($_POST['page']));
$startTime 		        = CheckDatas( 'startTime', '' );
$endTime 		        = CheckDatas( 'endTime', '' );




switch($act)
{
	case 'incomes':
      $Objincomes = apiData('pdkTranRecListApi.do',array('beginTime'=>$startTime,'endTime'=>$endTime,'pageNo'=>$page,'type'=>1,'userId'=>$userid));
      
      if($Objincomes !='')
      {
      	echo	ajaxJson( 1,'获取成功',$Objincomes['result']['tranList'],$page);
      }
      else
      {
      	echo	ajaxJson( 0,'获取失败');
      
      }
    break;
}

?>