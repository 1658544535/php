<?php
//普团下单
define('HN1', true);
require_once('./global.php');

define('ORDER_IN', true);

$prevUrl = getPrevUrl();

$grouponId = intval($_GET['id']);
empty($grouponId) && redirect($prevUrl);

$time = time();

//拼团活动信息
$objGroupon = D('Groupon');
$groupon = $objGroupon->getInfo($grouponId);
empty($groupon) && redirect($prevUrl);
($groupon['status'] != 1) && redirect($prevUrl, '活动不存在');
($groupon['type'] != 1) && redirect($prevUrl, '参数错误');
(($groupon['activity_status'] == 0) || (strtotime($groupon['begin_time']) > $time)) && redirect($prevUrl, '活动未开始');
(($groupon['activity_status'] == 2) || (strtotime($groupon['end_time']) < $time)) && redirect($prevUrl, '活动已结束');

//实际下单价格
$factOrderPrice = $groupon['price'];

$productId = $groupon['product_id'];

$_SESSION['order']['type'] = 'groupon';

include_once('order_common.php');
?>