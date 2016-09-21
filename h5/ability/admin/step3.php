<?php
define('HN1', true);
define('DEBUG_TEST', false);
define('CURRENT_ADMIN_ROOT', dirname(__FILE__).'/');
define('CURRENT_ROOT', CURRENT_ADMIN_ROOT.'../');
require_once(CURRENT_ROOT.'../h5_global.php');

define('CURRENT_TPL_DIR', CURRENT_ADMIN_ROOT.'tpl/');

//本地开发配置
$__devCfg = CURRENT_ROOT.'local_dev_config.php';
file_exists($__devCfg) && include_once($__devCfg);

define('__CURRENT_ADMIN_URL__', $site.'h5/ability/admin');
define('__CURRENT_PAGE_URL__', __CURRENT_ADMIN_URL__.'/partin.php');

$gOptions = include_once(CURRENT_ROOT.'option.php');

//商品图片地址
$goodsPicUrl = 'http://b2c.taozhuma.com/upfiles/product/small/';

$objPartin = M('h5_ability_partin');
$objPartitem = M('h5_ability_partitem');
$objinfo = M(`h5_ability_wxuser`);


$pid   = $_REQUEST['pid'] == null ? '' : $_REQUEST['pid'];
$sql = 'SELECT * FROM `h5_ability_partin` WHERE  `id`='.$pid.'  ORDER BY `time` DESC';

$partin = $objPartin->query($sql, true);

$partitem = $objPartitem->getAll(array('partin_id'=>$partin->id), '*', array('field_index'=>'asc', 'item_index'=>'asc'), '', ARRAY_A);

$fields = $gOptions[$partin->age_index]['fields'];

$goodsList = array();
$goodsIds = array();

$fieldText = array();//各领域总结内容
$fieldSelItem = array();//各领域选中的项
$fieldGoods = array();//各领域商品

//各领域选中的得分
$fieldScore = array();
$selFieldGoods = array();
foreach($partitem as $v){
	$_score = $fields[$v['field_index']]['items'][$v['item_index']]['score'];
	if(isset($fieldScore[$v['field_index']])){
		$fieldScore[$v['field_index']] += $_score;
	}else{
		$fieldScore[$v['field_index']] = $_score;
	}
	$fieldText[$v['field_index']][] = $fields[$v['field_index']]['items'][$v['item_index']]['msg_able'];
	$fieldSelItem[$v['field_index']][] = $v['item_index'];
	
	$goodsId = $fields[$v['field_index']]['items'][$v['item_index']]['goods_id'];
	$goodsId && $selFieldGoods[$v['field_index']][] = array('sel'=>1, 'goods_id'=>$goodsId, 'item_index'=>$v['item_index']);
}

//各领域总分
$fieldTotalScore = array();
$unselFieldGoods = array();
foreach($fields as $fIndex => $_field){
	foreach($_field['items'] as $iIndex => $item){
		if(isset($fieldTotalScore[$fIndex])){
			$fieldTotalScore[$fIndex] += $item['score'];
		}else{
			$fieldTotalScore[$fIndex] = $item['score'];
		}
		//未选择的总结内容
		if(!in_array($iIndex, $fieldSelItem[$fIndex])){
			$fieldText[$fIndex][] = $item['msg_disabled'];
			$item['goods_id'] && $unselFieldGoods[$fIndex][] = array('sel'=>0, 'goods_id'=>$item['goods_id'], 'item_index'=>$iIndex);
		}
		$item['goods_id'] && $goodsIds[] = $item['goods_id'];
	}
}

//重排各领域商品
foreach($fields as $fIndex => $_field){
	$_unsel = isset($unselFieldGoods[$fIndex]) ? $unselFieldGoods[$fIndex] : array();
	$_sel = isset($selFieldGoods[$fIndex]) ? $selFieldGoods[$fIndex] : array();
	$fieldGoods[$fIndex] = array_merge($_unsel, $_sel);
}

//各领域分值比例
$fieldRatio = array();
foreach($fieldTotalScore as $_index => $_score){
	if(isset($fieldScore[$_index])){
		$_ratio = round($fieldScore[$_index]/$_score, 3);
		$_ratio *= 100;
		$fieldRatio[$_index] = ceil($_ratio);
	}else{
		$fieldRatio[$_index] = 0;
	}
}

//商品
if(!empty($goodsIds)){
	$objProduct = M('product');
	
	$rs = $objProduct->getAll('id in ('.implode(',', $goodsIds).')', 'id,product_name,image', array(), '', ARRAY_A);
	
	foreach($rs as $v){
		$goodsList[$v['id']] = $v;
	}
}


require_once(CURRENT_TPL_DIR.'step3_tpl.php');

