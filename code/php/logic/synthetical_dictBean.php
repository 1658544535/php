<?php
if ( !defined('HN1') ) die("no permission");

class synthetical_dictBean
{
	// 获取品牌名
	function get_brand($db,$val)
	{
		$sql = "SELECT `name` FROM ".SYNTHETICAL_DICT_TABLE." WHERE `type`='brand' AND `value`='".$val."'";
		return $db->get_row($sql)->name;

	}

	// 包装方式
	function get_pack($db,$val)
	{
		$sql = "SELECT `name` FROM ".SYNTHETICAL_DICT_TABLE." WHERE `type`='pack' AND `value`='".$val."'";
		$list = $db->get_row($sql)->name;
		return $list;
	}

	// 适用年龄
	function get_age($db,$val)
	{
		$sql = "SELECT `name` FROM ".SYNTHETICAL_DICT_TABLE." WHERE `type`='age' AND `value`='".$val."'";
		$list = $db->get_row($sql)->name;
		return $list;
	}

	// 材质
	function get_texture($db,$val)
	{
		$sql = "SELECT `name` FROM ".SYNTHETICAL_DICT_TABLE." WHERE `type`='texture' AND `value`='".$val."'";
		$list = $db->get_row($sql)->name;
		return $list;
	}


	// 单位
	function get_unit($db,$val)
	{
		$sql = "SELECT `name` FROM ".SYNTHETICAL_DICT_TABLE." WHERE `type`='unit' AND `value`='".$val."'";
		$list = $db->get_row($sql)->name;
		return $list;
	}

}
?>
