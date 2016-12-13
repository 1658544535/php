<?php
define('HN1', true);
require_once('./global.php');

$act   = CheckDatas( 'act', 'info' );

switch($act)
{
	case 'about':
		include_once('tpl/user_about_web.php');
		break;
	case 'user_coupon':
		include_once('tpl/coupon_web.php');
		break;
    default:
    include_once('tpl/user_set_web.php');
}
?>