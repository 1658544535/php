<?php
if ( !defined('HN1') ) die("no permission");


class user_cartBean
{
	function search($db,$page,$per,$username='',$type=0,$condition='',$keys='',$product_id=0)
	{
		$sql = "select * from ".USER_CART_TABLE." where id>0";
			if($username!=''){
				$userid = $db->get_var("select id from user where name='".$username."'");
				if($userid != null){
					$sql.=" and userid ='".$userid."'";
				}
			}
			if($type>-1){
				$sql.=" and type ='".$type."'";
			}
			if($product_id>-1){
				$sql.=" and product_id ='".$product_id."'";
			}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".USER_CART_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_userid($db,$userid){
		$sql = "select * from ".USER_CART_TABLE." where user_id='".$userid."' order by id desc";
		return $db->get_results($sql);
	}

	function get_result_order($db,$order_id){
		$sql = "select * from ".USER_CART_TABLE." where order_id='".$order_id."'";
		return $db->get_results($sql);
	}

	function get_result_Tmporder_cartInfo($db,$cart_id){
		$sql = "select * from ".USER_CART_TABLE." where id in (".$cart_id.")";
		return $db->get_results($sql);
	}

	// 获取在订单中指定商家所对应的购物车ID
	function detail_cartid_other($db,$id,$shopid)
	{
		$sql = "select id from ".USER_CART_TABLE."  where id in (".implode(",",$id).")   and  shop_id='".$shopid."'  ";
		$obj = $db->get_results($sql);
		return $obj;
	}

	// 查找订单中的产品对应的商家
	function detail_shopid($db,$id)
	{
		$sql = "select shop_id from ".USER_CART_TABLE."  where id in (".implode(",",$id).")   group by shop_id";
		$obj = $db->get_results($sql);
		return $obj;
	}

