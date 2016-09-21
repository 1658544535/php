<?php
if ( !defined('SCRIPT_ROOT') ) die ("no permission");

class UserOrderBean extends  Db
{
	function __construct( $db, $table )
	{
		parent::__construct( $db, $table );
		$this->conn = $db;
	}

	function __get( $key )
	{
		return $this->$key;
	}

	function __set( $key, $val )
	{
		$this->$key = $val;
	}

	/**
	 * 	获取刷单记录，并填写入相应的表中
	 *
	 *  @param int $nUserID  		用户ID
	 *  @param int $nProductID		产品ID
	 *  @param int $nNum 			数量
	 *  @param bool $auto 			是否自动生成
	 *  @param arr $AutoData 		如果 $auto 为 TRUE 则此字段必填  array( 'date', 'order_status', 'pay_status' )
	 *  @return bool
	 * */
	public function getInfo( $nUserID, $nProductID, $nNum, $auto=FALSE, $AutoData='' )
	{
		if ( $auto )
		{
			$date 			= $AutoData['date'];
			$order_status 	= 2;
			$pay_status 	= 1;
		}
		else
		{
			$time 			= time() - rand(1,90);
			$date 			= date('Y-m-d H:i:s', $time);
			$order_status 	= 1;
			$pay_status 	= 0;
		}

		// 获取用户信息
		$this->change_table( 'user_info' );
		$objUserInfo = $this->getOne( array('user_id'=>$nUserID), array('user_id','phone','address') );

		if ( $objUserInfo == null )
		{
			Log::DEBUG( "添加失败！原因：user_info表里面找不到该用户");
			return FALSE;
		}

		// 获取用户昵称信息
		$this->change_table( 'sys_login' );
		$objSysLoginInfo = $this->getOne( array('id'=>$nUserID), array('name') );

		// 获取商品信息
		$this->change_table( 'product' );
		$objProductInfo = $this->getOne( array('id'=>$nProductID), array('id','user_id','product_no','product_name','distribution_price','image','postage_type','weight') );

		$espress_price = 0;

		if ( $objProductInfo->postage_type == 0 )
		{
			$objProductInfo->weight * $nNum;
		}

		$arrParam = array(
			'user_id' 				=>	$objUserInfo->user_id,
			'suser_id'				=>	$objProductInfo->user_id,
			'all_price' 			=>	$objProductInfo->distribution_price * $nNum + $espress_price,
			'fact_price'			=>	$objProductInfo->distribution_price * $nNum,
			'out_trade_no' 			=>	$this->set_out_trade_no(),
			'espress_price'			=>	$espress_price,
			'consignee'				=>	$objSysLoginInfo->name,
			'consignee_address'		=>	$objUserInfo->address,
			'consignee_phone'		=>	$objUserInfo->phone,
			'consignee_type'		=>	1,
			'order_status'			=>  $order_status,
			'create_by'				=> -1,
			'create_date'			=> $date,
			'update_by'				=> -1,
			'update_date'			=> $date,
			'channel' 				=> 1,
			'province' 				=> '',
			'city' 					=> '',
			'area' 					=> '',
			'order_type'			=> 1,
			'order_no'				=> $this->set_order_num(),
			'pay_method'			=> 2,
			'pay_status'			=> $pay_status
		);

		$this->conn->query("BEGIN");

		// 添加订单信息
		$this->change_table( 'user_order' );
		$order_id = $this->create( $arrParam );
		$fact_price 	= $arrParam['all_price'];		// 生成二维码时使用
		$out_trade_no 	= $arrParam['out_trade_no'];	// 生成二维码时使用


		if ( $order_id < 1 )
		{
			Log::DEBUG( "添加失败！原因：插入order表失败。");
			$this->conn->query("ROLLBACK");
			return FALSE;
		}

		// 获取分销商信息
		$this->change_table( 'user_shop' );
		$arrShopInfo = $this->getOne( array( 'user_id' => $objProductInfo->user_id ), array('id','name') );

		$arrParam = array(
			'user_id' 			=>	$objUserInfo->user_id,
			'order_id'			=>	$order_id,
			'loginname' 		=>	$objUserInfo->phone,
			'shop_id'			=>	$arrShopInfo->id,
			'product_id' 		=>	$objProductInfo->id,
			'product_name'		=>	$objProductInfo->product_name,
			'product_image'		=>	$objProductInfo->image,
			'stock_price_old'	=> 	$objProductInfo->distribution_price,
			'stock_price'		=> 	$objProductInfo->distribution_price,
			'num'				=> 	$nNum,
			'type'				=> 	1,
			'channel'			=> 	1,
			'return_status'		=> 	0,
			'status'			=> 	1,
			'create_by'			=> 	'-1',
			'create_date' 		=> 	$date,
			'update_by' 		=> 	'-1',
			'update_date' 		=> 	$date,
			'postage_type' 		=> 	$objProductInfo->postage_type,
			'weight'			=> 	$objProductInfo->weight
		);

		// 添加订单详情信息
		$this->change_table( 'user_order_detail' );
		$order_detail_id = $this->create( $arrParam );

		if ( $order_detail_id < 1 )
		{
			Log::DEBUG( "添加失败！原因：插入order_detail表失败。");
			$this->conn->query("ROLLBACK");
			return FALSE;
		}

//		if ( $auto == FALSE )		// 如果不是自动刷单，则生成支付二维码
//		{
//			$rs = getQrCode( $fact_price * 100, $out_trade_no, $order_id );
//		}

		Log::DEBUG( "添加成功！订单id【{$order_id}】");
		$this->conn->query("COMMIT");
		return TRUE;
	}


