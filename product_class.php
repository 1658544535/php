<?php
define('HN1', true);
require_once('./global.php');

/*----------------------------------------------------------------------------------------------------
	-- 配置
-----------------------------------------------------------------------------------------------------*/
$act = isset( $_REQUEST['act'] ) ? $_REQUEST['act'] : "";
$id = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : "";

$ProductTypeModel           = M('product_type');
$AgeSkillLinkModel          = M('age_skill_link');
$CategorySettingModel       = M('category_setting');
$CategoryDetailsettingModel = M('category_detail_setting');
$UserBrandModel             = M('user_brand');
$ActivityGoodsModel         = M('activity_goods');

switch($act)
{
  
  //获取品类分类数据
	case 'type':
  	$ProTypeList = $CategorySettingModel->getAll(array('type'=>1),'',array('sorting'=>'DESC','create_date'=>'DESC'));
  	
  	$TypeList = $CategoryDetailsettingModel ->query("SELECT p.`id`, p.`status`,  p.`name`,p.`image`,  c1.`type_id`,c1.`category_id`,c2.`id`  FROM category_detail_setting AS c1 LEFT JOIN product_type AS p on p.`id` = c1.`type_id` LEFT JOIN category_setting AS c2 on c2.`id` = c1.`category_id`  WHERE  p.`status` = 1 and c1.`category_id`='".$id."' and p.`visable`=1 ORDER BY c1.`id` DESC ",false, false);
  
  	include "tpl/product_type.php";

  	break;

  //获取品牌数据	
   case 'brand':
	
	$BrandList = $UserBrandModel->query("select u.id as id,b.logo as logo,b.brand as brandName,b.id as bid from  user_brand u  left join brand_dic b on b.id = u.brand_id WHERE 1=1 AND u.status = 1 AND  b.status =1 order by b.sorting desc,b.create_date desc",false,false);

  	include "tpl/brand.php";

  	break;

  	//获取年龄分类数据
    case 'age':
	$ageList = $CategorySettingModel->getAll(array('type'=>2),'',array('sorting'=>'DESC','create_date'=>'DESC'));
	$TypeList = $CategoryDetailsettingModel ->query("SELECT p.`id`, p.`status`,  p.`name`,p.`image`,  c1.`type_id`,c1.`category_id`,c2.`id`  FROM category_detail_setting AS c1 LEFT JOIN product_type AS p on p.`id` = c1.`type_id` LEFT JOIN category_setting AS c2 on c2.`id` = c1.`category_id`  WHERE  p.`status` = 1 and c1.`category_id`='".$id."' and p.`visable`=1 ORDER BY c1.`id` ASC ",false, false);
	
	include "tpl/age.php";
	
	break;



}


?>