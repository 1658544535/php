<?php
define('HN1', true);
require_once('./global.php');

$freeCpn = apiData('checkGroupFreeApi.do', array('userId'=>$userid));
empty($freeCpn) && redirect(getPrevUrl());

include_once('tpl/groupon_free_web.php');
?>