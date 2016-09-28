<?php
define('HN1', true);
require_once('./global.php');

$ajax = isAjax();

!$ajax && IS_USER_LOGIN();
$time = time();

//$objFreeCpn = D('GrouponFreeCoupon');
//$freeCpn = $objFreeCpn->getUserCoupon($userid);
//
//if($ajax){
//	if(empty($freeCpn)){
//		ajaxResponse(false, '没有相关数据');
//	}else{
//		$page = intval($_REQUEST['page']);
//		$page = max(1, $page);
//		$perpage = 10;
//		$objGroupon = M('groupon_activity');
//		$rs = $objGroupon->gets(array('type'=>2,'status'=>1,'is_delete'=>0), 'id,product_id,title,price,banner', array('sorting'=>'desc','id'=>'desc'), $page, $perpage);
//		$list = array();
//		if(!empty($rs['DataSet'])){
//			$activeIds = array();
//			$productIds = array();
//			foreach($rs['DataSet'] as $k => $v){
//				$activeIds[] = $v->id;
//				$productIds[] = $v->product_id;
//			}
//			$objPro = M('product');
//			$pros = $objPro->getAll(array('__IN__'=>array('id'=>$productIds),'status'=>1), 'id,product_name,distribution_price,image_small');
//			$proList = array();
//			foreach($pros as $v){
//				$proList[$v->id] = $v;
//			}
//			foreach($rs['DataSet'] as $k => $v){
//				$tmp = array(
//					'id' => $v->id,
//					'name' => $v->title,
//					'price' => $v->price,
//					'oldPrice' => isset($proList[$v->product_id]) ? $proList[$v->product_id]->distribution_price : 0,
//				);
//				if(isset($proList[$v->product_id])){
//					$tmp['name'] = $proList[$v->product_id]->product_name;
//					$tmp['oldPrice'] = $proList[$v->product_id]->distribution_price;
//					$tmp['imgSrc'] = $site_image.$proList[$v->product_id]->image_small;
//				}else{
//					$tmp['name'] = '';
//					$tmp['oldPrice'] = 0;
//					$tmp['imgSrc'] = '';
//				}
//				$list[] = $tmp;
//			}
//		}
//
//		$data = array(
//			'data' => array(
//				'pageNow' => $rs['CurrentPage'],
//				'pageCount' => $rs['PageCount'],
//				'listData' => $list,
//			),
//		);
//		ajaxResponse(true, '', $data);
//	}
//}else{
//	empty($freeCpn) && redirect(getPrevUrl());
//	include_once('tpl/groupon_free_web.php');
//}

$freeCpn = apiData('checkGroupFreeApi.do', array('userId'=>$userid));
empty($freeCpn) && redirect(getPrevUrl());

include_once('tpl/groupon_free_web.php');
?>