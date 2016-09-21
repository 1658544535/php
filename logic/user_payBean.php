<?php
if ( !defined('HN1') ) die("no permission");


class user_payBean
{
	function search($db,$page,$per,$status=0,$type=-1,$userid=0,$condition='',$keys='',$name='')
	{
		$sql = "select * from ".USER_PAY_TABLE." where id>0";
		if($status>-1){
			$sql.=" and status ='".$status."'";
		}
		if($type>-1){
			$sql.=" and type ='".$type."'";
		}
		if($userid>0){
			$sql.=" and userid ='".$userid."'";
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
		$sql = "select * from ".USER_PAY_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function detail($db,$id)
	{
		$sql = "select * from ".USER_PAY_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".USER_PAY_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($status,$type,$cash_num,$payment,$userid,$card_number,$pay_status,$order_number,$db)
	{
		$db->query("insert into ".USER_PAY_TABLE." (status,type,cash_num,payment,addtime,userid,card_number,pay_status,order_number) values ('".$status."','".$type."','".$cash_num."','".$payment."','".time()."','".$userid."','".$card_number."','".$pay_status."','".$order_number."')");
		return true;
	}

	function update($status=-1,$type=-1,$cash_num=null,$payment=null,$userid=-1,$card_number=null,$pay_status=-1,$order_number=null,$db,$id)
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
		if($cash_num!=null){
			$update_values.="cash_num='".$cash_num."',";
		}
		if($payment!=null){
			$update_values.="payment='".$payment."',";
		}
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($card_number!=null){
			$update_values.="card_number='".$card_number."',";
		}
		if($pay_status>0){
			$update_values.="pay_status='".$pay_status."',";
		}
		if($order_number!=null){
			$update_values.="order_number='".$order_number."',";
		}
		$db->query("update ".USER_PAY_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".USER_PAY_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
