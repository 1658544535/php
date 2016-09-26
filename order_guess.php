<?php
//直购下单
define('HN1', true);
require_once('./global.php');

define('ORDER_IN', true);

$prevUrl = getPrevUrl();

$productId = intval($_GET['pid']);
empty($productId) && redirect($prevUrl);

$grouponId = intval($_GET['id']);

$_SESSION['order']['grouponId'] = $grouponId;
$_SESSION['order']['type'] = 'guess';

include_once('order_common.php');
?>