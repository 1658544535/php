<?php
define('HN1', true);
require_once('./global.php');

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

$isGrouponFree = intval($_GET['free']);





include_once('tpl/groupon_join_web.php');
?>