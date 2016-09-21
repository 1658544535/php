<?php
if ( !defined('HN1') ) die("no permission");

class pay_recordsBean
{
	function search($db,$page,$per,$type=0,$userid=0,$status=0,$condition='',$keys='')
	{
		$sql = "select * from ".PAY_RECORDS_TABLE." where id>0";
		if($type>0){
			$sql.=" and type ='".$type."'";
		}
		if($userid>0){
			$sql.=" and userid ='".$userid."'";
		}
		if($status>-1){
			$sql.=" and status ='".$status."'";
		}
		if($condition == "username"){
			$user_id = $db->get_var("select id from user where name='".$keys."'");
			$sql.=" and userid=".$user_id;
		}
		if($condition == "order_num"){
			$sql.=" and order_num=".$keys;
		}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".PAY_RECORDS_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_user($db,$userid){
		$sql = "select * from ".PAY_RECORDS_TABLE." where userid='".$userid."' ";
		$sql .= " order by id desc limit 10";
		return $db->get_results($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".PAY_RECORDS_TABLE." where id = {$id}";

		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_number($db,$id)
	{
	$sql = "select * from ".PAY_RECORDS_TABLE." where order_num ='".$id."'";
//	echo $sql;
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".PAY_RECORDS_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($type,$userid,$order_num,$status,$money,$db)
	{
		$db->query("insert into ".PAY_RECORDS_TABLE." (type,userid,order_num,status,money,addtime) values ('".$type."','".$userid."','".$order_num."','".$status."','".$money."','".time()."')");
		return true;
	}

	function update($type=-1,$userid=-1,$order_num=null,$status=-1,$money=null,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($type>0){
			$update_values.="type='".$type."',";
		}
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($order_num!=null){
			$update_values.="order_num='".$order_num."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($money!=null){
			$update_values.="money='".$money."',";
		}
		$db->query("update ".PAY_RECORDS_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".PAY_RECORDS_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
