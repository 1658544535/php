<?php
define('HN1', true);
require_once('./global.php');



//判断是否登录
IS_USER_LOGIN();

$backUrl = getPrevUrl();

$attendId = intval($_GET['aid']);
empty($attendId) && redirect($backUrl, '参数错误');

$info = apiData('groupDetailApi.do', array('recordId'=>$attendId, 'userId'=>$userid));

!$info['success'] && redirect($backUrl, $info['error_msg']);

$info = $info['result'];
$time = strtotime($info['nowTime']);
$info['beginDateline'] = strtotime($info['beginTime']);
$info['endDateline'] = strtotime($info['endTime']);
$info['remainSec'] = $info['endDateline'] - $time;

$grouponId = $info['activityId'];

$isGrouponFree = ($info['activityType'] == 2) ? 1 : 0;// intval($_GET['free']);

//是否弹出黑幕(已支付，且差的人数>=1)
$showBlack = (($info['payStatus'] == 1) && ($info['poorNum'] >= 1)) ? true : false;


include_once('tpl/groupon_join_web.php');
?>