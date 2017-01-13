<?php
/**
 * 打开外链
 */
define('HN1', true);
require_once('./global.php');

$url = trim($_GET['url']);
$title = trim($_GET['title']);


include "tpl/link_web.php";
?>