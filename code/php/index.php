<?php
define('HN1', true);
require_once('./global.php');

//分类
$cates = apiData('productTypeNav.do');
$cates = $cates['result'];

//团免券
$freeCpn = apiData('checkGroupFreeApi.do', array('userId'=>$userid));
$freeCpn = $freeCpn['success'] ? $freeCpn['result'] : null;

$footerNavActive = 'index';

include "tpl/index_new.php";
?>