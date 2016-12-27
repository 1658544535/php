<?php
define('HN1', true);
require_once('../global.php');

$page  = max(1, intval($_POST['page']));


//获取任务清单数据
$missionList = apiData('userGroupTaskApi.do',array('userId'=>$userid,'pageNo'=>$page));
if($missionList['success']){
	echo ajaxJson( 1,'获取成功',$missionList['result'],$page);
}else{
	echo ajaxJson( 0,$missionList['error_msg']);
}

?>