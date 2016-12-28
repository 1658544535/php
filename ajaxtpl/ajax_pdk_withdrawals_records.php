<?php
define('HN1', true);
require_once('../global.php');

$act = CheckDatas('act', '');
$Type 		            = CheckDatas( 'type', '' );
$Price 		            = CheckDatas( 'price', '' );
$page                   = max(1, intval($_POST['page']));
$startTime 		        = CheckDatas( 'startTime', '' );
$endTime 		        = CheckDatas( 'endTime', '' );
$status 		        = CheckDatas( 'status', '' );



		$Objrecord = apiData('pdkTranRecListApi.do',array('beginTime'=>$startTime,'endTime'=>$endTime,'pageNo'=>$page,'type'=>2,'status'=>$status,'userId'=>$userid),'post');

		if($Objrecord['result'] !='')
		{
			echo	ajaxJson( 1,'获取成功',$Objrecord['result'],$page);
		}
		else
		{
			echo	ajaxJson( 0,'获取失败');

		}
		
















?>