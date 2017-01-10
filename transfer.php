<?php
/**
 * 中转
 */
define('HN1', true);
require_once('./global.php');

//判断是否登录
IS_USER_LOGIN();

header('location:/');
?>