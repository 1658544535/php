<?php
 /*
  * 获取瀑布流消息ajax
  */
define('HN1', true);
require_once('../global.php');

$messageType = CheckDatas('type', 0);
$pageNo      = CheckDatas('page',0);

//不同消息类型的获取信息接口名字数组
$apiNameArr  = array(
    1=>'',
    2=>'',
    3=>'userOrderNoticeApi.do'
);

$getMessage = apiData($apiNameArr[$messageType], array('userId'=>$userid, 'pageNo'=>$pageNo));

if ($getMessage['success'] != false) {
    $messageData = $getMessage['result'];
    echo ajaxJson(1, '获取成功', $messageData, $pageNo);
} else {
    echo ajaxJson(0, '获取失败');
}

?>