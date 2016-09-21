<?php
if ( !defined('HN1') ) die("no permission");

class product_typeBean
{
	function search($db,$page,$per,$pid)
	{
		$sql = "select * from ".PRODUCT_TYPE_TABLE." where pid=0 ";
		$sql.=" order by sorting asc,id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function searchs($db,$page,$per,$type)
	{
		$sql = "select * from ".PRODUCT_TYPE_TABLE." where pid>0 and status=1";
    	if($type>0){
			$sql.=" and pid = '".$type."'";
		}
		$sql.=" order by sorting asc";

		return $db->get_results($sql);
	}

	/*
	 * 	功能：根据age_type的值查找分类
	 * */
	function searchs_from_age_type($db,$page,$per,$type)
	{
		$sql = "SELECT * FROM ".PRODUCT_TYPE_TABLE." WHERE `age_type`='". $type ."' AND `status`=1 ORDER BY `sorting` ASC";
		return $db->get_results($sql);
	}


	function get_results($db,$keys)
	{
		$sql = "select * from ".PRODUCT_TYPE_TABLE;
		if($keys >= -1){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by sorting asc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_son_number($db,$id){
		$sql = "select count(id) from ".PRODUCT_TYPE_TABLE." where classid='".$id."'";
		return $db->get_var($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".PRODUCT_TYPE_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
	$db->query("delete from ".PRODUCT_TYPE_TABLE." where id in (".implode(",",$id).")");
	return true;
	}

	function create($classid,$name,$num,$sorting,$db)
	{
		$db->query("insert into ".PRODUCT_TYPE_TABLE." (classid,name,num,sorting) values ('".$classid."','".$name."','".$num."','".$sorting."')");
		return true;
	}

	function update($classid=-1,$name=null,$num=-1,$sorting=-1,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($classid>0){
			$update_values.="classid='".$classid."',";
		}
		if($name!=null){
			$update_values.="name='".$name."',";
		}
		if($num>0){
			$update_values.="num='".$num."',";
		}
		if($sorting>0){
			$update_values.="sorting='".$sorting."',";
		}
		$db->query("update ".PRODUCT_TYPE_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".PRODUCT_TYPE_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

	function get_lists($db)
	{
		$sql = "SELECT `id`,`name` FROM ".PRODUCT_TYPE_TABLE." WHERE `pid`=0 ORDER BY `sorting` DESC,`id` desc";
		return $db->get_results($sql);
	}
}
?>
