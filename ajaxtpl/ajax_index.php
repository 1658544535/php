<?php

define('HN1', true);
require_once('../global.php');

$FocusSettingModel         = M('focus_setting');

//首页轮播图片
$objBannerImages  = $FocusSettingModel->getAll(array('status'=>1));
$data =  get_json_data_public( $objBannerImages );

?>
