<?php
if ( !defined('HN1') ) die("no permission");

class sys_areaBean
{
	function search($db,$page,$per,$userid=0,$type=0,$condition='',$keys='')
	{
		$sql = "select * from ".SYS_AREA_TABLE." where id>0";
			if($userid>0){
				$sql.=" and userid ='".$userid."'";
			}
			if($type>0){
				$sql.=" and type ='".$type."'";
			}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".SYS_AREA_TABLE;
		if($keys!=''){
			$sql.=" where pid='".$keys."' ";
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_order($db,$order_id){
		$sql = "select * from ".SYS_AREA_TABLE." where order_id='".$order_id."'";
		return $db->get_results($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".SYS_AREA_TABLE." where user_id = '".$id."'";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function detail_id($db,$id)
	{
		$sql = "select * from ".SYS_AREA_TABLE." where id = '".$id."'";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_product($db,$order_id,$product_id){
		$sql = "select * from ".SYS_AREA_TABLE." where order_id='".$order_id."' and product_id='".$product_id."'";
		//echo $sql;
		return $db->get_row($sql);
	}

	function get_count_time($db,$product_id,$start_time,$end_time){
		$sql = "select sum(shopping_number) from ".CART_TABLE." where product_id='".$product_id."' addTime>='".$start_time."' and addTime<='".$end_time."'";
		return $db->get_var($sql);
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".SYS_AREA_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($userid,$product_id,$product_name,$product_model,$product_price,$product_price_old,$product_image,$order_id,$shopping_number,$shopping_size,$shopping_colorid,$integral,$paying_status,$product_type,$type,$promotions_content,$addTime,$db)
	{
		$db->query("insert into ".SYS_AREA_TABLE." (userid,product_id,product_name,product_model,product_price,product_price_old,product_image,order_id,shopping_number,shopping_size,shopping_colorid,integral,paying_status,product_type,type,promotions_content,addTime) values ('".$userid."','".$product_id."','".$product_name."','".$product_model."','".$product_price."','".$product_price_old."','".$product_image."','".$order_id."','".$shopping_number."','".$shopping_size."','".$shopping_colorid."','".$integral."','".$paying_status."','".$product_type."','".$type."','".$promotions_content."','".$addTime."')");
		return true;
	}

	function update($userid=-1,$product_id=-1,$product_name=null,$product_model=null,$product_price=null,$product_price_old=null,$product_image=null,$order_id=null,$shopping_number=-1,$shopping_size=null,$shopping_colorid=-1,$integral=-1,$paying_status=-1,$product_type=-1,$type=-1,$promotions_content=null,$addTime=null,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($product_id>0){
			$update_values.="product_id='".$product_id."',";
		}
		if($product_name!=null){
			$update_values.="product_name='".$product_name."',";
		}
		if($product_model!=null){
			$update_values.="product_model='".$product_model."',";
		}
		if($product_price!=null){
			$update_values.="product_price='".$product_price."',";
		}
		if($product_price_old!=null){
			$update_values.="product_price_old='".$product_price_old."',";
		}
		if($product_image!=null){
			$update_values.="product_image='".$product_image."',";
		}
		if($order_id!=null){
			$update_values.="order_id='".$order_id."',";
		}
		if($shopping_number>0){
			$update_values.="shopping_number='".$shopping_number."',";
		}
		if($shopping_size!=null){
			$update_values.="shopping_size='".$shopping_size."',";
		}
		if($shopping_colorid>0){
			$update_values.="shopping_colorid='".$shopping_colorid."',";
		}
		if($integral>0){
			$update_values.="integral='".$integral."',";
		}
		if($paying_status>0){
			$update_values.="paying_status='".$paying_status."',";
		}
		if($product_type>0){
			$update_values.="product_type='".$product_type."',";
		}
		if($type>0){
			$update_values.="type='".$type."',";
		}
		if($promotions_content!=null){
			$update_values.="promotions_content='".$promotions_content."',";
		}
		if($addTime!=null){
			$update_values.="addTime='".$addTime."',";
		}
		$db->query("update ".SYS_AREA_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".SYS_AREA_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

	function update_paying_status($db,$status,$cart_id){
		$sql = "update ".SYS_AREA_TABLE." set paying_status='".$status."' where id='".$cart_id."'";
		$db->query($sql);
		return true;
	}

	/*
	 * 	功能： 通过省份id获取省份名称
	 * */
	function get_area_name($db,$id)
	{
		return $db->get_var("select name from sys_area  where id = '" . $id . "' ");
	}

	/**
	 * 根据id获取地区信息
	 *
	 * @param object $db 数据库句柄
	 * @param integer|array $ids 地区id
	 * @return array
	 */
	public function get_by_ids($db, $ids){
		$list = array();
		if($ids){
			!is_array($ids) && $ids = array($ids);
			$sql = 'SELECT * FROM `'.SYS_AREA_TABLE.'` WHERE `id` IN ('.implode(',', $ids).')';
			$list = $db->get_results($sql);
		}
		return $list;
	}
}
?>
