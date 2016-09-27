<?php
define('HN1', true);
require_once('./global.php');

$backUrl = getPrevUrl();

$grouponId = intval($_GET['id']);
empty($grouponId) && redirect($backUrl, '参数错误');

//$time = time();

////拼团信息
//$objGroupon = M('groupon_activity');
//$groupon = $objGroupon->get(array('id'=>$grouponId,'status'=>1,'is_delete'=>0), '*', ARRAY_A);
//empty($groupon) && redirect($backUrl, '没有相关的活动');
//($groupon['type'] == 3) && redirect($backUrl);//猜价则跳出
//$groupon['remainSec'] = strtotime($groupon['end_time'])-$time;
//
//$objUserRs = M('groupon_user_record');
//
//$sql = "SELECT gur.`user_id`,gur.`attend_time`,gur.`is_head`,sl.`name` AS uname,sl.`image` FROM `groupon_user_record` AS gur LEFT JOIN `sys_login` AS sl ON gur.`user_id`=sl.`id` WHERE gur.`activity_id`={$grouponId} ORDER BY gur.`is_head` DESC,gur.`attend_time` ASC,gur.`id` ASC";
//$rs = $objUserRs->query($sql);
////empty($rs) && redirect('groupon.php?id='.$grouponId, '未开团，现在开团');
//
//$joiners = array();
//foreach($rs as $v){
//	$v->image = getFullAvatar($v->image);
//	$joiners[] = $v;
//}
//
//$joinerCount = count($joiners);
//
//if(strtotime($groupon['end_time']) < $time){//已结束
//
//}else{//进行中
//	if($joinerCount < $groupon['num']){//人数未满
//		
//	}
//}
//
////商品信息
//$objPro = D('Product');
//$product = $objPro->getInfo($groupon['product_id']);

$info = apiData('groupDetailApi.do', array('activityId'=>$grouponId, 'userId'=>$userid));
!$info['success'] && redirect($backUrl, $info['error_msg']);

$info = $info['result'];
$time = $info['nowTime'];
$info['beginDateline'] = strtotime($info['beginTime']);
$info['endDateline'] = strtotime($info['endTime']);
$info['remainSec'] = $info['endDateline'] - $time;

include_once('tpl/groupon_join_web.php');
?>