<?php
define('HN1', true);
require_once('../global.php');

$page  = max(1, intval($_POST['page']));
$source  = CheckDatas( 'source', '' );
$name    = CheckDatas( 'name', '' );
$type1   = CheckDatas( 'type1', '' );
$type2   = CheckDatas( 'type2', '' );
$type3   = CheckDatas( 'type3', '' );

//获取任务清单数据 && 搜索数据
$missionList = apiData('userGroupTaskApi.do',array('userId'=>$userid,'source'=>$source,'name'=>$name,'type1'=>$type1,'type2'=>$type2,'type3'=>$type3,'pageNo'=>$page));
if($missionList['success'])
{
	echo ajaxJson( 1,'获取成功',$missionList['result'],$page);
}
else
{
	echo ajaxJson( 0,$missionList['error_msg']);
}

?>