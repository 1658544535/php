<?php
define('HN1', true);
require_once('../global.php');

$act = CheckDatas('act', '');


$Price 		            = CheckDatas( 'price', '' );
$page                   = max(1, intval($_POST['page']));
$startTime 		        = CheckDatas( 'startTime', '' );
$endTime 		        = CheckDatas( 'endTime', '' );


      $Objincomes = apiData('pdkTranRecListApi.do',array('beginTime'=>$startTime,'endTime'=>$endTime,'pageNo'=>$page,'type'=>1,'userId'=>$userid));
      
      if($Objincomes['result'])
      {
      	echo	ajaxJson( 1,'获取成功',$Objincomes['result'],$page);
      }
      else
      {
      	echo	ajaxJson( 0,'获取失败');
      
      }


?>