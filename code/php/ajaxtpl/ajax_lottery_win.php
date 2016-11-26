<?php
define('HN1', true);
require_once('../global.php');
$attId 	        = CheckDatas( 'attId', '' );
$aId 	        = CheckDatas( 'aid', '' );
$Type 	        = CheckDatas( 'type', '' );
$page           = max(1, intval($_POST['page']));



//获取中奖用户列表数据
$winList = apiData('prizeDetail.do', array('attendId'=>$attId,'activityId'=>$aId,'pageNo'=>$page,'activityType'=>$Type));
// if(!empty($winList['result']['prizelist']))
// {
	echo	ajaxJson( 1,'获取成功',$winList['result']['prizelist'],$page);
// }
// else
// {
// 	echo	ajaxJson( 0,'获取失败');
// }






?>