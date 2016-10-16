<?php
define('HN1', true);
require_once('./global.php');

$info = apiData('specialTypeApi.do');
$info = $info['result'];

include_once('tpl/special77_web.php');
?>