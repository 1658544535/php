<?php
if ( !defined('HN1') ) die("no permission");

class historyBean
{

	/*
	 * 功能：检测该产品当天的浏览记录是否存在
	 * */
	function checkIsHas( $user_id,$type,$bussiness_id,$db )
	{
		$sql = "SELECT count(*) as count FROM `".HISTORY_TABLE."` WHERE `user_id`='".$user_id."' AND `type`='".$type."' AND `business_id`='".$bussiness_id."' AND date_format(`create_date`,'%Y-%m-%d') = CURDATE()";
		$obj = $db->get_row($sql);
		return $obj->count;
	}

	// 插入产品浏览记录
	function add($user_id,$type,$bussiness_id,$db)
	{
		$db->query("INSERT INTO ".HISTORY_TABLE." (`user_id`,`type`,`business_id`,`create_by`,`create_date`,`update_by`,`update_date`) values ('".$user_id."','".$type."','".$bussiness_id."','".$user_id."',NOW(),'".$user_id."',NOW())");
        return true;
	}

	// 更新产品浏览记录
	function update($user_id,$type,$bussiness_id,$db)
	{
		$sql = "UPDATE ".HISTORY_TABLE." SET `update_date`=NOW() WHERE `user_id`={$user_id} AND `type`={$type} AND `business_id`={$bussiness_id} AND date_format(`create_date`,'%Y-%m-%d') = CURDATE()";
		$db->query( $sql );
        return true;
	}

	/*
	 * 获取浏览的商品列表(1周内)
	 * */
	function get_list( $db, $user_id )
	{
		$sql = "SELECT * FROM `".HISTORY_TABLE."` WHERE `user_id`='".$user_id."' AND `type`=1 AND TO_DAYS(NOW()) - TO_DAYS(`create_date`) <= 7 ORDER BY `update_date` DESC";
		return $db->get_results($sql);
	}

	/*
	 * 获取用户的浏览数（一周内）
	 * */
	function history_count( $db, $user_id )
	{
		$sql = "SELECT count(*) FROM `".HISTORY_TABLE."` WHERE `user_id`='".$user_id."' AND `type`=1 AND TO_DAYS(NOW()) - TO_DAYS(`create_date`) <= 7";
		return $db->get_var($sql);
	}

	/*
	 * 功能：清空用户的历史记录
	 * */
	function history_flush( $db, $user_id )
	{
		$sql = "DELETE FROM `".HISTORY_TABLE."` WHERE `user_id`={$user_id}";
		return $db->query($sql);
	}

}
?>
