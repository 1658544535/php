<?php

define('HN1', true);
require_once('../global.php');

$FocusSettingModel         = M('focus_setting');

//首页轮播图片
$objBannerImages  = $FocusSettingModel->getAll(array('status'=>1));
if($objBannerImages !='')
{
   echo  get_json_data_public( 1,'获取成功',$objBannerImages );
}
else
{
    echo  get_json_data_public( -1,'获取失败' );	
}
?>
