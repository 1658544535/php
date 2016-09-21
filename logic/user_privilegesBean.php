<?php
if ( !defined('HN1') ) die("no permission");


class user_privilegesBean
{
	function search($db,$page,$per,$condition='',$keys='')
	{
		$sql = "select * from ".USER_PRIVILEGES_TABLE." where id>0";
			if($condition=='name'){
				$sql.=" and name like '%".$keys."%'";
			}
		$sql.=" order by sorting asc,id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}


	function get_results($db)
	{
		$sql = "select * from ".USER_PRIVILEGES_TABLE;
		$sql.=" order by sorting asc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function detail($db,$id)
	{
		$sql = "select * from ".USER_PRIVILEGES_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".USER_PRIVILEGES_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($name,$sorting,$db)
	{
		$db->query("insert into ".USER_PRIVILEGES_TABLE." (name,sorting) values ('".$name."','".$sorting."')");
		return true;
	}

	function update($name=null,$sorting=-1,$db,$id)
	{
		$update_values="";
		if($name!=null){
			$update_values.="name='".$name."',";
		}
		if($sorting>-1){
			$update_values.="sotring='".$sorting."',";
		}
		$db->query("update ".USER_PRIVILEGES_TABLE." set ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
}
?>
