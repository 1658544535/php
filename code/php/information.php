<?php
define('HN1', true);
require_once('global.php');

require_once LOGIC_ROOT.'infoBean.php';

$ib			= new infoBean();
$type 		= ( ! isset($_REQUEST['type']) ) ? '1' : intval($_REQUEST['type']);

$infoList 	= $ib->searchs( $db, $page, 10, $type );

include "tpl/information_web.php";

?>