<?php
define('HN1', true);
require_once('./global.php');

$info = apiData('zoneApi.do');
$info = $info['result'];

//获取分享内容
$fx = apiData('getShareContentApi.do', array('id'=>14, 'type'=>14));
$fx = $fx['result'];
$footerNavActive = 'spe77';

include_once('tpl/special77_web.php');
?>