<?php
define('HN1', true);
require_once('../global.php');
$page = max(1, intval($_POST['page']));

$Type  = CheckDatas( 'type', '' );

$userLottery = apiData('getDrawApi.do', array('pageNo'=>$page,'userId'=>$userid,'type'=>$Type));
if($userLottery['exception'])
{
	echo ajaxJson( 0,'获取失败');
}
else
{
    echo ajaxJson( 1,'获取成功',$userLottery['result'],$page);
}
?>