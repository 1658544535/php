<?php
define('HN1', true);
require_once('global.php');

require_once LOGIC_ROOT.'helpBean.php';
$return_url 	      = !isset($_GET['return_url']) || ($_GET['return_url'] == '') ? '/help' : $_GET['return_url'];
$id = $_REQUEST['id'] == null ? '' : $_REQUEST['id'];

$ib = new helpBean();

$row=$ib->detail($db,$id);

include "tpl/list_art_web.php";
?>