	/*
	 * 功能：获取对外订单号
	 * */
	private function set_out_trade_no()
	{
		$time = explode(" ", microtime());
		return date('Ymd') . $time[1] . rand(100,999);
	}

	/*
	 * 功能： 获取订单号
	 * */
	private function set_order_num()
	{
		$time = explode(" ", microtime());
		$rand = rand(100000, 999999);
		return $time[1] * 1000 . $rand;
	}

	/**
	 * 获取订单列表
	 */
	public function get_list( $sdate='', $edate='', $page='1', $order_status='', $order_no, $fPage=true )
	{
		$strWhere = '';

		if ( $sdate != '' && $edate!='' )
		{
			$strWhere .= " AND (uo.`create_date`>='{$sdate} :00' AND uo.`create_date`<='{$edate} :59')";
		}

		if ( $order_status!='' )
		{
			$strWhere .= " AND uo.`order_status`='{$order_status}'";
		}

		if ( $order_no!='' )
		{
			$strWhere .= " AND uo.`order_no`='{$order_no}'";
		}

		$strSQL = "SELECT
						uo.`id`,
						uo.`user_id`,
						uo.`all_price`,
						uo.`order_status`,
						uo.`pay_status`,
						uo.`create_date`,
						uo.`order_no`,
						uo.`consignee`,
						uod.`product_image`,
						uod.`product_name`
					FROM
						`user_order` AS uo,
						`user_order_detail` AS uod
					WHERE
						`uo`.`id`=`uod`.`order_id`
					AND
						uo.`order_type`=1 " . $strWhere . "
					ORDER BY
						`uo`.id DESC
					";

		if ( $fPage )
		{
			return get_pager_data( $this->conn, $strSQL, $page, 10);
		}
		else
		{
			return $this->conn->get_results( $strSQL );
		}

	}

	/**
	 * 获取订单列表
	 */
	public function get_one($order_id)
	{
		$strSQL = "SELECT
						uo.`id`,
						uo.`all_price`,
						uo.`fact_price`,
						uo.`order_status`,
						uo.`pay_status`,
						uo.`create_date`,
						uo.`order_no`,
						uo.`consignee`,
						uo.`consignee_address`,
						uo.`consignee_phone`,
						uo.`consignee_type`,
						uo.`buyer_message`,
						uo.`remarks`,
						uo.`wallet_price`,
						uo.`discount_price`,
						uo.`discount_context`,
						uo.`out_trade_no`,
						uod.`product_image`,
						uod.`product_name`,
						uod.`product_model`,
						uod.`stock_price`,
						sl.`name`
					FROM
						`user_order` AS uo,
						`user_order_detail` AS uod,
						`sys_login` AS sl
					WHERE
						`uo`.`id`=`uod`.`order_id`
					AND
						`uo`.`user_id`=`sl`.`id`
					AND
						uo.`order_type`=1
					AND
						uo.`id`={$order_id}
					ORDER BY
						`uo`.id DESC";
		return $this->conn->get_row($strSQL);
	}


	/**
	 *  获取临时订单列表
	 */
	public function getTempOrder($arr)
	{
		$sql = "SELECT `id`,`create_date` FROM `user_order` WHERE (`id`>={$arr['start_id']} AND `id`<={$arr['end_id']}) AND `order_type`=1";
		return $this->conn->get_results($sql);
	}


	public function changeOrderData( $date, $order_id )
	{
		$arrParam = array(
			'create_date' 		=> 	$date,
			'update_date' 		=> 	$date,
			'order_status'		=>  2,
			'pay_status'		=>  1,
			'pay_method'		=>  2
		);

		$this->update( $arrParam, array( 'id'=>$order_id ));
	}

	/**
	 *	获取搜索到的订单的总金额
	 */
	public function get_price( $sdate='', $edate='', $order_status='', $order_no )
	{
		$strWhere = '';

		if ( $sdate != '' && $edate!='' )
		{
			$strWhere .= " AND (`create_date`>='{$sdate} :00' AND `create_date`<='{$edate} :59')";
		}

		if ( $order_status!='' )
		{
			$strWhere .= " AND `order_status`='{$order_status}'";
		}

		if ( $order_no!='' )
		{
			$strWhere .= " AND `order_no`='{$order_no}'";
		}

		$strSQL = "SELECT
						sum(`all_price`)
					FROM
						`user_order`
					WHERE `order_type`=1 " . $strWhere;

		return $this->conn->get_var( $strSQL );
	}

	/**
	 *	获取今天总订单数
	 */
	public function getTodayOrderNum()
	{
		$date = date('Y-m-d');
		$strSQL = "SELECT
						count(*) as num
					FROM
						`user_order`
					WHERE
						`order_type`=1
					AND
						(`create_date`>='{$date} 00:00:00' AND `create_date`<='{$date} 23:59:59')
				  ";

		return $this->conn->get_var( $strSQL );
	}
}
?>