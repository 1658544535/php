<?php
if ( !defined('HN1') ) die("no permission");


class user_order_shipBean
{
	/*
	 * 	功能： 获取用户的物流信息
	 * 	参数：
	 * 	$db:数据库对象
	 *  $order_id:订单ID
	 *  $user_id：用户ID
	 * */
	function get_info($db, $order_id, $user_id)
	{
		//$sql = "SELECT * FROM `user_order_ship` WHERE `order_id` ='".$order_id."' and `user_id`='".$user_id."'";
		$sql = "SELECT * FROM `user_order_ship` WHERE `order_id` ='".$order_id."'";
		return $db->get_row($sql);
	}
}
?>
