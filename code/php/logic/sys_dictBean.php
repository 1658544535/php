<?php
if ( !defined('HN1') ) die("no permission");

class sys_dictBean
{
	// 获取品牌名
	function get_logistics($db)
	{
		$sql = "SELECT `name`,`name_en`,'value' FROM ".SYS_DICT_TABLE." WHERE `type`='logistics_type'";
		$list = $db->get_results($sql);
		return $list;
	}

}
?>
