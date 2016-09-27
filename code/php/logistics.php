<?php
define('HN1', true);
require_once('./global.php');

$orderId = intval($_GET['oid']);
empty($orderId) && redirect(getPrevUrl(), '参数错误');

$info = apiData('express.do', array('orderId'=>$orderId));

include_once('tpl/logistics_web.php');
?>