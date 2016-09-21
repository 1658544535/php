<?php
if ( !defined('HN1') ) die("no permission");


class user_consumerBean
{
	function search($db,$page,$per,$type=0,$status=0)
	{
		$sql = "select * from ".CONSUMER_TABLE." where id > 0 ";
		if($type>0){
			$sql.=" and type = '".$type."'";
		}
		if($status>=0){
			$sql.=" and status = '".$status."'";
		}
		$sql.=" order by sorting asc,id desc";

		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".CONSUMER_TABLE;
		$sql.=" where status=1 and type=6  order by id desc limit 4";

		$list = $db->get_results($sql);
		return $list;
	}

	function get_index_type($db,$type=0,$limit=0)
	{
		$sql = "select * from ".CONSUMER_TABLE." where id > 0 ";
		if($type>0){
			$sql.=" and type = '".$type."' ";
		}
		$sql.=" order by sorting desc,id asc";
		if($limit>0){
			$sql.=" limit ".$limit."";
		}
		$list = $db->get_results($sql);
		return $list;
	}

	function detail($db,$id)
	{
		$sql = "select * from ".CONSUMER_TABLE." where user_id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_focus($db,$id)
	{
		$sql = "select * from ".CONSUMER_TABLE." where type='".$id."' and status='1'";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_focus2($db,$id)
	{
		$sql = "select * from ".CONSUMER_TABLE." where type='".$id."' and status='0' order by sorting desc";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".CONSUMER_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".CONSUMER_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

	function create($user_id,$company,$main_category,$platform,$groups,$sales_area,$contact,$duty,$email,$QQ,$phone,$tel,$fax,$web_site,$address,$db)
	{
$db->query("insert into ".CONSUMER_TABLE." (user_id,contact,tel,phone,fax,address,web_site,QQ,email,company,duty,groups,platform,main_category,sales_area,channel,create_by,create_date) values ('".$user_id."','".$contact."','".$tel."','".$phone."','".$fax."','".$address."','".$web_site."','".$QQ."','".$email."','".$company."','".$duty."','".$groups."','".$platform."','".$main_category."','".$sales_area."','2','".$user_id."','".date('Y-m-d H:i',time())."')");
        return true;
	}

	function update($type,$attestation_image,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "image='".$image."',";
		}

		if($attestation_image!=null){
			$update_values.="attestation_image='".$attestation_image."',";
		}
		if($type!=null){
			$update_values.="type='".$type."',";
		}


		$db->query("update ".CONSUMER_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
}
?>
