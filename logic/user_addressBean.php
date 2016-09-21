<?php
if ( !defined('HN1') ) die("no permission");


class user_addressBean
{
	function search($db,$page,$per,$userid=0,$status=0,$condition='',$keys='',$name='')
	{
		$sql = "select * from ".USER_ADDRESS_TABLE." where id>0";
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
		$sql = "select * from ".USER_ADDRESS_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_userid($db,$userid){
		$sql = "select * from ".USER_ADDRESS_TABLE." where user_id='".$userid."' order by is_default desc";
		return $db->get_results($sql);
	}

	function get_last_address($db,$userid){
		$sql = "select * from ".USER_ADDRESS_TABLE." where userid='".$userid."' order by id desc limit 0,1";
		return $db->get_row($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".USER_ADDRESS_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_address($db,$userid,$address){

		$sql = "select * from ".USER_ADDRESS_TABLE." where user_id='".$userid."' and address='".$address."'  ";
		//echo $sql;
		return $db->get_row($sql);
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".USER_ADDRESS_TABLE." where id in (".implode(",",$id).")");
		return true;
	}
	function deletedate_user($db,$id,$userid)
	{
		//echo  "delete from ".USER_ADDRESS_TABLE." where id in (".implode(",",$id).") and userid=".$userid;
		$db->query("delete from ".USER_ADDRESS_TABLE." where id='".$id."'  and user_id='".$userid."'");

		return true;
	}

	function create($userid,$status,$chick,$city,$area,$address,$shipping_firstname,$telephone,$postcode,$s_province,$db)
	{
//		echo  "insert into ".USER_ADDRESS_TABLE." (user_id,status,city,area,address,consignee,consignee_phone,create_date,postcode,province) values ('".$userid."','".$status."','".$city."','".$area."','".$address."','".$shipping_firstname."','".$telephone."','".date('Y-m-d h:i',time())."','".$postcode."','".$s_province."')";
		$db->query("insert into ".USER_ADDRESS_TABLE." (user_id,status,city,area,address,consignee,consignee_phone,create_date,postcode,province) values ('".$userid."','".$status."','".$city."','".$area."','".$address."','".$shipping_firstname."','".$telephone."','".date('Y-m-d H:i',time())."','".$postcode."','".$s_province."')");
		return $db->insert_id;
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
		$db->query("update ".USER_ADDRESS_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".USER_ADDRESS_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

	//根据用户ID和指定的地址ID查找相应的信息
	function detail2($db,$id,$userid)
	{
		$sql = "SELECT * FROM ".USER_ADDRESS_TABLE." WHERE `id`={$id} AND `user_id`='".$userid."'";
		$obj = $db->get_row($sql);
		return $obj;
	}

	//根据用户ID和指定的地址ID返回省份ID
	function get_user_province($db,$id,$userid)
	{
		$sql = "SELECT `province` FROM ".USER_ADDRESS_TABLE." WHERE `id`={$id} AND `user_id`='".$userid."'";
		$obj = $db->get_row($sql);
		$rs = ( $db->get_row($sql) == NULL ) ? NULL : $obj->province;
		return $rs;
	}

	// 修改用户地址信息
	function update2( $db,$userid,$address,$consignee,$telephone,$s_province,$s_city,$s_county,$postcode,$address_id )
	{
		$update_values="";

		if($address!=null){
			$update_values.=",address='". $db->escape($address) ."'";
		}

		if($consignee!=null){
			$update_values.=",consignee='".$db->escape($consignee) ."'";
		}

		if($telephone!=null){
			$update_values.=",consignee_phone='".$telephone ."'";
		}

		if($s_province>0){
			$update_values.=",province='".$s_province ."'";
		}

		//if($s_city>0){
			$update_values.=",city='".$s_city ."'";
		//}

		//if($s_county>0){
			$update_values.=",area='".$s_county ."'";
		//}

		if($postcode!=null){
			$update_values.=",postcode='".$postcode ."'";
		}

		//echo "UPDATE ".USER_ADDRESS_TABLE." SET ". substr($update_values,1) ."  WHERE id=".$address_id ." AND `user_id`='".$userid."'";

		$db->query("UPDATE ".USER_ADDRESS_TABLE." SET ". substr($update_values,1) ."  WHERE id=".$address_id ." AND `user_id`='".$userid."'");
		return true;
	}

	/*
	 * 	功能：获取用户的订单默认的地址信息
	 * */
	 function get_order_address($db, $userid)
	 {
	 	$sql = "SELECT * FROM ".USER_ADDRESS_TABLE." WHERE `user_id`='".$userid."' AND `is_default`=1";
		$obj = $db->get_row($sql);

		if ( $obj == null )
		{
			$sql = "SELECT * FROM ".USER_ADDRESS_TABLE." WHERE `user_id`='".$userid."' ORDER BY `id` LIMIT 1";
			$obj = $db->get_row($sql);
		}
		return $obj;
	 }

	 /**
	  * 	功能：设置默认地址操作
	  */
	  function set_defalut($db, $userid, $address_id)
	  {
	  	$db->query("UPDATE ".USER_ADDRESS_TABLE." SET `is_default`=0 WHERE user_id=".$userid); 										// 先将用户全部地址设置为非默认
	  	$db->query("UPDATE ".USER_ADDRESS_TABLE." SET `is_default`=1 WHERE user_id=".$userid ." AND id=" . $address_id); 			// 将用户指定地址设置为默认
	  	return true;
	  }
}
?>
