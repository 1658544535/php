<?php
//直购下单
define('HN1', true);
require_once('./global.php');

define('ORDER_IN', true);

$prevUrl = getPrevUrl();

$productId = intval($_GET['id']);
empty($productId) && redirect($prevUrl);

$_SESSION['order']['type'] = 'alone';

include_once('order_common.php');
?>