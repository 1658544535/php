<?php
define('HN1', true);
require_once('./global.php');

$info = apiData('myInfoApi.do', array('userId'=>$userid));
$info = $info['result'];
!empty($info['couponBTime']) && $info['couponBTime'] = strtotime($info['couponBTime']);
!empty($info['couponETime']) && $info['couponETime'] = strtotime($info['couponETime']);

$footerNavActive = 'user';

include "tpl/user_web.php";
?>
