<?php
define('HN1', true);
define('DEBUG_TEST', false);
define('CURRENT_ADMIN_ROOT', dirname(__FILE__).'/');
define('CURRENT_ROOT', CURRENT_ADMIN_ROOT.'../');
require_once(CURRENT_ROOT.'../h5_global.php');

define('CURRENT_DATA_DIR', CURRENT_ADMIN_ROOT.'data/');
define('CURRENT_TPL_DIR', CURRENT_ADMIN_ROOT.'tpl/');

//本地开发配置
$__devCfg = CURRENT_ROOT.'local_dev_config.php';
file_exists($__devCfg) && include_once($__devCfg);

define('__CURRENT_ADMIN_URL__', $site.'h5/ability/admin');

$market_admin = isset( $_SESSION['marketAdmin'] ) ? $_SESSION['marketAdmin'] : "";
$act = isset( $_REQUEST['act'] ) ? $_REQUEST['act'] :  '';


if( $market_admin != null && $act != 'logout' ){
    redirect( "index.php",'该用户已登录！');
}

switch( $act )
{
    case 'post':
        check();
        break;

    case 'logout':
        logout();
        break;

    default:
        include_once(CURRENT_TPL_DIR.'login.php');
}

function check()
{
    $username	= isset($_POST['username']) ? sqlUpdateFilter($_POST['username']) 	 : '';
    $pwd 		= isset($_POST['pwd']) 		? md5($_POST['pwd']) 					 : '';

    $arrUserInfo = require_once( CURRENT_DATA_DIR . 'user.php' );		// 获取用户列表

    $url = 'login.php';
    $tip = '您输入的帐号和（或）密码有误！';

    foreach( $arrUserInfo as $UserInfo )
    {
        if ( $username == $UserInfo['name'] && $pwd == $UserInfo['pwd'] )
        {
            $url = 'index.php';
            $tip = '登录成功！';
            $_SESSION['marketAdmin']   = $UserInfo;
            break;
        }
    }

    redirect( $url,$tip);
}

function logout()
{
    $_SESSION['marketAdmin'] = null;
    redirect( "login.php",'退出成功！');
}