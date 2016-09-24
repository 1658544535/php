<?php
define('HN1', true);
require_once('./global.php');

/*----------------------------------------------------------------------------------------------------
	-- 配置
-----------------------------------------------------------------------------------------------------*/
$act = isset( $_REQUEST['act'] ) ? $_REQUEST['act'] : "";
$FocusSettingModel         = M('focus_setting');
$ProductTypeRecommendModel = M('product_type_recommend');
$BrandDicModel             = M('brand_dic');
$ProductTypeModel          = M('product_type'); 
$GrouponFreeCouponModel    = M('groupon_free_coupon');




/*----------------------------------------------------------------------------------------------------
	-- 获取首页的信息
-----------------------------------------------------------------------------------------------------*/




// 获取轮播图数据

   $objBannerImages  = $FocusSettingModel->getAll(array('status'=>1));
  

// 获取首页品类推荐栏数据

   $objProductType   = $ProductTypeModel->getAll(array('pid'=>0,'top_level'=>-7,'status'=>1));

//判断用户免团券是否激活

   $ObjUserCouPon    = $GrouponFreeCouponModel ->get(array('user_id'=>$userid,'status'=>1));
//    $ObjUserCouPon    = $GrouponFreeCouponModel ->getUserCoupon($userid,$ext=array('valid'=>true,'intime'=>false));

include "tpl/index_new.php";
?>