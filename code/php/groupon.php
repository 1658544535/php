<?php
define('HN1', true);
require_once('./global.php');

$backUrl = getPrevUrl();

$activeId = intval($_GET['id']);
empty($activeId) && redirect($backUrl);

//拼团信息
$objGroupon = M('groupon_activity');
$groupon = $objGroupon->get(array('id'=>$activeId,'status'=>1,'is_delete'=>0), '*', ARRAY_A);
empty($groupon) && redirect($backUrl, '没有相关的活动');
($groupon['type'] == 3) && redirect($backUrl);//猜价则跳出

//团免券(是否可团免)
$objGCpn = D('GrouponFreeCoupon');
$grouponCpn = $objGCpn->getUserCoupon($userid, array('valid'=>true,'intime'=>true));
$isLeader = empty($grouponCpn) ? false : true;
(($groupon['type']==2) && !$isLeader) && redirect($backUrl, '没有资格参与免团');

//商品信息
$objPro = D('Product');
$product = $objPro->getInfo($groupon['product_id']);

//其他团购
$time = time();
$date = date('Y-m-d H:i:s', $time);
$sql = "SELECT ga.`id`,ga.`product_id`,ga.`end_time`,ga.`num`,IFNULL(tmp.`buyernum`,0) AS buyernum,(ga.`num`-IFNULL(tmp.`buyernum`,0)) AS remain FROM `groupon_activity` AS ga LEFT JOIN (SELECT `activity_id`,`user_id`,COUNT(*) AS buyernum FROM `groupon_user_record` GROUP BY `activity_id`) AS tmp ON ga.`id`=tmp.`activity_id` LEFT JOIN `sys_login` AS sl ON tmp.`user_id`=sl.`id` WHERE ga.`status`=1 AND ga.`type`=1 AND ga.`is_delete`=0 AND ga.`begin_time`<='{$date}' AND ga.`end_time`>'{$date}' AND ga.`id`<>{$groupon['id']} ORDER BY remain ASC,ga.`end_time` ASC LIMIT 3";
$otherActives = $objGroupon->query($sql);
$otherActIds = array();
foreach($otherActives as $k => $v){
	$otherActIds[] = $v->id;
	$v->remainSec = strtotime($v->end_time)-$time;
}
$leaders = array();
if(!empty($otherActIds)){
	$sql = 'SELECT gur.`activity_id`,gur.`user_id`,sl.`image`,sl.`name` FROM `sys_login` AS sl LEFT JOIN `groupon_user_record` AS gur ON sl.`id`=gur.`user_id` WHERE gur.`activity_id` IN ('.implode(',', $otherActIds).') AND gur.`is_head`=1';
	$rs = $objGroupon->query($sql);
	foreach($rs as $k => $v){
		$v->image = getFullAvatar($v->image);
		$leaders[$v->activity_id] = $v;
	}
}

include_once('tpl/groupon_web.php');
?>