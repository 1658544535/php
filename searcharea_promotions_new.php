<?php
define('HN1', true);
require_once ('global.php');

$q = strtolower($_GET["q"]);

$promotions_new = $db->get_results("select * from promotions_new where title like '%".$q."%' and status=1");
echo json_encode($promotions_new);
?>