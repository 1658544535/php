<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/16 0016
 * Time: 16:59
 */
session_start();

define('HN1', true);
define('LIB_ROOT', dirname(__FILE__) . '/../includes/lib/');
define('APP_INC' , dirname(__FILE__) . '/../includes/inc/');
define('DATA_DIR', dirname(__FILE__) . '/../data/wx/'); //数据保存的位置
define('USER_TOKEN', 'HAHAHA'); //自定义认证token

$isTest = isset($isTest) ? $isTest : '';

include_once(APP_INC . 'config.php');
include_once(APP_INC . 'functions.php');
include_once(LIB_ROOT. 'Weixin.class.php');
include_once(LIB_ROOT. 'weixin/errCode.php');

//根据操作名称进行相应操作
$act = CheckDatas('act','');
$account = array('username' => 'haha', 'passwd' => 'haha');

//登陆判断
$isLogin = !empty($_SESSION['admin_login']) ? true : false;

if (!$isLogin) {
    if ($act !== 'login'){
        $url = 'auth.php?act=login';
        Header("Location:$url");
    }
} else {
    if ($act == 'login') {
        echo '<script>window.location.href="auth.php"</script>';
    }
}