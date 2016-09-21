<?php
if ( !defined('HN1') ) die("no permission");


class user_connectionBean
{
	function search($db,$page,$per,$userid=0,$type=0,$condition='',$keys='',$name='')
	{
		$sql = "select * from ".USER_CONNECTION_TABLE." where id>0";
		if($userid>0){
			$sql.=" and (userid ='".$userid."' or fuserid='".$userid."')";
		}
		if($type>0){
			$sql.=" and type ='".$type."'";
		}
		if($name != ''){
			$userids = $db->get_col("select id from user where name like '".$name."'");
			$sql .=" and (userid in(".implode($userids).") or fuserid in(".implode($userids)."))";
		}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
	function get_results_fuserid($db,$fuserid){
		$sql = "select * from ".USER_CONNECTION_TABLE." where fuserid='".$fuserid."'";
		return $db->get_results($sql);
	}
	function get_results($db,$keys)
	{
		$sql = "select * from ".USER_CONNECTION_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_user_connection($db,$userid){
		$sql = "select fuserid userid from ".USER_CONNECTION_TABLE." where userid='".$userid."'";
		$sql .= " union ";
		$sql .= " select userid from ".USER_CONNECTION_TABLE." where fuserid='".$userid."'";
	//	echo $sql;
		return $db->get_col($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".USER_CONNECTION_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_userid($db,$userid){
		$sql = "select * from ".USER_CONNECTION_TABLE." where userid='".$userid."'";
		return $db->get_row($sql);
	}

	function deletedate($db,$id)
	{
	$db->query("delete from ".USER_CONNECTION_TABLE." where id in (".implode(",",$id).")");
	return true;
	}

	function create($userid,$fuserid,$minfo,$type,$db)
	{
		$db->query("insert into ".USER_CONNECTION_TABLE." (userid,fuserid,minfo,type,addtime) values ('".$userid."','".$fuserid."','".$minfo."','".$type."','".time()."')");
		return true;
	}

	function update($userid=-1,$fuserid=-1,$minfo=null,$type=-1,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($fuserid>0){
			$update_values.="fuserid='".$fuserid."',";
		}
		if($minfo!=null){
			$update_values.="minfo='".$minfo."',";
		}
		if($type>0){
			$update_values.="type='".$type."',";
		}
		$db->query("update ".USER_CONNECTION_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".USER_CONNECTION_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