	function detail($db,$id)
	{
		$sql = "select uc.*,p.`distribution_price`,p.`weight` AS pweight,p.`postage_type` AS p_postage_type from ".USER_CART_TABLE." AS uc LEFT JOIN `product` AS p ON uc.`product_id`=p.`id` where uc.`id`='".$id."'";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function detail_shop($db,$id)
	{
		$sql = "select * from ".USER_CART_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function detail_cartids($db,$cart_ids){
		$sql = "select * from ".USER_CART_TABLE." where id in(".implode(",",$cart_ids).")  ";
		return $db->get_results($sql);
	}

	/*
	 * 	功能： 判断购物车中是否包含指定的记录
	 */
	function detail_user($db,$userid,$product_id,$sku_link_id,$activeId=-1)
	{
		if ( $sku_link_id > 0 )
		{
			$sql = "SELECT * FROM ".USER_CART_TABLE." WHERE `user_id`={$userid} AND `product_id`={$product_id} AND `sku_link_id`=$sku_link_id";
		}
		else
		{
			$sql = "SELECT * FROM ".USER_CART_TABLE." WHERE `user_id`={$userid} AND `product_id`={$product_id}";
		}
		($activeId >= 0) && $sql .= ' AND `activity_id`='.$activeId;
		return $db->get_row($sql);
	}

	/*
	 *	功能：改变指定购物车商品的数量
	 */
	 function chage_num($db, $userid, $cartid, $num, $time)
	 {
	 	$db->query("UPDATE ".USER_CART_TABLE." SET `num`=". $num .", `update_date`='".$time."'  WHERE `id`='".$cartid."' AND `user_id`='".$userid."'");
		return true;
	 }

	function get_count_time($db,$product_id,$start_time,$end_time){
		$sql = "select sum(shopping_number) from ".USER_CART_TABLE." where product_id='".$product_id."' and addTime>='".$start_time."' and addTime<='".$end_time."'";
		return $db->get_var($sql);
	}

	function deletedate($db,$cart_id,$uid)
	{
		$db->query("DELETE FROM ".USER_CART_TABLE." WHERE `id`='".$cart_id."' AND `user_id`='".$uid."'");
		return true;
	}

	function create($db,$objParam)
	{
		$strSQL  = "INSERT INTO ".USER_CART_TABLE." (
					`user_id`,
					`shop_id`,
					`product_id`,
					`product_name`,
					`product_image`,
					`stock_price`,
					`num`,
					`channel`,
					`create_date`,
					`update_date`,
					`postage_type`,
					`weight`,
					`sku_link_id`
				) values (
					{$objParam->user_id},
					{$objParam->shop_id},
					{$objParam->product_id},
					'{$objParam->product_name}',
					'{$objParam->product_image}',
					'{$objParam->stock_price}',
					{$objParam->num},
					'{$objParam->channel}',
					'{$objParam->create_date}',
					'{$objParam->update_date}',
					'{$objParam->postage_type}',
					'{$objParam->weight}',
					IF( $objParam->sku_link_id>0,$objParam->sku_link_id,null)
				)";
		$db->query($strSQL);
		return $db->insert_id;
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
		$db->query("update ".USER_CART_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".USER_CART_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

	function update_orderid($db,$order_id,$card_ids){

		$sql = "update ".USER_CART_TABLE." set order_id='".$order_id."' where id in(".$card_ids.")";
//echo $sql;
		$db->query($sql);
		return true;
	}

	function update_shopping_number($db,$id,$shopping_number){
		$sql = "update ".USER_CART_TABLE." set num='".$shopping_number."' where id='".$id."'";
		$db->query($sql);
		return true;
	}

	function update_temp_carts($db,$temp_userid,$userid){
		$sql = "update ".USER_CART_TABLE." set userid='".$userid."' where userid='".$temp_userid."'";
		$db->query($sql);
		return true;
	}


	function get_mx_product($db,$uid,$product_id){//feng add
		$sql = "select count(*) from cart2 where product_id='".$product_id."' and addTime>='".(time()-60*60*12)."' and addTime<='".(time()+60*60*12)."' and userid=".$uid;
		return $db->get_var($sql);
	}

	function update_product_price($db,$product_id,$price,$price_first,$price_old,$price_old_first){
		$sql = "update ".USER_CART_TABLE." set product_price='".$price."',product_price_old='".$price_old."' where product_id='".$product_id."' and product_price='".$price_first."' and product_price_old='".$price_old_first."'";
		$db->query($sql);
		return true;
	}


	// 获取用户选定的购物车产品的信息
	function get_order_list( $db, $cart_id,$uid )
	{
		$sql = "SELECT uc.`id`,uc.`stock_price`,uc.`num`,uc.`product_id`,uc.`product_name`,p.`image`,p.`distribution_price`,uc.`sku_link_id` FROM " . USER_CART_TABLE . " as uc,`product` as p WHERE uc.`product_id`=p.`id` AND uc.`id`=". $cart_id. " AND uc.user_id=".$uid;
		return $db->get_results($sql);
	}

	// 当购物车数量修改时，修改数据库的值
	function change_order_num( $db,$product_num, $now_price, $cardid  )
	{
		$db->query( $sql = "UPDATE `user_cart` SET `num`= '".$product_num."',`stock_price`='".$now_price."' WHERE `id`=". $cardid );
		return true;
	}


	//获取用户购物车中商品对应的店铺信息
	function get_user_cart_shop($db,$userid)
	{
		$sql = "SELECT DISTINCT `shop_id` FROM ". USER_CART_TABLE ." where user_id=". $userid;
		return $db->get_results($sql);
	}

	// 根据用户名和店铺号搜索相应的信息
	function get_cart_info($db,$userid,$shopid){
//		$sql = "SELECT * FROM ".USER_CART_TABLE." WHERE `user_id`='".$userid."' AND `shop_id`='".$shopid."' ORDER BY `id` DESC";
		$sql = 'SELECT uc.*,p.`distribution_price` FROM `'.USER_CART_TABLE."` AS uc LEFT JOIN `".PRODUCT_TABLE."` AS p ON uc.`product_id`=p.`id` WHERE uc.`user_id`='".$userid."' AND uc.`shop_id`='".$shopid."' ORDER BY uc.`id` DESC";
		return $db->get_results($sql);
	}

	/**
	 * 获取用户购物车中的商品
	 *
	 * @param object $db
	 * @param integer $userid 用户id
	 * @return array
	 */
	public function getUserCartProduct($db, $userid){
		$sql = 'SELECT uc.*,p.`distribution_price` FROM `'.USER_CART_TABLE."` AS uc LEFT JOIN `".PRODUCT_TABLE."` AS p ON uc.`product_id`=p.`id` WHERE uc.`user_id`='".$userid."' ORDER BY uc.`update_date` DESC";
		return $db->get_results($sql);
	}

	/**
	 * 获取用户购物车中商品数量
	 *
	 * @param object $db
	 * @param integer $uid 用户id
	 * @param integer $type 相应类型的获取，1按商品数量，2按商品种类
	 * @return integer
	 */
	public function getProductCount($db, $uid, $type=1){
		$count = 0;
		if(!empty($uid)){
			switch($type){
				case 1:
					break;
					$sql = 'SELECT SUM(`num`) AS ptotal FROM `user_cart` WHERE `user_id`='.$uid;
				case 2:
					$sql = 'SELECT COUNT(*) AS ptotal FROM `user_cart` WHERE `user_id`='.$uid;
					break;
			}
			$rs = $db->get_row($sql);
			$count = $rs->ptotal;
		}
		return $count;
	}
}
?>
