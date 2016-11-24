<?php
define('HN1', true);
require_once('./global.php');
$cateId = intval($_REQUEST['id']);

//分类
// $cates = apiData('productTypeNav.do');
// $cates = $cates['result'];

//首页一级分类
$classification = apiData('productCategoryApi.do');
$classification = $classification['result'];


//获取首页二级分类数据
  foreach ($classification as $k=>$v){
	if(in_array($cateId,$v)){
		$twoClass = $v;
	}
  }
  $twoClass = $twoClass['twoLevelList'];




//团免券
$freeCpn = apiData('checkGroupFreeApi.do', array('userId'=>$userid));
$freeCpn = $freeCpn['success'] ? $freeCpn['result'] : null;
if(!empty($freeCpn))
{
	$cpnStart = date('Y.n.j', strtotime($freeCpn['beginTime']));
	$cpnEnd = date('Y.n.j', strtotime($freeCpn['endTime']));
}

//秒杀商品
$seckillPro = apiData('homeSecKillListApi.do');
$seckillPro = $seckillPro['success'] ? $seckillPro['result'] : array();

$footerNavActive = 'index';

include "tpl/index_new.php"; 
?>