<?php
define('HN1', true);
require_once ('global.php');

$q = strtolower($_GET["q"]);

$orders = $db->get_results("select * from product where name like '%".$q."%' and status=1");
echo json_encode($orders);
?>