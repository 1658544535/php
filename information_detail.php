<?php
define('HN1', true);
require_once('global.php');

require_once LOGIC_ROOT.'infoBean.php';

$id = $_REQUEST['id'] == null ? '0' : $_REQUEST['id'];

$ib = new infoBean();

$obj=$ib->detail($db,$id);

include "tpl/information_detail_web.php";
?>