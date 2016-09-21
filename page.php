<?php
define('HN1', true);
require_once('./global.php');

$type = @$_GET['type'];

switch ( $type )
{
	case 'not_allow':
		include_once(  SCRIPT_ROOT . 'tpl/not_allow.php' );
	break;

	case 'first_order':   		 //首单专享
		include_once(  SCRIPT_ROOT . 'tpl/first_order.php' );
	break;

	case 'download_app':  		//APP下载
		include_once(  SCRIPT_ROOT . 'tpl/download_app.php' );
	break;

	case 'first_order_coupon':	//首单专享（由微信菜单进入）
		include_once(SCRIPT_ROOT.'tpl/first_order_coupon.php');
	break;

	case 'new_member':			//新人
		include_once(SCRIPT_ROOT.'tpl/new_member.php');
	break;

	case 'appdown':
		include_once(SCRIPT_ROOT.'tpl/appdown_web.php');
	break;

	case 'coupon_rule':		//代金券使用规则
		include_once(SCRIPT_ROOT.'tpl/user_coupon_rule_web.php');
	break;
}
?>
