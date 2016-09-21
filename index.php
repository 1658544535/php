<?php
define('HN1', true);
require_once('./global.php');

/*----------------------------------------------------------------------------------------------------
	-- 配置
-----------------------------------------------------------------------------------------------------*/
$act = isset( $_REQUEST['act'] ) ? $_REQUEST['act'] : "";
// $NavigationModel 	= M('navigation');
// $AdModel 			= M('ad');
// $HomePageIconModel 	= M('home_page_icon');
// $HomepagePushModel 	= M('homepage_push');
// $SpecialModel 	 	= D('Special');
// $ActivityTimeModel 	= M('activity_time');

$FocusSettingModel         = M('focus_setting');
$ProductTypeRecommendModel = M('product_type_recommend');
$BrandDicModel             = M('brand_dic');






/*----------------------------------------------------------------------------------------------------
	-- 获取首页的信息
-----------------------------------------------------------------------------------------------------*/



// 获取轮播图数据

   $objBannerImages  = $FocusSettingModel->query("SELECT  f.`id`, f.`status`, f.`banner`, f.`type`,f.`param_type`, f.`param_id`,f.`activity_id`,e.`link` FROM focus_setting AS f left join external_links AS e on f.param_id = e.id where 1=1 and f.status =1 and f.type =2 AND f.`param_type` IN (1,2,7,8) ORDER BY  f.sorting DESC , f.create_date DESC",false, false);

// 获取首页品类推荐栏数据

   $objProductType=$ProductTypeRecommendModel->query("SELECT  p2.`id`, p2.`status`, p2.`pid`, p2.`name`,p2.`image`,  p1.`product_type_id` FROM product_type_recommend AS p1 left join product_type AS p2 on p1.product_type_id = p2.id where 1=1 and p2.status =1 ORDER BY  p1.sorting DESC , p1.create_date DESC  limit 0,7 ",false, false);

// 获取热门品牌数据

   $objBrandDic = $BrandDicModel->query("SELECT b.id,b.status,b.logo,b.brand,h.brand_id FROM hot_brand_recommend AS h left join user_brand AS u on h.brand_id = u.id left join brand_dic as b on u.brand_id = b.id where 1=1 and u.status =1  ORDER BY h.sorting DESC,h.create_date DESC  limit 0,6 ",false, false);

// 获取每日上新&销量排行数据
// $type   = $_REQUEST['type'] == null ? '' : $_REQUEST['type'];

// $PrList =  $ProductRecommendModel ->getAll(array('type'=>$type));
// foreach ($PrList as $pro ) 
// {
// 	$objProduct  = $ProductModel->gets(array('id'=>$pro->product_id), '', array('id'=>asc),$page, $perpage = 20);
// }


include "tpl/index_new.php";
?>