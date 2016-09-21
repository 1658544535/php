<?php
define('HN1', true);
require_once ('global.php');

$q = strtolower($_GET["q"]);

$users = $db->get_results("select * from user where name like '%".$q."%' and status=1");
echo json_encode($users);
?>