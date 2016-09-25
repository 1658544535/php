<?php
define('HN1', true);
require_once('./global.php');

$productId = intval($_GET['id']);
$objGroupon = M('groupon_activity');

$objPro = D('Product');
$product = $objPro->get(array('id'=>$productId,'status'=>1), 'product_name,image_small', ARRAY_A);

if(isAjax()){
	empty($productId) && ajaxResponse(false, '参数错误');

	$page = intval($_REQUEST['page']);
	$page = max(1, $page);
	$perpage = 10;

	$rs = $objGroupon->gets(array('product_id'=>$productId,'type'=>1,'status'=>1,'is_delete'=>0), 'id,product_id,title,price,banner,num', array('sorting'=>'desc','id'=>'desc'), $page, $perpage);

	$list = array();
	if(!empty($rs['DataSet'])){
		$activeIds = array();
		foreach($rs['DataSet'] as $k => $v){
			$activeIds[] = $v->id;
		}

		$sql = 'SELECT `activity_id`,COUNT(*) AS num FROM `groupon_user_record` WHERE `activity_type`=1 AND `activity_id` IN ('.implode(',', $activeIds).') GROUP BY `activity_id`';
		$records = $objGroupon->query($sql);
		$recordList = array();
		foreach($records as $v){
			$recordList[$v->activity_id] = $v->num;
		}

		foreach($rs['DataSet'] as $k => $v){
			$list[] = array(
				'id' => $v->id,
				'name' => $product['product_name'],
				'price' => $v->price,
				'imgSrc' => $site_image.$product['image_small'],
				'num' => $v->num,
				'sales' => isset($recordList[$v->id]) ? $recordList[$v->id] : 0,
			);
		}
	}

	$Data =array(
        'pageNow' => $rs['CurrentPage'],
		'pageCount' => $rs['PageCount'],
		'data' => $list
	);
	echo get_json_data_public(1, "获取成功", $Data);
}else{
	empty($productId) && redirect('/');

	empty($product) && redirect(getPrevUrl(), '商品已下架');
	
	include_once('tpl/groupon_multi_web.php');
}
?>