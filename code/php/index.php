<?php
define('HN1', true);
require_once('./global.php');

//分类
$cates = apiData('productTypeNav.do');
$cates = $cates['result'];

//首页一级分类
$classification = apiData('productCategoryApi.do');
$classification = $classification['result'];


//团免券
$freeCpn = apiData('checkGroupFreeApi.do', array('userId'=>$userid));
$freeCpn = $freeCpn['success'] ? $freeCpn['result'] : null;
if(!empty($freeCpn)){
	$cpnStart = date('Y.n.j', strtotime($freeCpn['beginTime']));
	$cpnEnd = date('Y.n.j', strtotime($freeCpn['endTime']));
}

$footerNavActive = 'index';

include "tpl/index_new.php"; 
?>