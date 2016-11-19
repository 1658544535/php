<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/16 0016
 * Time: 16:59
 */
session_start();
header("content-type: text/html; charset=utf-8");
date_default_timezone_set('Asia/Shanghai');
define('HN1', true);
define('LIB_ROOT'  , dirname(__FILE__) . '/../includes/lib/');
define('APP_INC'   , dirname(__FILE__) . '/../includes/inc/');
define('WX_UPLOAD' , dirname(__FILE__) . '/../upfiles/wx/'); //微信上传位置
define('DATA_DIR'  , dirname(__FILE__) . '/../data/wx/'); //微信数据保存的位置
define('USER_TOKEN', 'HAHAHA'); //自定义认证token

$isTest = isset($isTest) ? $isTest : '';

include_once(APP_INC . 'config.php');
include_once(APP_INC . 'functions.php');
include_once(LIB_ROOT. 'Weixin.class.php');
include_once(LIB_ROOT. 'weixin/errCode.php');

//根据操作名称进行相应操作
$act = CheckDatas('act','');
//登陆判断
if (empty($_SESSION['admin_login'])) {
    if (!strpos($_SERVER['PHP_SELF'],"auth.php")) {
        Header("Location:auth.php?act=login");
    }
}