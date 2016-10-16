<?php
define('HN1', true);
require_once('./global.php');

$id = intval($_GET['id']);

$info = array();

include_once('tpl/special_web.php');