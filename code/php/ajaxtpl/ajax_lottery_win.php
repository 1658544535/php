<?php
define('HN1', true);
require_once('../global.php');

$aId 	        = CheckDatas( 'aid', '' );
$page           = max(1, intval($_POST['page']));



//获取中奖用户列表数据
$winList = apiData('prizeDetail.do', array('activityId'=>$aId,'pageNo'=>$page));
if(!empty($winList['result']['prizelist']))
{
	echo	ajaxJson( 1,'获取成功',$winList['result']['prizelist'],$page);
}
else
{
	echo	ajaxJson( 0,'获取失败');
}






?>