<?php
define('HN1', true);
require_once('./global.php');

$backUrl = getPrevUrl();

$grouponId = intval($_GET['id']);
empty($grouponId) && redirect($backUrl);

$info = apiData('openGroupActivityApi.do', array('activityId'=>$grouponId, 'userId'=>$userid));
!$info['success'] && redirect($backUrl, $info['error_msg']);

$info = $info['result'];
if(!empty($info['waitGroupList'])){
	foreach($info['waitGroupList'] as $k => $v){
		$info['waitGroupList'][$k]['remainSec'] = strtotime($v['endTime']) - strtotime($v['nowTime']);
	}
}

//是否0元开团
$isFreeBuy = (($info['activityType'] == 2) && $info['isGroupFree']) ? true : false;

//sku
$skus = apiData('getProductSkus.do', array('pid'=>$info['productId']));
$skus = $skus['success'] ? $skus['result'] : array();

include_once('tpl/groupon_web.php');
?>