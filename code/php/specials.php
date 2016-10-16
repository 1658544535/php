<?php
define('HN1', true);
require_once('./global.php');

$cates = apiData('specialTypeApi.do');
$cates = $cates['result'];

include_once('tpl/specials_web.php');
?>