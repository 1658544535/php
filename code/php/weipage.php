<?php
define('HN1', true);
require_once ('global.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;//10006;
$type = 4;

$frameHost = 'http://ext1.taozhuma.com';
$frameHost = 'http://b2c.taozhuma.com';
$frameUrl = "{$frameHost}/page/getMicroPageVisApi.do?temp=weixin&id={$id}&type={$type}";

$apple = (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) ? true : false;

include "tpl/weipage_web.php";
?>
