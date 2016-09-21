<?php
if ( !defined('HN1') ) die("no permission");


class user_order_detailBean
{
	function search($db,$page,$per,$userid=0,$type=0,$condition='',$keys='')
	{
		$sql = "select * from ".USER_ORDER_DETAIL_TABLE." where id>0";
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
		$sql = "select * from ".USER_ORDER_DETAIL_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_order($db,$order_id)
	{
		$sql = "SELECT uod.id as uodid, uod.*, uo.* FROM `user_order_detail` as uod, `user_order` as uo WHERE uod.order_id=uo.id AND  uod.order_id='".$order_id."' ";
		return $db->get_results($sql);
	}


	function detail($db,$id)
	{
		$sql = "select * from ".USER_ORDER_DETAIL_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_product($db,$order_id,$product_id){
		$sql = "select * from ".USER_ORDER_DETAIL_TABLE." where order_id='".$order_id."' and product_id='".$product_id."'";
		//echo $sql;
		return $db->get_row($sql);
	}

	function get_count_time($db,$product_id,$start_time,$end_time){
		$sql = "select sum(shopping_number) from ".CART_TABLE." where product_id='".$product_id."' addTime>='".$start_time."' and addTime<='".$end_time."'";
		return $db->get_var($sql);
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".USER_ORDER_DETAIL_TABLE." where id in (".implode(",",$id).")");
		return true;
	}


	function create($product_img,$userid,$product_id,$obj_productname,$product_model,$price,$shopping_number,$type,$channel,$status,$time,$shopid,$order_id,$loginname,$sku_link_id,$db)
	{
		$sql = "INSERT INTO ".USER_ORDER_DETAIL_TABLE." (
					product_image,
					user_id,
					product_id,
					product_name,
					product_model,
					stock_id,
					stock_price_old,
					stock_price,
					num,
					type,
					channel,
					status,
					create_date,
					shop_id,
					order_id,
					loginname,
					sku_link_id
				) values (
					'".$product_img."',
					'".$userid."',
					'".$product_id."',
					'".$obj_productname."',
					'".$product_model."',
					'0',
					'".$price."',
					'".$price."',
					'".$shopping_number."',
					'".$type."',
					'".$channel."',
					'".$status."',
					'".$time."',
					'".$shopid."',
					'".$order_id."',
					'".$loginname."',
					IF('$sku_link_id','$sku_link_id',null)
				)";

		$db->query($sql);
		$cid = $db->insert_id;
		return $cid;

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
		$db->query("update ".USER_ORDER_DETAIL_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
    function update_status($db,$status,$order_id){
		$sql = "update ".USER_ORDER_DETAIL_TABLE." set return_status='".$status."' where id ='".$order_id."'";
		$db->query($sql);
//		echo $sql;
		return true;
	}
	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".USER_ORDER_DETAIL_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

	function update_paying_status($db,$status,$cart_id){
		$sql = "update ".USER_ORDER_DETAIL_TABLE." set paying_status='".$status."' where id='".$cart_id."'";
		$db->query($sql);
		return true;
	}

	/*
	 * 	功能：获取指定用户的订单详情信息
	 * */
	function get_user_order_detail($db,$order_detail_id,$uid)
	{
		"select * from user_order_detail where id = {$order_detail_id}  AND `user_id`={$uid}";
		return $db->get_row("select * from user_order_detail where id = '".$order_detail_id."'  AND `user_id`='".$uid."' ");
	}


	// 退货申请时，修改数据库
	function refund($db,$oid,$user_id)
	{
		$sql = "UPDATE " . USER_ORDER_DETAIL_TABLE ." SET `re_status`=1,`update_date`='".date('Y-m-d H:i:s')."'  WHERE `id`='".$oid."' AND `user_id`='".$user_id."'";
		$db->query($sql);
		return true;
	}

	// 退货申请成功后，提交物流信息修改数据库
	function refund2($db,$oid,$user_id)
	{
		$sql = "UPDATE " . USER_ORDER_DETAIL_TABLE ." SET `re_status`=3  WHERE `id`='".$oid."' AND `user_id`='".$user_id."' AND `re_status`=2";
		$rs = $db->query($sql);
		return $rs ? true : false;
	}

	// 统计订单允许评论的商品数
	function get_order_allow_comment($db,$order_id,$user_id)
	{
		$sql = "SELECT count(*) as counts FROM `user_order_detail` as uod, `user_order` as uo WHERE uod.order_id=uo.id AND uod.`order_id`='".$order_id."' AND uod.`user_id`='".$user_id."' AND uod.`re_status`=0 AND uo.`order_status`=4";
		return $db->get_row($sql)->counts;
	}

	// 获取订单下的商品列表
	function get_order_product_list( $db, $order_id, $user_id )
	{
		$sql = "SELECT a.*,b.`status` as product_status,b.`ladder_price`,b.`weight`,b.`postage_type` FROM `user_order_detail` as a, `product` as b  WHERE a.`user_id`={$user_id} AND a.`order_id`={$order_id} AND a.`product_id`=b.`id` ORDER BY b.`status` DESC";
		return $db->get_results($sql);
	}

	/*
	 * 功能：获取指定订单中商品列表的有效值（即 user_order_detail.re_status = 0）
	 * */
	function set_order_product_valid( $db, $order_id, $user_id )
	{
		$sql = "SELECT count(*) FROM ".USER_ORDER_DETAIL_TABLE." WHERE `order_id`={$order_id} AND `user_id`={$user_id} AND `re_status`=0";		// 获取订单中有效商品数量的值

		if ( $db->get_var($sql) == 0 )			// 如果订单中没有有效商品，则修改订单 user_order.is_cancel_order = 1
		{
			$sql = "UPDATE `user_order` SET `is_cancel_order`=1 WHERE `id`={$order_id}";
			$db->query($sql);
		}

		return true;
	}
}
?>
