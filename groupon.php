<?php
define('HN1', true);
require_once('./global.php');

$backUrl = getPrevUrl();

$grouponId = intval($_GET['id']);
$productId = intval($_GET['pid']);
//empty($grouponId) && redirect('/');

$act = trim($_GET['act']);
$apiParam = array('userId'=>$userid);
if($act == 'guess'){
	$apiParam['pid'] = $productId;
}else{
	$apiParam['activityId'] = $grouponId;
}
$info = apiData('openGroupActivityApi.do', $apiParam);
!$info['success'] && redirect($backUrl, $info['error_msg']);

$info = $info['result'];
if(!empty($info['waitGroupList'])){
	foreach($info['waitGroupList'] as $k => $v){
		$info['waitGroupList'][$k]['remainSec'] = strtotime($v['endTime']) - strtotime($v['nowTime']);
	}
}
$grouponId = $info['activityId'];

//是否0元开团
(($info['activityType'] == 2) && !$info['isGroupFree']) && redirect('/', '您没有团免券');
$isFreeBuy = (($info['activityType'] == 2) && $info['isGroupFree']) ? true : false;

//sku
$skus = apiData('getProductSkus.do', array('pid'=>$info['productId']));
$skus = $skus['success'] ? $skus['result'] : array();

//收藏状态
$collected = ($info['isCollect'] == 1) ? true : false;

//猜你喜欢
$likes = apiData('guessYourLikeApi.do', array('productId'=>$info['productId'], 'userId'=>$userid));
$likes = $likes['result'];

include_once('tpl/groupon_web.php');
?>