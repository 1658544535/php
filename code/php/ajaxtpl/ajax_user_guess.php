<?php

define('HN1', true);
require_once('../global.php');

$GrouponActivityModel         = M('groupon_activity');
$GrouponActivityRecordModel   = M('groupon_activity_record');
$GrouponUserRecordModel       = M('groupon_user_record');
$FocusSettingModel            = M('focus_setting');
$UserInfoModel 				  = M('user_info');
$ProductFocusImagesModel      = M('product_focus_images');



$act  = CheckDatas( 'act', 'info' );
$page           = max(1, intval($_POST['page']));
$Type           = CheckDatas( 'type', '' );





$guess = apiData('myGuessListApi.do', array('userId'=>$userid,'type'=>$Type,'pageNo'=>$page));

if($guess !='')
{
     echo	ajaxJson( 1,'获取成功',$guess['result'],$page);
}
else
{
	echo	ajaxJson( 0,'获取失败');
}



?>