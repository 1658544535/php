<?php
if ( !defined('HN1') ) die("no permission");


class user_collectBean
{
	function search($db,$page,$per,$status=0,$type=-1,$userid=0,$condition='',$keys='')
	{
		$sql = "select * from ".USER_COLLECT_TABLE." where id>0";
		if($status>-1){
			$sql.=" and status ='".$status."'";
		}
		if($type>-1){
			$sql.=" and type ='".$type."'";
		}
		if($userid>0){
			$sql.=" and userid ='".$userid."'";
		}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".USER_COLLECT_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_userid($db,$userid){
		$sql = "select * from ".USER_COLLECT_TABLE." where user_id='".$userid."' GROUP BY `product_id` order by id desc";
// 		echo $sql;
		return $db->get_results($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".USER_COLLECT_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function detail_fav($db,$userid,$product_id)
	{
		$sql = "select count(*) from ".USER_COLLECT_TABLE." where user_id ='".$userid."' and   product_id ='".$product_id."'";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$user_id,$product_id)
	{
		$db->query("DELETE FROM ".USER_COLLECT_TABLE . " WHERE `user_id`={$user_id} AND `product_id`= {$product_id}" );
		//$db->query("delete from ".USER_COLLECT_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($userid,$product_id,$db)
	{
		$db->query("insert into ".USER_COLLECT_TABLE." (create_date,user_id,product_id) values ('".date('Y-m-d H:i',time())."','".$userid."','".$product_id."')");
		return true;
	}

	function update($status=-1,$type=-1,$userid=-1,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($type>0){
			$update_values.="type='".$type."',";
		}
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		$db->query("update ".USER_COLLECT_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".USER_COLLECT_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}


	// 功能：获取指定用户的收藏数
	function get_shop_count($db,$user_id)
	{
		$sql = "SELECT * FROM " . USER_COLLECT_TABLE . " WHERE `user_id`=" . $user_id . " GROUP BY `product_id`";
		return count($db->get_results($sql));
	}

	/**
	 * 功能：当微信临时用户绑定后把数据对应到正式用户
	 * 参数：
	 * $db：数据库链接
	 * $now_uid：正式用户id
	 * $temp_ui：微信临时用户id
	 */
	function update_product_info($db,$now_uid,$temp_uid)
	{
		$db->query("UPDATE ".USER_COLLECT_TABLE." SET user_id='".$now_uid."' WHERE user_id='".$temp_uid."'");
		return true;
	}

	/*
	 * 功能：查看是否已收藏
	 * */
	function is_fav($db,$userid,$product_id)
	{
		$sql = "SELECT count(*) FROM ".USER_COLLECT_TABLE." WHERE `user_id` ={$userid} AND `product_id` ={$product_id}";
		return $db->get_var($sql);
	}
}
?>
