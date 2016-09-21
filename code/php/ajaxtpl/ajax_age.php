<?php
define('HN1', true);
require_once('../global.php');

/*----------------------------------------------------------------------------------------------------
	-- 配置
-----------------------------------------------------------------------------------------------------*/
$act = isset( $_REQUEST['act'] ) ? $_REQUEST['act'] : "";
$id = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : "";
$ProductTypeModel          = M('product_type');
$UserMakerBrandModel       = M('user_maker_brand');
$AgeSkillLinkModel         = M('age_skill_link');
$SysDictModel              = M('sys_dict');
$CategorySettingModel       = M('category_setting');
$CategoryDetailsettingModel = M('category_detail_setting');

switch($act)
{

	case 'age':
		$ageList = $CategorySettingModel->getAll(array('type'=>2));
	
		$TypeList = $CategoryDetailsettingModel ->query("SELECT p.`id`, p.`status`,  p.`name`,p.`image`,  c2.`type_id`,c2.`category_id`,c1.`id`  FROM  category_setting AS c1 LEFT JOIN  category_detail_setting AS c2 on c1.`id` = c2.`category_id`  LEFT JOIN product_type AS p on p.`id` = c2.`type_id`  WHERE 1=1 AND  p.`status` = 1 and c2.`category_id`='".$id."' and p.`visable`=1 ORDER BY c1.`sorting` DESC,c1.`create_date` DESC ",false, false);

		include "tpl/age.php";
		
		break;

}


?>

                <ul>
                    <?php foreach ($TypeList as $type) {?>
                        <li><a href="/product?act=lists&type=3&pid=<?php echo $type->type_id; ?>"><img src="<?php echo $site_image?>productType/<?php echo $type->image ;?>" onerror="this.onerror=null;this.src='http://weixinstorenew/res/images/default_big.png'"/><p><?php echo $type->name ;?></p></a></li>
                    <?php }?>
                </ul>
