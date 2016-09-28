<?php
define('HN1', true);
require_once('./global.php');

$GrouponActivityModel         = M('groupon_activity');
$GrouponActivityRecordModel   = M('groupon_activity_record');
$GrouponUserRecordModel       = M('groupon_user_record');
$FocusSettingModel            = M('focus_setting');
$UserInfoModel 				  = M('user_info');
$ProductFocusImagesModel      = M('product_focus_images');



$act  = CheckDatas( 'act', 'info' );
$productId   	= CheckDatas( 'pid', '' );
$uId   	        = CheckDatas( 'uid', '' );
$gId   	        = CheckDatas( 'gid', '' );
$Prize   	    = CheckDatas( 'prize', '' );
$Price          = CheckDatas( 'price', '' );
$as             = CheckDatas( 'activity_status', '' );





include "tpl/user_orders_web.php";




















































?>