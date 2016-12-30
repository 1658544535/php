<?php
define('HN1', true);
require_once('./global.php');



//判断是否登录
IS_USER_LOGIN();

$backUrl = getPrevUrl();

$attendId = intval($_GET['aid']);
$pdkUid   = intval($_GET['pdkUid']);
empty($attendId) && redirect($backUrl, '参数错误');

$info = apiData('groupDetailApi.do', array('recordId'=>$attendId, 'userId'=>$userid));

!$info['success'] && redirect($backUrl, $info['error_msg']);

$info = $info['result'];
$time = strtotime($info['nowTime']);
$info['beginDateline'] = strtotime($info['beginTime']);
$info['endDateline'] = strtotime($info['endTime']);
$info['remainSec'] = $info['endDateline'] - $time;

$grouponId = $info['activityId'];
$productId = $info['productId']; 
//$isGrouponFree = ($info['activityType'] == 2) ? 1 : 0;// intval($_GET['free']);

//是否弹出黑幕(已支付，且差的人数>=1)
$showBlack = (($info['payStatus'] == 1) && ($info['poorNum'] >= 1)) ? true : false;

//是否可点击商品跳转到开团页面
if($info['activityType'] == 2){//团免，需用户有免团券
	$isGrouponFree = 1;
	$freeCpn = apiData('checkGroupFreeApi.do', array('userId'=>$userid));
	$jumpProduct = $freeCpn['success'] ? true : false;
}else{//非团免
	$isGrouponFree = 0;
	$jumpProduct = true;
}
//sku
$skus = array();
if(($info['status'] == 0) && ($info['userIsHead'] != 1) && ($info['isGroup'] == 0)){
	$skus = apiData('getProductSkus.do', array('pid'=>$info['productId']));
	$skus['success'] && $skus = $skus['result'];
}


//获取分享内容
if($info['activityType'] == 8){
  if($pdkUid !=''){
	$fx = apiData('getShareContentApi.do', array('id'=>$attendId,'pdkUid'=>$pdkUid,'type'=>9));
  }else{
  	$fx = apiData('getShareContentApi.do', array('id'=>$attendId,'pdkUid'=>$userid,'type'=>9));
  }	
  	$fx = $fx['result'];
}else{
	$fx = apiData('getShareContentApi.do', array('id'=>$attendId, 'type'=>9));
	$fx = $fx['result'];
}

//猜你喜欢

$pList = apiData('guessYourLikeApi.do', array('activityId'=>$grouponId, 'userId'=>$userid));
$pList = $pList['result'];

$wxUser = $objWX->getUserInfo($openid);


//返回的地址
if($info['activityType'] == 8){
	$backStep = '-2';
}else{
	$backStep = '-1';
}

include_once('tpl/groupon_join_web.php');
?>