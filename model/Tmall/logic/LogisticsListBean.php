<?php
if ( !defined('SCRIPT_ROOT') ) die ("no permission");

class LogisticsListBean extends  Db
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

	public function add( $arrParam )
	{
		$this->create( $arrParam );
	}

	/**
	 *	功能：获取运单列表
	 */
	public function getList( $page )
	{
		$strSQL = "SELECT * FROM `logistics_list` WHERE `status`=1 ORDER BY `date` ASC";
		return get_pager_data( $this->conn, $strSQL, $page, 10);
	}

	/**
	 *	功能：添加订单的运单记录
	 *
	 *	步骤：
	 *  1、通过order_id获取user_order记录
	 *  2、添加信息到user_order_ship
	 *  3、修改user_order的order_status
	 *  4、删除logistics_list的记录
	 */
	 public function addOrderShip( $order_id, $logistics_name, $logistics_no )
	 {
	 	// 1、通过order_id获取user_order记录
	 	$this->change_table( 'user_order' );
		$objOrderInfo = $this->getOne( array('id'=>$order_id) );

		// 2、添加信息到user_order_ship
	 	$arrParam = array(
	 		'order_id' 			=> $objOrderInfo->id,
	 		'user_id' 			=> $objOrderInfo->user_id,
	 		'logistics_name' 	=> $logistics_name,
	 		'logistics_no' 		=> $logistics_no,
	 		'consignor' 		=> '淘竹马',
	 		'consignor_address' => '汕头市澄海区',
	 		'ship_phone' 		=> '075486377577',
	 		'consignee' 		=> $objOrderInfo->consignee,
	 		'consignee_address' => $objOrderInfo->consignee_address,
	 		'consignee_phone' 	=> $objOrderInfo->consignee_phone,
	 		'consignee_type' 	=> $objOrderInfo->consignee_type,
	 		'buyer_message' 	=> $objOrderInfo->buyer_message,
	 		'order_status' 		=> 2,
	 		'status' 			=> 1,
	 		'order_no' 			=> $objOrderInfo->order_no,
	 		'create_by' 		=> 1,
	 		'create_date' 		=> date('Y-m-d H:i:s'),
	 		'update_by' 		=> 1,
	 		'update_date' 		=> date('Y-m-d H:i:s')
	 	);

	 	$this->change_table( 'user_order_ship' );
	 	$this->create( $arrParam );

		// 3、修改user_order的order_status
	 	$this->change_table( 'user_order' );
		$this->update( array('order_status'=>3), array('id'=>$order_id));

		// 4、删除logistics_list的记录
		$this->change_table( 'logistics_list' );
		$this->del( array( 'logistics_name'=>$logistics_name, 'logistics_no'=>$logistics_no  ) );
	 }

	 /**
	  *	获取订单列表
	  */
	 public function getOrderList( $date )
	 {
	 	$sql = "SELECT `id` FROM `user_order` WHERE `order_type`=1 AND `order_status`=2 AND DATE_FORMAT(`create_date`,'%Y-%m-%d') = DATE_FORMAT( '{$date}','%Y-%m-%d')";
	 	return $this->querys( $sql );
	 }

	 /**
	  *	获取快递运单列表
	  */
	 public function getLogisticsList( $date )
	 {
	 	$sql = "SELECT `logistics_name`,`logistics_no` FROM `logistics_list` WHERE `date` = DATE_FORMAT('{$date}','%Y-%m-%d')";
	 	return $this->querys( $sql );
	 }

}
?>