<?php
define('HN1', true);
require_once ('global.php');

$q = strtolower($_GET["q"]);

$orders = $db->get_results("select * from orders where order_number like '%".$q."%'");
echo json_encode($orders);
?>