<?php
define('HN1', true);
require_once('./global.php');

$id = intval($_GET['id']);

$pic = apiData('specialImageApi.do', array('specialId'=>$id));
$pic = $pic['result'];

//获取分享内容
$fx = apiData('getShareContentApi.do', array('id'=>$id,'type'=>13));
$fx = $fx['result'];

include_once('tpl/special_web.php');