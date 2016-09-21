<?php
if ( !defined('HN1') ) die("no permission");

class product_imagesBean
{
	function search($db,$page,$per,$userid='',$status=0,$condition='',$keys='',$name='')
	{
		$sql = "select * from ".PRODUCT_IMAGES_TABLE." where id>0";
		if($userid!=''){
			$sql.=" and userid like '%".$userid."%'";
		}
		if($status>-1){
			$sql.=" and status ='".$status."'";
		}
		if($name!=''){
			$products = $db->get_col("select product_id from product where name like '%".$name."%'");
			$id_str = implode(",",$products);
			$sql .= " and productId in(".$id_str.")";
		}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".PRODUCT_IMAGES_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_productid($db,$product_id){
		$sql = "select * from ".PRODUCT_IMAGES_TABLE." where product_id='".$product_id."' and status=1 ";

		$sql .= " order by sorting asc";
		return $db->get_results($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".PRODUCT_IMAGES_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".PRODUCT_IMAGES_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($image,$addTime,$productId,$status,$db)
	{
		$db->query("insert into ".PRODUCT_IMAGES_TABLE." (image,addTime,productId,status) values ('".$image."','".$addTime."','".$productId."','".$status."')");
		return true;
	}

	function update($image=null,$addTime=-1,$productId=-1,$status=-1,$db,$id)
	{
		$update_values="";
		if($image!=null){
			$update_values.="image='".$image."',";
		}
		if($addTime>0){
			$update_values.="addTime='".$addTime."',";
		}
		if($productId>0){
			$update_values.="productId='".$productId."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		$db->query("update ".PRODUCT_IMAGES_TABLE." set ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".PRODUCT_IMAGES_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
