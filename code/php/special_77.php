<?php
define('HN1', true);
require_once('./global.php');

$info = apiData('zoneApi.do');
$info = $info['result'];

$footerNavActive = 'spe77';

include_once('tpl/special77_web.php');
?>