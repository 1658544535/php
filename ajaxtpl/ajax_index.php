<?php

define('HN1', true);
require_once('../global.php');

$FocusSettingModel         = M('focus_setting');
$GrouponActivityModel      = M('groupon_activity');
$GrouponUserRecordModel    = M('groupon_user_record');
$GrouponFreeCouponModel    = M('groupon_free_coupon');
$typeId = CheckDatas( 'tid', '' );


//首页轮播图片
$objBannerImages  = $FocusSettingModel->getAll(array('status'=>1),'','',3);
	

	
//获取拼团活动数据
	
$ObjGrouponList = $GrouponActivityModel->query("SELECT g.id as gid, g.price,  g.status, g.activity_status, g.type, g.banner, g.num, p.id, p.product_name, p.image , p.selling_price, p.sell_number, p.product_sketch, p.image_main FROM `groupon_activity` AS g LEFT JOIN product AS p on p.`id` = g.`product_id` WHERE 1=1 AND g.status =1 AND g.type =1 AND g.activity_status !=0 ORDER BY g.sorting DESC,g.create_date DESC ",false,true,$page);

	
//获取分类拼团活动数据
	
$ObjProductList = $GrouponActivityModel->query("SELECT g.id as gid, g.price,  g.status, g.activity_status, g.type, g.banner, g.num, p.id, p.product_name, p.image , p.selling_price, p.sell_number, p.product_sketch, p.image_main, p.image_small FROM `groupon_activity` AS g LEFT JOIN product AS p on p.`id` = g.`product_id` WHERE 1=1 AND g.status =1 AND g.type =1 AND g.activity_status !=0 AND p.product_type_id ='".$typeId."' ORDER BY g.sorting DESC,g.create_date DESC ",false,true,$page,20);


	$Data = array(
			'image'   =>$objBannerImages,
	        'groupon' =>$ObjGrouponList,
	        'product' =>$ObjProductList
	);	


	echo	get_json_data_public( 1,'获取成功',$Data );

	?>
