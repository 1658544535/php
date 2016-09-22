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





/*----------------------------------------------------------------------------------------------------
	-- 获取首页的信息
-----------------------------------------------------------------------------------------------------*/



// 获取轮播图数据

   $objBannerImages  = $FocusSettingModel->getAll(array('status'=>1));
  
  
// 获取首页品类推荐栏数据

   $objProductType=$ProductTypeModel->getAll(array('pid'=>0,'top_level'=>-7,'status'=>1));

// 获取热门品牌数据

   $objBrandDic = $BrandDicModel->query("SELECT b.id,b.status,b.logo,b.brand,h.brand_id FROM hot_brand_recommend AS h left join user_brand AS u on h.brand_id = u.id left join brand_dic as b on u.brand_id = b.id where 1=1 and u.status =1  ORDER BY h.sorting DESC,h.create_date DESC  limit 0,6 ",false, false);

// 获取每日上新&销量排行数据
// $type   = $_REQUEST['type'] == null ? '' : $_REQUEST['type'];

// $PrList =  $ProductRecommendModel ->getAll(array('type'=>$type));
// foreach ($PrList as $pro ) 
// {
// 	$objProduct  = $ProductModel->gets(array('id'=>$pro->product_id), '', array('id'=>asc),$page, $perpage = 20);
// }


include "tpl/index.php";
?>