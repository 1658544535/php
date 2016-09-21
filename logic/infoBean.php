<?php
if ( !defined('HN1') ) die("no permission");

class infoBean
{
	function search($db,$page,$per,$status=0,$type=0)
	{
		$sql = "select * from ".INFO_TABLE." where id>0 and status=1";

			if($type>0){
				$sql.=" and type ='".$type."'";
			}

		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
function searchs($db,$page,$per,$type=0)
	{
		$sql = "select * from ".INFO_TABLE." where id>0 and status='1'";

			if($type>0){
				$sql.=" and type ='".$type."'";
			}
		$sql.=" order by id desc ";

		return $db->get_results($sql);

	}
	function search_list($db,$page,$per)
	{
		$sql = "select * from ".PRODUCT_TABLE." where id>0";
		$sql.=" order by sorting asc,id desc";
		$pager = get_pager_data($db,$sql,$page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".INFO_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by sorting asc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function detail($db,$id)
	{
		$sql = "select * from ".INFO_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".INFO_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($status,$sorting,$type,$title,$content,$hits,$db)
	{
		$db->query("insert into ".INFO_TABLE." (status,sorting,type,title,content,addtime,hits) values ('".$status."','".$sorting."','".$type."','".$title."','".$content."','".time()."','".$hits."')");
		return true;
	}

	function update($status=-1,$sorting=-1,$type=-1,$title=null,$content=null,$hits=-1,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($sorting>0){
			$update_values.="sorting='".$sorting."',";
		}
		if($type>0){
			$update_values.="type='".$type."',";
		}
		if($title!=null){
			$update_values.="title='".$title."',";
		}
		if($content!=null){
			$update_values.="content='".$content."',";
		}
		if($hits>0){
			$update_values.="hits='".$hits."',";
		}
		$db->query("update ".INFO_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".INFO_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
