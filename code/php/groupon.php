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

//0.1抽奖
(($info['activityType'] == 5) && ($info['activityStatus'] == 0)) && redirect('/lottery_new.php', '活动尚未开始');

if(!empty($info['waitGroupList'])){
	foreach($info['waitGroupList'] as $k => $v){
		$info['waitGroupList'][$k]['remainSec'] = strtotime($v['endTime']) - strtotime($v['nowTime']);
	}
}
$grouponId = $info['activityId'];

//是否0元开团
if(($info['activityType'] == 2) && !$info['isGroupFree']){
	$_refer = $_SERVER['HTTP_REFERER'];
	$_pathinfo = pathinfo($_refer);
	$_jumpUrl = ($_pathinfo['filename'] == 'user_info') ? $_refer : '/';
	redirect($_jumpUrl, '您没有团免券');
}
$isFreeBuy = (($info['activityType'] == 2) && $info['isGroupFree']) ? true : false;

//sku
$skus = apiData('getProductSkus.do', array('pid'=>$info['productId']));
$skus = $skus['success'] ? $skus['result'] : array();

//收藏状态
$collected = ($info['isCollect'] == 1) ? true : false;

//猜你喜欢
$likes = apiData('guessYourLikeApi.do', array('activityId'=>$info['activityId'], 'userId'=>$userid));
$likes = $likes['result'];

//根据状态获取type值 获取分享内容
switch($info["activityType"]){
	case 5://0.1
		$type = 19;
		break;
	case 6://秒杀
		$type_arr = array(17,16); //(0-未开始 1-活动中 2-活动结束) (16-掌上秒杀（开枪中）;17-掌上秒杀（即将开始）)
		$type = $type_arr[$info['activityStatus']];
		break;
}

!$type && $type = 8;
$fx = apiData('getShareContentApi.do', array('id'=>$info['activityId'], 'type'=>$type));
$fx = $fx['result'];

switch($info['activityType']){
	case 5://0.1抽奖
	case 7://免费抽奖
		$showWaitGroupList = true;
		$notQuantity = true;
		break;
	case 8://免费抽奖
		$showWaitGroupList = true;
		$notQuantity = true;
		break;
	case 6://限时秒杀
		$notQuantity = true;
		if($info['isSellOut'] == 1){
			$seckillState = 'sellout';
		}else{
			$_secStatusMap = array(0=>'notstart', 1=>'selling', 2=>'end');
			$seckillState = $_secStatusMap[$info['activityStatus']];
		}
		$showWaitGroupList = ($seckillState == 'selling') ? true : false;
		break;
	default:
		$showWaitGroupList = $isFreeBuy ? false : true;
		break;
}

//限购判断
$num = intval($_GET['num']);
$num = max(1, $num);

$skuId = intval($_GET['skuid']);
empty($skuId) && $skuId = $_SESSION['order']['sku'] ? $_SESSION['order']['sku'] : '';
$d = apiData('addPurchase.do', array('activityId'=>$grouponId,'num'=>$num,'skuLinkId'=>$skuId,'pid'=>$info['productId'],'source'=>1,'uid'=>$userid));




include_once('tpl/groupon_web.php');
?>