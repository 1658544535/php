<?php
define('HN1', true);
require_once('./global.php');

$ajax = isAjax();

!$ajax && IS_USER_LOGIN();
$time = time();

$objFreeCpn = D('GrouponFreeCoupon');
$freeCpn = $objFreeCpn->getUserCoupon($userid);

if($ajax){
	if(empty($freeCpn)){
		ajaxResponse(false, '没有相关数据');
	}else{
		$page = intval($_REQUEST['page']);
		$page = max(1, $page);
		$perpage = 10;
		$objGroupon = M('groupon_activity');
		$rs = $objGroupon->gets(array('type'=>2,'status'=>1,'is_delete'=>0), 'id,product_id,title,price,banner', array('sorting'=>'desc','id'=>'desc'), $page, $perpage);
		$list = array();
		if(!empty($rs['DataSet'])){
			$activeIds = array();
			$productIds = array();
			foreach($rs['DataSet'] as $k => $v){
				$activeIds[] = $v->id;
				$productIds[] = $v->product_id;
			}
			$objPro = M('product');
			$pros = $objPro->getAll(array('__IN__'=>array('id'=>$productIds)), 'id,distribution_price');
			$proList = array();
			foreach($pros as $v){
				$proList[$v->id] = $v;
			}
			foreach($rs['DataSet'] as $k => $v){
				$list[] = array(
					'id' => $v->id,
					'name' => $v->title,
					'price' => $v->price,
					'oldPrice' => isset($proList[$v->product_id]) ? $proList[$v->product_id]->distribution_price : 0,
					'imgSrc' => $site_image.$v->banner,
				);
			}
		}

		$data = array(
			'data' => array(
				'pageNow' => $rs['CurrentPage'],
				'pageCount' => $rs['PageCount'],
				'listData' => $list,
			),
		);
		ajaxResponse(true, '', $data);
	}
}else{
	empty($freeCpn) && redirect('/');
	include_once('tpl/groupon_free_web.php');
}
?>