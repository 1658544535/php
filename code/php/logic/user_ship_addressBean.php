<?php
if ( !defined('HN1') ) die("no permission");


class user_ship_addressBean
{
	function search($db,$page,$per,$userid=0,$status=0,$condition='',$keys='',$name='')
	{
		$sql = "select * from ".USER_SHIP_ADDRESS_TABLE." where id>0";
		if($userid>0){
			$sql.=" and userid ='".$userid."'";
		}
		if($status>-1){
			$sql.=" and status ='".$status."'";
		}
		if($name!=''){
			$users = $db->get_col("select id from user where name like '%".$name."%'");
			$id_str = implode(",",$users);
			$sql .= " and userid in(".$id_str.")";
		}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".USER_SHIP_ADDRESS_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_userid($db,$userid){
		$sql = "select * from ".USER_SHIP_ADDRESS_TABLE." where userid='".$userid."' order by id desc";
		return $db->get_results($sql);
	}

	function get_last_address($db,$userid){
		$sql = "select * from ".USER_SHIP_ADDRESS_TABLE." where userid='".$userid."' order by id desc limit 0,1";
		return $db->get_row($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".USER_SHIP_ADDRESS_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_address($db,$userid,$address){
		$sql = "select * from ".USER_SHIP_ADDRESS_TABLE." where userid='".$userid."' and address='".$address."'";
		return $db->get_row($sql);
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".USER_SHIP_ADDRESS_TABLE." where id in (".implode(",",$id).")");
		return true;
	}
		function deletedate_user($db,$id,$userid)
	{
	//echo  "delete from ".USER_SHIP_ADDRESS_TABLE." where id in (".implode(",",$id).") and userid=".$userid;
		$db->query("delete from ".USER_SHIP_ADDRESS_TABLE." where id in (".implode(",",$id).") and userid=".$userid);
		return true;
	}

	function create($userid,$status,$chick,$city,$area,$address,$shipping_firstname,$telephone,$db)
	{
		//echo  "insert into ".USER_SHIP_ADDRESS_TABLE." (userid,status,chick,city,area,address,shipping_firstname,telephone) values ('".$userid."','".$status."','".$chick."','".$city."','".$area."','".$address."','".$shipping_firstname."','".$telephone."')";
		$db->query("insert into ".USER_SHIP_ADDRESS_TABLE." (userid,status,chick,city,area,address,shipping_firstname,telephone) values ('".$userid."','".$status."','".$chick."','".$city."','".$area."','".$address."','".$shipping_firstname."','".$telephone."')");
		return true;
	}

	function update($userid=-1,$status=-1,$chick=-1,$city=null,$area=null,$address=null,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($chick>0){
			$update_values.="chick='".$chick."',";
		}
		if($city!=null){
			$update_values.="city='".$city."',";
		}
		if($area!=null){
			$update_values.="area='".$area."',";
		}
		if($address!=null){
			$update_values.="address='".$address."',";
		}
		$db->query("update ".USER_SHIP_ADDRESS_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".USER_SHIP_ADDRESS_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
