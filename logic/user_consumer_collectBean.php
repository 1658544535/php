<?php
if ( !defined('HN1') ) die("no permission");


class user_consumer_collectBean
{
	function search($db,$page,$per,$status=0,$type=-1,$userid=0,$condition='',$keys='')
	{
		$sql = "select * from ".USER_CONSUMER_COLLECT_TABLE." where id>0";
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
		$sql = "select * from ".USER_CONSUMER_COLLECT_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_userid($db,$userid){
		$sql = "select * from ".USER_CONSUMER_COLLECT_TABLE." where user_id='".$userid."' order by id desc";
// 		echo $sql;
		return $db->get_results($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".USER_CONSUMER_COLLECT_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function detail_fav($db,$userid,$product_id)
	{
		$sql = "select * from ".USER_CONSUMER_COLLECT_TABLE." where user_id ='".$userid."' and   product_id ='".$product_id."'";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".USER_CONSUMER_COLLECT_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($userid,$product_id,$suser_id,$db)
	{

		$db->query("insert into ".USER_CONSUMER_COLLECT_TABLE." (create_date,user_id,product_id,suser_id) values ('".date('Y-m-d H:i',time())."','".$userid."','".$product_id."','".$suser_id."')");

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
		$db->query("update ".USER_CONSUMER_COLLECT_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".USER_CONSUMER_COLLECT_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

	// 查看分销平台上的商品店铺种类
	function get_collect_shop( $db,$userid )
	{
		$sql = "SELECT DISTINCT `suser_id` FROM ".USER_CONSUMER_COLLECT_TABLE." WHERE `user_id`='". $userid ."'";
		return $list = $db->get_results($sql);
	}

	function get_collect_list( $db, $userid, $suser_id )
	{
		$sql = "SELECT * FROM ".USER_CONSUMER_COLLECT_TABLE." WHERE `user_id`='". $userid ."' AND `suser_id`='".$suser_id."'";
		return $list = $db->get_results($sql);
	}

	// 功能：获取指定用户的分销数量
	function get_shop_count($db,$user_id)
	{
		$sql = "SELECT count(*) as nums FROM " . USER_CONSUMER_COLLECT_TABLE . " WHERE `user_id`=" . $user_id;
		return $db->get_row($sql)->nums;
	}
}
?>
