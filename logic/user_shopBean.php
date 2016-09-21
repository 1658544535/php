<?php
if ( !defined('HN1') ) die("no permission");


class user_shopBean
{
//	function search($db,$page,$per,$type=0)
//	{
//		$sql = "select * from ".USER_SHOP_TABLE." where id>0 and `status`=1";
//
//		if($type>0){
//			$sql.=" and main_category like '%".$type."%'";
//		}
//		$sql.=" order by id desc limit 12";
//
//		return $db->get_results($sql);
//	}

	function search($db,$type=0)
	{
		$sql = "select * from ".USER_SHOP_TABLE." where id>0 and `status`=1";

		if($type>0){
			$sql.=" and main_category like '%".$type."%'";
		}
		$sql.=" order by id desc";

		return $db->get_results($sql);
	}

	function searchshop($db,$page,$per,$type=0)
	{
		$sql = "select * from ".USER_SHOP_TABLE." where id>0 and is_new='1' and `status`=1";

			if($type>0){
				$sql.=" and main_category like '%".$type."%'";
			}
		$sql.=" order by sorting desc ";

		return $db->get_results($sql);

	}

	function searchs($db,$page,$per,$type=0)
	{
		$sql = "select * from ".USER_SHOP_TABLE." where id>0 and `status`=1";
		if($type>0)
		{
			$sql.=" and main_category like '%".$type."%'";
		}
		$sql.=" order by id desc";

		$pager = get_pager_data($db, $sql, $page,$per);

		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".USER_SHOP_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_order($db,$order_id){
		$sql = "select * from ".USER_SHOP_TABLE." where order_id='".$order_id."'";
		return $db->get_results($sql);
	}


	/*
	 * 根据user_id获取店铺信息(之前)
	 * */
	function detail($db,$id)
	{
		$sql = "select `id`,`name`,`images`,`product_commt`,`deliver_commt`,`logistics_commt` from ".USER_SHOP_TABLE." where user_id = '".$id."'";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_id($db,$id)
	{
		$sql = "select * from ".USER_SHOP_TABLE." where id = '".$id."'";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_product($db,$order_id,$product_id){
		$sql = "select * from ".USER_SHOP_TABLE." where order_id='".$order_id."' and product_id='".$product_id."'";
		//echo $sql;
		return $db->get_row($sql);
	}

	function get_count_time($db,$product_id,$start_time,$end_time){
		$sql = "select sum(shopping_number) from ".CART_TABLE." where product_id='".$product_id."' addTime>='".$start_time."' and addTime<='".$end_time."'";
		return $db->get_var($sql);
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".USER_SHOP_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($userid,$product_id,$product_name,$product_model,$product_price,$product_price_old,$product_image,$order_id,$shopping_number,$shopping_size,$shopping_colorid,$integral,$paying_status,$product_type,$type,$promotions_content,$addTime,$db)
	{
		$db->query("insert into ".USER_SHOP_TABLE." (userid,product_id,product_name,product_model,product_price,product_price_old,product_image,order_id,shopping_number,shopping_size,shopping_colorid,integral,paying_status,product_type,type,promotions_content,addTime) values ('".$userid."','".$product_id."','".$product_name."','".$product_model."','".$product_price."','".$product_price_old."','".$product_image."','".$order_id."','".$shopping_number."','".$shopping_size."','".$shopping_colorid."','".$integral."','".$paying_status."','".$product_type."','".$type."','".$promotions_content."','".$addTime."')");
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
		$db->query("update ".USER_SHOP_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".USER_SHOP_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

	function update_paying_status($db,$status,$cart_id){
		$sql = "update ".USER_SHOP_TABLE." set paying_status='".$status."' where id='".$cart_id."'";
		$db->query($sql);
		return true;
	}


	// 功能：通过商品id获取店铺信息
	function get_shop_id($db,$product_id)
	{
		$sql = "SELECT DISTINCT `id`,`name` FROM " . USER_SHOP_TABLE . " WHERE `user_id`=(SELECT `user_id` FROM " . PRODUCT_TABLE . " WHERE `id`={$product_id})";
		return $db->get_row($sql);
	}

	// 功能：根据搜索查找相应的店铺
	function search_list($db,$key)
	{
		$sql = "SELECT * FROM `".USER_SHOP_TABLE."` WHERE `status`=1 AND `name` LIKE '%". $key ."%'";
		return $db->get_results($sql);
	}

	/**
	 * 根据用户id获取店铺id
	 *
	 * @param object $db 数据库句柄
	 * @param integer|array $uid 用户id
	 * @return array(userid=>shop)
	 */
	public function getShopsByUserid($db, $uid){
		$list = array();
		!is_array($uid) && $uid = array($uid);
		$sql = 'SELECT * FROM `'.USER_SHOP_TABLE.'` WHERE `user_id` IN ('.implode(',', $uid).')';
		$rs = $db->get_results($sql);
		foreach($rs as $v){
			$list[$v->user_id] = $v;
		}
		return $list;
	}
}
?>
