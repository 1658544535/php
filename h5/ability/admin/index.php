<?php
define('HN1', true);
define('DEBUG_TEST', false);
define('CURRENT_ADMIN_ROOT', dirname(__FILE__).'/');
define('CURRENT_ROOT', CURRENT_ADMIN_ROOT.'../');
require_once(CURRENT_ROOT.'../h5_global.php');

define('CURRENT_TPL_DIR', CURRENT_ADMIN_ROOT.'tpl/');

//本地开发配置
$__devCfg = CURRENT_ROOT.'local_dev_config.php';
file_exists($__devCfg) && include_once($__devCfg);

define('__CURRENT_ADMIN_URL__', $site.'h5/ability/admin');

$market_admin = isset( $_SESSION['marketAdmin'] ) ? $_SESSION['marketAdmin'] : '';
$act 		  = isset( $_REQUEST['act'] ) 	? $_REQUEST['act'] : '';

if( $market_admin != null || $act == 'add' )			// 如果用户已登录
{
    $market_type 	 = $market_admin['type'];
    $market_name 	 = $market_admin['name'];
}
else													// 否则跳转到登录页面
{
    redirect("login.php");
    return;
}

require_once(CURRENT_TPL_DIR.'header.php');
require_once(CURRENT_TPL_DIR.'index.php');
