<?php
if ( !defined('HN1') ) die("no permission");

class product_stockBean
{
	function search($db,$page,$per,$status=-1,$condition='',$keys='')
	{
		$sql = "select * from ".PRODUCT_STOCK_TABLE." where product_id>0";
			if($status > -1){
				$sql .= " and status ='".$status."'";
			}
			if($keys != ''){
				$pids = $db->get_col("select product_id from product where name like '%".$keys."%'");
				$sql .= " and product_id in(".implode(',',$pids).")";
			}
		$sql.=" order by sorting asc,id desc";
		$pager = get_pager_data($db,$sql,$page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".PRODUCT_STOCK_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by sorting asc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_product($db,$product_id){
		$sql = "select * from ".PRODUCT_STOCK_TABLE." where product_id='".$product_id."'";

		$sql .= " order by sorting asc,id desc";

		return $db->get_results($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".PRODUCT_STOCK_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".PRODUCT_STOCK_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($product_id,$sorting,$standard,$price,$price_old,$status,$addtime,$db)
	{
		$db->query("insert into ".PRODUCT_STOCK_TABLE." (product_id,sorting,standard,price,price_old,status,addtime) values ('".$product_id."','".$sorting."','".$standard."','".$price."','".$price_old."','".$status."','".$addtime."')");
		return true;
	}

	function update($product_id=0,$sorting=-1,$standard='',$price=-1,$price_old=-1,$status=-1,$db,$id)
	{
		$update_values="";
		if($product_id>0){
			$update_values.="product_id='".$product_id."',";
		}
		if($sorting>-1){
			$update_values.="sorting='".$sorting."',";
		}
		if($standard!=''){
			$update_values.="standard='".$standard."',";
		}
		if($price>-1){
			$update_values.="price='".$price."',";
		}
		if($price_old>-1){
			$update_values.="price_old='".$price_old."',";
		}
		if($status>-1){
			$update_values.="status='".$status."',";
		}
		$db->query("update ".PRODUCT_STOCK_TABLE." set ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".PRODUCT_STOCK_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
