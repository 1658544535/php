<?php
define('HN1', true);
require_once('../global.php');
$Type           = CheckDatas( 'type', '' );
$page           = max(1, intval($_POST['page']));
$pId          	= CheckDatas( 'pid', '' );
$aId   	        = CheckDatas( 'aid', '' );
$uId   	        = CheckDatas( 'uid', '' );

//获取用户评论列表数据
$LotteryCommentList = apiData('getDrawCommentDetailsApi.do', array('activityId'=>$aId,'pageNo'=>$page));

if(!empty($LotteryCommentList['result']))
{
	echo	ajaxJson( 1,'获取成功',$LotteryCommentList['result']['userInfo'],$page);
}
else
{
	echo	ajaxJson( 0,'获取失败');
}


?>