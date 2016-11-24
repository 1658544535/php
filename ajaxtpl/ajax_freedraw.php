<?php
define('HN1', true);
require_once('../global.php');
$Type = CheckDatas( 'type', '' );
$page = max(1, intval($_POST['page']));

//获取活动列表数据
$FreedrawList = apiData('freeDrawListApi.do', array('type'=>$Type,'pageNo'=>$page));

if(!empty($FreedrawList['result']))
{
	echo ajaxJson( 1,'获取成功',$FreedrawList['result'],$page);
}
else
{
	echo ajaxJson( 0,'获取失败');
}


?>