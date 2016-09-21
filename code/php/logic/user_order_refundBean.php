<?php
if ( !defined('HN1') ) die("no permission");


class user_order_refundBean
{
	function search($db,$page,$per,$condition,$keys,$score)
	{
		$sql = "select * from ".REFUND_TABLE." where id>0";
		if($score > -1){
			$sql.=" and score=".$score;
		}
		if($condition == 'order_number'){
			$sql.=" and order_number=".$keys;
		}
		if($condition == 'shipping_firstname'){
			$sql.=" and shipping_firstname='".$keys."'";
		}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".REFUND_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_product($db,$product_id){
		$sql = "select * from ".REFUND_TABLE." where product_id='".$product_id."' order by id desc";
		return $db->get_results($sql);
	}

	function get_results_order($db,$order_id){
		$sql = "select * from ".REFUND_TABLE." where order_id='".$order_id."'";
//		echo $sql;
		return $db->get_results($sql);
	}

	/*
	function detail($db,$oid,$pid,$uid)
	{
		$sql = "select * from ".REFUND_TABLE." where order_id = {$oid} and  product_id={$pid} and user_id={$uid}";
		//$sql = "select * from ".REFUND_TABLE." where order_id = {$oid} and  product_id={$pid}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	*/
	function detail($db,$did,$uid)
	{
		$sql = "select * from ".REFUND_TABLE." where detail_id = {$did} and user_id={$uid}";
		//$sql = "select * from ".REFUND_TABLE." where order_id = {$oid} and  product_id={$pid}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_order_product($db,$order_id,$product_id){
		$sql = "select * from ".REFUND_TABLE." where order_id='".$order_id."' and product_id='".$product_id."'";
		return $db->get_row($sql);
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".REFUND_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($detail_id,$order_id,$userid,$loginname,$shop_id,$product_id,$product_name,$price,$refund_num,$comment,$refund_Type,$type,$product_img,$sku_link_id,$db)
	{
		$sql="INSERT INTO ".REFUND_TABLE." (
				`detail_id`,
				`order_id`,
				`user_id`,
				`loginname`,
				`shop_id`,
				`product_id`,
				`product_name`,
				`stock_price_old`,
				`stock_price`,
				`refund_num`,
				`refund_reason`,
				`status`,
				`create_by`,
				`create_date`,
				`update_by`,
				`update_date`,
				`refund_Type`,
				`type`,
				`images`

			) VALUES (
				'".$detail_id."',
				'".$order_id."',
				'".$userid."',
				'".$loginname."',
				'".$shop_id."',
				'".$product_id."',
				'".$product_name."',
				'".$price."',
				'".$price."',
				'".$refund_num."',
				'".$db->escape($comment)."',
				'1',
				'".$userid."',
				'".date('Y-m-d H:i',time())."',
				'".$userid."',
				'".date('Y-m-d H:i',time())."',
				'".$refund_Type."',
				'".$type."',
				'".$product_img."'

			)";

		$rs = $db->query($sql);


		return ( $rs ) ? true : false;

	}

	function update($order_id=-1,$order_number=-1,$product_id=0,$score=-1,$customer_id=-1,$shipping_firstname=null,$comment=null,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($order_id>0){
			$update_values.="order_id='".$order_id."',";
		}
		if($order_number>0){
			$update_values.="order_number='".$order_number."',";
		}
		if($product_id>0){
			$update_values.="product_id='".$product_id."',";
		}
		if($score>0){
			$update_values.="score='".$score."',";
		}
		if($customer_id>0){
			$update_values.="customer_id='".$customer_id."',";
		}
		if($shipping_firstname!=null){
			$update_values.="shipping_firstname='".$shipping_firstname."',";
		}
		if($comment!=null){
			$update_values.="comment='".$comment."',";
		}
		$db->query("update ".REFUND_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".REFUND_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}


	// 用户提交退货运单后更新数据
	function returncomfire( $db, $detail_id, $userid, $logistics, $logType )
	{
		$sql = "UPDATE `". REFUND_TABLE ."` SET `status`=3,`logistics`='".$logistics."',`logType`='".$logType."' WHERE `user_id`='".$userid."' AND `detail_id`='".$detail_id."' AND `status`=2";
		$rs  = $db->query($sql);
		return $rs ? true : false;
	}

	// 获取退货中的产品信息
	function get_refund_info($db,$userid)
	{
		$sql = "SELECT * FROM " .  REFUND_TABLE . " WHERE `user_id`='" . $userid . "' ORDER BY `id` DESC";
		$rs = $db->get_results($sql);
		return $rs;
	}

}
?>
