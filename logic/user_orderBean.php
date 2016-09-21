<?php
if ( !defined('HN1') ) die("no permission");


class user_orderBean
{
	function search($db,$page,$per,$condition,$keys,$starttime=0,$endtime=0,$order_type=0)
	{
		$sql = "select * from ".USER_ORDER_TABLE." where user_del<2";
		if($condition == 'order_number'){
			$sql.=" and order_number=".$keys;
		}
		if($condition == 'phone'){
			$sql.=" and (telephone='".$keys."' or cellphone='".$keys."')";
		}
		if($condition == 'shipping_firstname'){
			$sql.=" and shipping_firstname='".$keys."'";
		}
		if($condition == 'username'){
			$users = $db->get_col("select id from user where name like '%".$keys."%'");
			$id_str = implode(',',$users);
			$sql.=" and customer_id in(".$id_str.")";
		}
		if($starttime>0){
			$sql.=" and addtime>=".$starttime;
		}
		if($endtime>0){
			$sql.=" and addtime<=".$endtime;
		}
		if($order_type>0){
			$sql.=" and user_del=".$order_type;
		}
		$sql.=" order by order_id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
	function search_user_del($db,$page,$per,$condition,$keys,$starttime=0,$endtime=0,$order_type=0)
	{
		$sql = "select * from ".USER_ORDER_TABLE." where user_del=2";
		if($condition == 'order_number'){
			$sql.=" and order_number=".$keys;
		}
		if($condition == 'phone'){
			$sql.=" and (telephone='".$keys."' or cellphone='".$keys."')";
		}
		if($condition == 'shipping_firstname'){
			$sql.=" and shipping_firstname='".$keys."'";
		}
		if($condition == 'username'){
			$users = $db->get_col("select id from user where name like '%".$keys."%'");
			$id_str = implode(',',$users);
			$sql.=" and customer_id in(".$id_str.")";
		}
		if($starttime>0){
			$sql.=" and addtime>=".$starttime;
		}
		if($endtime>0){
			$sql.=" and addtime<=".$endtime;
		}
		$sql.=" order by order_id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
	function get_excel_results($db,$condition,$keys,$starttime=0,$endtime=0){
		$sql = "select a.product_name,a.product_model,a.product_price,b.* from cart2 as a " .
			   "left join ".USER_ORDER_TABLE." as b on a.order_id = b.order_id where b.order_id>0 and b.abolishment_status=0";
		if($condition == 'order_number'){
			$sql.=" and b.order_number=".$keys;
		}
		if($condition == 'phone'){
			$sql.=" and (b.telephone='".$keys."' or b.cellphone='".$keys."')";
		}
		if($condition == 'shipping_firstname'){
			$sql.=" and b.shipping_firstname='".$keys."'";
		}
		if($starttime>0){
			$sql.=" and b.addtime>=".$starttime;
		}
		if($endtime>0){
			$sql.=" and b.addtime<=".$endtime;
		}
		$sql.=" order by b.order_id desc";
		return $db->get_results($sql);
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".USER_ORDER_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by order_id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	//*备份查询6/4
//	function get_results_userid($db,$userid){
//		$sql = "select * from ".USER_ORDER_TABLE." where customer_id='".$userid."' order by order_id desc";
//		return $db->get_results($sql);
//	}
//
	/**
	 * 功能：获取订单信息
	 */
	function get_results_userid($db,$userid,$sid)
	{
		$sql = "SELECT * FROM ".USER_ORDER_TABLE." WHERE `user_id`='".$userid."' and `is_delete_order`=0";

		if( $sid>0)
		{
			$sql.=" and `is_cancel_order`=0 and order_status ='".$sid."'";
		}

        $sql.=" order by create_date desc";
		return $db->get_results($sql);
	}

	function get_results_suserid($db,$userid)
	{
		$sql = "select * from ".USER_ORDER_TABLE." where suser_id='".$userid."'";
		return $db->get_results($sql);
	}

	function get_results_not_comment($db,$userid){
		$sql = "select * from ".USER_ORDER_TABLE."  where user_id='".$userid."'  and  order_status=4  ";

//		$sql .= " and not EXISTS(select 1 from user_comment as b where b.order_id = a.order_id)";
		return $db->get_results($sql);
	}

	function get_results_onway($db,$userid,$os){
		$sql = "select * from ".USER_ORDER_TABLE." where user_id='".$userid."' and order_status='".$os."' and  is_delete_order=0 and  is_cancel_order=0";
//		echo $sql;
		return $db->get_results($sql);
	}
	//查找配送中的订单数量
	function get_results_ordercount($db,$userid){
		$sql = "select * from ".USER_ORDER_TABLE." where user_id='".$userid."' and order_status=3";
//		echo $sql;
		return $db->get_results($sql);
	}

	function get_results_all($db,$order_id){
		$sql = "select a.*,b.name from ".USER_ORDER_TABLE." a,user_shop b where a.id in (".$order_id.") and a.suser_id=b.user_id ";
//		echo $sql;
		return $db->get_results($sql);
	}
	function get_row_all($db,$order_id){
		$sql = "select a.*,b.name from ".USER_ORDER_TABLE." a,user_shop b where a.id =".$order_id." and a.suser_id=b.user_id ";
//		echo $sql;
		return $db->get_row($sql);
	}

	function get_order_share_record($db,$userid,$order_id){
		$sql = "select * from ".INTEGRAL_RECORD_TABLE." where userid='".$userid."' and order_id='".$order_id."' and type=5 limit 1";
		return $db->get_row($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".USER_ORDER_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("update ".USER_ORDER_TABLE." set user_del=2 where order_id in (".implode(",",$id).")");
		return true;
	}

	function create($customer_id,$telephone,$shipping_firstname,$shipping_address_1,$shipping_address_2,$consigneeType,$remark,$order_status_id,$date_added,$order_number,$pay_method,$suser_id,$product_all_price,$espress_price,$order_all_price,$address_id, $province, $city, $area, $extInfo=array(),$out_trade_no,$db)
	{
		$fieldMap = array(
			'user_id' => $customer_id,
			'all_price' => $product_all_price,
			'fact_price' => $order_all_price,
			'espress_price' => $espress_price,
			'consignee_phone' => $telephone,
			'consignee' => $shipping_firstname,
			'consignee_address' => $shipping_address_1,
			'consignee_type' => $consigneeType,
			'buyer_message' => $db->escape($remark),
			'order_status' => $order_status_id,
			'create_by' => $customer_id,
			'create_date' => date('Y-m-d H:i',time()),
			'update_by' => $customer_id,
			'update_date' => date('Y-m-d H:i',time()),
			'order_no' => $order_number,
			'is_cancel_order' => 0,
			'pay_status' => $pay_method,
			'suser_id' => $suser_id,
			'is_delete_order' => 0,
			'channel' => 2,
			'user_address_id' => $address_id,
			'province' => $province,
			'city' => $city,
			'area' => $area,
			'out_trade_no' => $out_trade_no
		);
		if($consigneeType == 2){
			$fieldMap['province'] = $province;
			$fieldMap['city'] = $city;
			$fieldMap['area'] = $area;
		}
		if(!empty($extInfo)){
			foreach($extInfo as $_k => $_v){
				$fieldMap[$_k] = $_v;
			}
		}

		$field = array();
		$value = array();

		foreach($fieldMap as $k => $v)
		{
			$field[] = '`'.$k.'`';
			$value[] = "'{$v}'";
		}

		$sql = 'INSERT INTO `'.USER_ORDER_TABLE.'`('.implode(',', $field).') VALUES('.implode(',', $value).')';

		$db->query($sql);
		$order_id = $db->insert_id;
		return $order_id;
	}

	function update($customer_id=-1,$customer_group_id=-1,$email=null,$telephone=null,$cellphone=null,$shipping_firstname=null,$shipping_address_1=null,$shipping_address_2=null,$shipping_city=null,$shipping_postcode=null,$shipping_method=null,$remark=null,$order_status_id=-1,$date_added=null,$date_modified=null,$ip=null,$order_number=-1,$pay_method=null,$rebate=null,$coupon=null,$abolishment_status=-1,$paid_price=null,$isread=-1,$status_time=-1,$all_price=null,$group_buy_price=null,$sign_userid=-1,$status_bu=-1,$huodong_order_status=-1,$pay_online=null,$promotions_price=-1,$express_type='',$express_number='',$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($customer_id>0){
			$update_values.="customer_id='".$customer_id."',";
		}
		if($customer_group_id>0){
			$update_values.="customer_group_id='".$customer_group_id."',";
		}
		if($email!=null){
			$update_values.="email='".$email."',";
		}
		if($telephone!=null){
			$update_values.="telephone='".$telephone."',";
		}
		if($cellphone!=null){
			$update_values.="cellphone='".$cellphone."',";
		}
		if($shipping_firstname!=null){
			$update_values.="shipping_firstname='".$shipping_firstname."',";
		}
		if($shipping_address_1!=null){
			$update_values.="shipping_address_1='".$shipping_address_1."',";
		}
		if($shipping_address_2!=null){
			$update_values.="shipping_address_2='".$shipping_address_2."',";
		}
		if($shipping_city!=null){
			$update_values.="shipping_city='".$shipping_city."',";
		}
		if($shipping_postcode!=null){
			$update_values.="shipping_postcode='".$shipping_postcode."',";
		}
		if($shipping_method!=null){
			$update_values.="shipping_method='".$shipping_method."',";
		}
		if($remark!=null){
			$update_values.="remark='".$remark."',";
		}
		if($order_status_id>0){
			$update_values.="order_status_id='".$order_status_id."',";
		}
		if($date_added!=null){
			$update_values.="date_added='".$date_added."',";
		}
		if($date_modified!=null){
			$update_values.="date_modified='".$date_modified."',";
		}
		if($ip!=null){
			$update_values.="ip='".$ip."',";
		}
		if($order_number>0){
			$update_values.="order_number='".$order_number."',";
		}
		if($pay_method!=null){
			$update_values.="pay_method='".$pay_method."',";
		}
		if($rebate!=null){
			$update_values.="rebate='".$rebate."',";
		}
		if($coupon!=null){
			$update_values.="coupon='".$coupon."',";
		}
		if($abolishment_status>0){
			$update_values.="abolishment_status='".$abolishment_status."',";
		}
		if($paid_price!=null){
			$update_values.="paid_price='".$paid_price."',";
		}
		if($isread>0){
			$update_values.="isread='".$isread."',";
		}
		if($status_time>0){
			$update_values.="status_time='".$status_time."',";
		}
		if($all_price!=null){
			$update_values.="all_price='".$all_price."',";
		}
		if($group_buy_price!=null){
			$update_values.="group_buy_price='".$group_buy_price."',";
		}
		if($sign_userid>0){
			$update_values.="sign_userid='".$sign_userid."',";
		}
		if($status_bu>0){
			$update_values.="status_bu='".$status_bu."',";
		}
		if($huodong_order_status>0){
			$update_values.="huodong_order_status='".$huodong_order_status."',";
		}
		if($pay_online!=null){
			$update_values.="pay_online='".$pay_online."',";
		}
		if($promotions_price>0){
			$update_values.="promotions_price='".$promotions_price."',";
		}
		if($express_type != ''){
			$update_values.="express_type='".$express_type."',";
		}
		if($express_number != ''){
			$update_values.="express_number='".$express_number."',";
		}

		$db->query("update ".USER_ORDER_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where order_id=".$id);
//		echo "update ".USER_ORDER_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where order_id=".$id;
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".USER_ORDER_TABLE." set status='".($c_state)."' where order_id in (".implode(",",$id).")");
		return true;
	}
//更新用户删除状态
	function user_del($db,$order_id,$user_del,$uid)
	{
		$db->query("update ".USER_ORDER_TABLE." set is_delete_order='".$user_del."' where id='".$order_id."' and `user_id`='".$uid."'");
		return true;
	}

// 用户取消订单
	function user_cancel($db,$order_id,$user_cancel,$uid)
	{
		//echo "update ".USER_ORDER_TABLE." set is_cancel_order='".$user_cancel."' where id='".$order_id."' and `user_id`='".$uid."'";
		$db->query("update ".USER_ORDER_TABLE." set is_cancel_order='".$user_cancel."' where id='".$order_id."' and `user_id`='".$uid."'");
		return true;
	}

// 更新订单状态
	function update_order_status($db,$status,$order_id){
		$sql = "update ".USER_ORDER_TABLE." set order_status='".$status."', `update_date`='".date('Y-m-d H:i:s')."'  where id='".$order_id."'";
		$db->query($sql);
		return true;
	}
    function update_statu($db,$status,$order_id){
		$sql = "update ".USER_ORDER_TABLE." set pay_status='".$status."' where id ='".$order_id."'";
		$db->query($sql);
//		echo $sql;
		return true;
	}
	 function update_status($db,$status,$order_id){
		$sql = "update ".USER_ORDER_TABLE." set order_status='".$status."' where id ='".$order_id."'";
		$db->query($sql);
//		echo $sql;
		return true;
	}
	function update_pay_online($db,$pay_money,$order_id){
		$sql = "update ".USER_ORDER_TABLE." set pay_online='".$pay_money."' where order_id='".$order_id."'";
		$db->query($sql);
		return true;
	}

	function update_coupon($db,$coupon_number,$order_id){
		$sql = "update ".USER_ORDER_TABLE." set coupon='".$coupon_number."' where order_id='".$order_id."'";
		$db->query($sql);
		return true;
	}

	function update_pay_method($db,$pay_method,$order_id){
		$sql = "update ".USER_ORDER_TABLE." set pay_method='".$pay_method."' where order_id='".$order_id."'";
		$db->query($sql);
		return true;
	}

	function update_integral_used($db,$order_id,$integral_used){
		$sql = "update ".USER_ORDER_TABLE." set integral_used='".$integral_used."' where order_id='".$order_id."'";
		$db->query($sql);
		return true;
	}

	function update_rebate($db,$discount,$order_id){
		$sql = "update ".USER_ORDER_TABLE." set rebate='".$discount."' where order_id='".$order_id."'";
		$db->query($sql);
		return true;
	}

	// 获取用户订单对应的地址
	function get_consignee_address( $db,$order_id )
	{
		$sql = "SELECT `consignee_address` FROM ".USER_ORDER_TABLE." WHERE `id` = {$order_id}";
		$obj = $db->get_row($sql);
		return $obj->consignee_address;
	}

	/*
	 * 功能：根据用户获取对应的用户订单信息
	 * */
	function get_order_info($db,$id,$uid)
	{
		$sql = "SELECT * FROM ".USER_ORDER_TABLE." WHERE `id`={$id} AND `user_id`={$uid}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	/*
	 * 功能：当用户付款成功之后更新订单状态
	 * */
	function pay_change_order_status( $db, $order_id, $userid )
	{
		$sql = "UPDATE ".USER_ORDER_TABLE." SET `pay_status`=1, `order_status`=2, `update_date`='".date('Y-m-d H:i:s')."' WHERE `order_status`=1 AND `id`='".$order_id."' AND `user_id`='".$userid."'";
		$db->query($sql);
		return ( $db->rows_affected > 0 ) ? true : false;
	}


	/*
	 * 	功能：获取确认订单页的数据信息（只关心代付款的订单）
	 * */
	function get_order_info_all($db,$order_id,$uid )
	{
		$sql = "select a.*,b.name as shopname from ".USER_ORDER_TABLE." a,user_shop b where a.id in (".$order_id.") and a.suser_id=b.user_id AND a.`is_delete_order`=0 AND a.`is_cancel_order`=0 AND a.`order_status`=1 AND a.`user_id`={$uid}";
		return $db->get_results($sql);
	}

	/**
	 * 更改订单信息
	 *
	 * @param object $db 数据库句柄
	 * @param array $data 更改的数据
	 * @param integer $oid 订单id
	 * @return boolean
	 */
	public function update_info($db, $data, $oid){
		$sql = 'UPDATE `'.USER_ORDER_TABLE.'` SET `fact_price`='.$data['fact_price'].' WHERE `id`='.$oid;
		return $db->query($sql);
	}

	/**
	 * 判断用户是否第一次下单
	 *
	 * @param object $db 数据库句柄
	 * @param integer $uid 用户id
	 * @return boolean
	 */
	public function isFirst($db, $uid){
		$sql = 'SELECT * FROM `'.USER_ORDER_TABLE.'` WHERE `user_id`='.$uid.' AND `first_flag`=1';
		$order = $db->get_row($sql);
		return empty($order) ? true : false;
	}

	/**
	 * 获取同一次支付的订单
	 *
	 * @param object $db 数据库句柄
	 * @param string $outTradeNo 支付订单号
	 * @param integer $uid 用户id
	 * @return array
	 */
	public function gets4SamePay($db, $outTradeNo, $uid){
		$sql = "SELECT * FROM `".USER_ORDER_TABLE."` WHERE `user_id`={$uid} AND `out_trade_no`='{$outTradeNo}'";
		return $db->get_results($sql);
	}
}
?>
