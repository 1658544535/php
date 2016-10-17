<?php
define('HN1', true);
require_once('./global.php');

$id = intval($_GET['id']);

$pic = apiData('specialImageApi.do', array('specialId'=>$id));
$pic = $pic['result'];

include_once('tpl/special_web.php');