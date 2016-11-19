<?php
define('HN1', true);
require_once('./global.php');
//新品专区
$SpecialImage = apiData('newSpecialImageApi.do');
$SpecialImage = $SpecialImage['result'];

//获取分享内容
$fx = apiData('getShareContentApi.do', array('id'=>20, 'type'=>20));
$fx = $fx['result'];
$footerNavActive = 'new';
include_once('tpl/newspecial_web.php');
?>