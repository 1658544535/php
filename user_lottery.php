<?php
define('HN1', true);
require_once('./global.php');
//判断是否登录
IS_USER_LOGIN();
$uId  = CheckDatas( 'uid', '' );

include "tpl/user_lottery_web.php";
?>
