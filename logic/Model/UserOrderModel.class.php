<?php
/**
 * 用户订单模型
 */
class UserOrderModel extends Model
{
	private $UserInfo;
	private $UserOrderId;
	private $UserOrderInfo;
	private $UserCartProductList;

	public function __construct($db, $table='')
	{
		global $log;
        $table = 'user_order';
        parent::__construct($db, $table);
        $this->log = $log;
    }

	/**
	 *	功能：获取订单列表
	 *	@param int $nStatus:  要查到的订单状态
	 *  @param int $nOrderID: 要查到的订单号信息
	 */
	public function getOrderList( $nStatus='', $nOrderID='' )
	{
		global $user;
		$OrderList 	= array();
		$strWhere = '';

		if ( (int)$nStatus > 0 )
		{
			$strWhere  = ' AND uo.`order_status`=' . $nStatus;
		}

		if ( (int)$nOrderID > 0 )
		{
			$strWhere  = ' AND uo.`id`=' . $nOrderID;
		}

		$strSQL = "
					SELECT
						uo.`id`,
						uo.`order_no`,
						uo.`espress_price`,
						uo.`activity_id`,
						uo.`activity_name`,
						uo.`order_status`,
						uo.`user_address_id`,
						uo.`create_date`,
						uo.`discount_price`,
						uod.`id` as user_order_detail_id,
						uod.`product_id`,
						uod.`product_name`,
						uod.`product_image`,
						uod.`stock_price`,
						uod.`num`,
						uod.`status`,
						uod.`sku_link_id`,
						uod.`re_status`,
						(SELECT `type` FROM `activity_time` WHERE `id`=uo.`activity_id`) as activity_type
					FROM
						`user_order` as uo,
						`user_order_detail` as uod
					WHERE
						uo.`id`=uod.`order_id`
					AND
						uo.`is_delete_order`=0
					AND
						uo.`is_cancel_order`=0
					AND
						uo.`user_id`={$user->id}
					{$strWhere}
					ORDER BY
						uo.`id` DESC
				";

		$rs = $this->query( $strSQL );

		if ( $rs == NULL )
		{
			return NULL;
		}

		$objOrderInfo = $this->getOrderDesc( $rs );
		return $objOrderInfo;
	}


	/**
	 *	功能：接收订单号返回对外订单号（用于订单提交后，申请付款的操作）
	 */
	public function getOutTradeNoFromOrderID( $strOrderID, $nUserID )
	{
		global $db;
		require_once FUNC_ROOT.'cls_payment.php';
		$payment 			= new Payment($db);

		// 生成对外订单号
		$out_trade_no = set_out_trade_no();

		do
		{
			if ( $strOrderID == "" )
			{
				return get_json_data_public( -1, '未选择支付订单' );
			}

			$arrOrderId = explode(',',$strOrderID);
			$db->query("BEGIN");

			// 遍历订单
			foreach($arrOrderId as $order)
			{
				// 更新用户user_order.out_trade_no
				$rs = $payment->u_user_order_trade_no( $order, $nUserID, $out_trade_no );


				if ( $rs === false )
				{
					$db->query("ROLLBACK");
					return get_json_data_public( -2, '找不到该订单！' );
				}
			}

			// 计算订单总价
			$totalAmount = $payment->getOrderPayAmount( $out_trade_no );
			$arrParam = array(
				'out_trade_no'  => $out_trade_no,
				'total_fee'		=> $totalAmount,
				'date'			=> date('Y-m-d H:i:s')
			);

			$rs = $payment->w_wxpay_order_info( $arrParam );
			if ( $rs === false )
			{
				$db->query("ROLLBACK");
				return get_json_data_public( -3, '更新订单信息有误！' );
			}

			$db->query("COMMIT");
			return get_json_data_public( 1, '订单提交成功！开始付款', $out_trade_no );
		}while(0);
	}


    /**
	 * 功能：添加订单
	 * 步骤：
	 * 1、添加user_order
	 * 2、添加user_order_detail
	 * 3、删除user_cart的相关记录
	 * 4、添加wxpay_order_info记录
	 */
	 public function addUserOrderOperation( $arrParam, $UserCartProductList, $user )
	 {
	 	global $user;
	 	$bSuccess = FALSE;
	 	$this->UserOrderInfo		= $arrParam;
	 	$this->UserCartProductList	= $UserCartProductList;
	 	$this->UserInfo				= $user;

		do{
			// 开始事务
			$this->startTrans();

			// 1、添加user_order
			$nUserOrderId = $this->addUserOrdrerInfo();
			
			if ( ! $nUserOrderId )
			{
				//echo get_json_data_public( '-1', '添加订单信息失败！' );
				$log->put( '/orders/' . date('YmdH'), "用户：{$user->id}, 订单生成失败，原因:添加订单信息失败!" );
				$this->rollback();
				break;
			}

			// 订单ID
			$this->UserOrderId = $nUserOrderId;
		
			foreach( $UserCartProductList as $CartProductInfo )
			{
				
				// 2、添加订单商品详情
		
				
				$nUserOrderDetailID = $this->addUserOrderDetail( $CartProductInfo );
			
				if ( $nUserOrderDetailID < 1 )
				{
					//echo get_json_data_public( '-1', '添加订单商品失败' );
					$this->log->put( '/orders/' . date('YmdH'), "用户：{$user->id}, 订单生成失败，原因:添加订单商品失败!" );
					$this->rollback();
					break;
				}

				// 3、删除购物车商品信息
		
		
				$rs = $this->delete( array( 'id' => $CartProductInfo->id ), "user_cart" );
				if ( $rs < 1 )
				{
					//echo get_json_data_public( '-1', '删除购物车商品失败' );
					$this->log->put( '/orders/' . date('YmdH'), "用户：{$user->id}, 订单生成失败，原因:删除购物车商品失败!" );
					$this->rollback();
					break;
				}
			}
	
			// 4、记录微信订单支付信息
			$rs = $this->w_wxpay_order_info( $arrParam['out_trade_no'], $arrParam['fact_price'] );
			if ( ! $rs )
			{
				//echo get_json_data_public( '-1', '记录微信订单支付信息失败' );
				$this->log->put( '/orders/' . date('YmdH'), "用户：{$user->id}, 订单生成失败，原因:记录微信订单支付信息失败!" );
				$this->rollback();
				break;
			}

			//echo get_json_data_public( '1', '订单生成成功' );
			$this->log->put( '/orders/' . date('YmdH'), "用户：{$user->id}, 订单生成成功, 订单ID：【{$nUserOrderId}】" );
			$bSuccess = $this->UserOrderId;
			$this->commit();
		}while(0);

		return $bSuccess;
	 }


	/**
	 * 功能：添加订单评论
	 */
	 public function addOrderComment( $arrParam )
	 {
		return $this->add( $arrParam, 'user_comment' );
	 }

	 /**
	  *	功能：获取订单的数量
	  */
	 function getOrderStatus( $nUserID, $nOrderStaus=0 )
	 {
	 	$arrWhere = array(
	 		'user_id'			=> $nUserID,
	 		'is_delete_order'	=> 0,
	 		'is_cancel_order'	=> 0
	 	);

	 	if ( $nOrderStaus > 0 )
	 	{
	 		$arrWhere['order_status'] = $nOrderStaus;
	 	}

		return $this->getCount($arrWhere);
	}


	/**
	 * 功能：添加信息到user_order表
	 */
	private function addUserOrdrerInfo()
	{
		$nUserOrderId = $this->add( $this->UserOrderInfo );
		if ( $nUserOrderId < 1 )
		{
			return FALSE;
		}

		return $nUserOrderId;
	}


	/**
	 * 功能：触发付款时，新增wxpay_order_info记录
	 */
	private function w_wxpay_order_info( $out_trade_no, $total_fee )
	{
		$arrParam = array(
			'out_trade_no'	=> $out_trade_no,
			'total_fee'		=> $total_fee,
			'trade_status'	=> 'WAIT_BUYER_PAY',
			'create_date'	=> date( 'Y-m-d H:i:s' ),
			'update_date'	=> date( 'Y-m-d H:i:s' )
		);

		$rs = $this->add( $arrParam, 'wxpay_order_info' );
		return ( $rs > 0 ) ? true : false;
	}


	/**
	 *	功能：添加订单详情信息
	 */
	private function addUserOrderDetail( $CartProductInfo )
	{
		$arrProductParam = array(
			'product_image'		=> $CartProductInfo->product_image,
			'user_id'			=> $CartProductInfo->user_id,
			'product_id'		=> $CartProductInfo->product_id,
			'product_name'		=> $CartProductInfo->product_name,
			'product_model'		=> $CartProductInfo->product_model,
			'stock_id'			=> $CartProductInfo->stock_id,
			'stock_price_old'	=> $CartProductInfo->stock_price_old,
			'stock_price'		=> $CartProductInfo->stock_price,
			'num'				=> $CartProductInfo->num,
			'type'				=> 0,
			'channel'			=> 2,
			'status'			=> 1,
			'create_date'		=> date('Y-m-d H:i:s'),
			'shop_id'			=> $CartProductInfo->shop_id,
			'order_id'			=> $this->UserOrderId,
			'loginname'			=> $this->UserInfo->loginname,
			'activity_id'		=> $CartProductInfo->activity_id,
			'activity_name'		=> $CartProductInfo->activity_name
		);

		if ( $CartProductInfo->sku_link_id != '' )
		{
			$arrProductParam['sku_link_id'] = $CartProductInfo->sku_link_id;
		}
	
		// 添加用户订单详情
		return $this->add( $arrProductParam, "user_order_detail" );
	}


	/**
	 *	功能：获取订单信息中的订单详情信息
	 */
	private function getOrderDesc( $OrderDescInfo )
	{
		global $OrderStatusDesc, $userid, $ReOrderStatusDesc;
		$nAvailableProductNum		=	0;			// 可用的商品数量
		$fAllPrice					= 	0;			// 判断订单总价格
		$nAllProductNum				= 	0;			// 判断订单总数量
		$nReStatusDesc				= 	'';			// 售后状态描述

		foreach( $OrderDescInfo  as $orderInfo )
		{

			$fAllPrice 		+= $orderInfo->stock_price;
			$nAllProductNum += $orderInfo->num;

			$objOrderInfo[$orderInfo->id]['id'] 												= $orderInfo->id;
			$objOrderInfo[$orderInfo->id]['order_no'] 											= $orderInfo->order_no;
			$objOrderInfo[$orderInfo->id]['activity_id'] 										= $orderInfo->activity_id;
			$objOrderInfo[$orderInfo->id]['user_address_id'] 									= $orderInfo->user_address_id;
			$objOrderInfo[$orderInfo->id]['activity_name'] 										= $orderInfo->activity_name;
			$objOrderInfo[$orderInfo->id]['activity_type'] 										= $orderInfo->activity_type;
			$objOrderInfo[$orderInfo->id]['espress_price'] 										= sprintf('%.2f',$orderInfo->espress_price);
			$objOrderInfo[$orderInfo->id]['order_status'] 										= $orderInfo->order_status;
			$objOrderInfo[$orderInfo->id]['order_status_desc'] 									= $OrderStatusDesc[$orderInfo->order_status];
			$objOrderInfo[$orderInfo->id]['create_date'] 										= $orderInfo->create_date;
			$objOrderInfo[$orderInfo->id]['all_price'] 											= sprintf('%.2f',$fAllPrice);
			$objOrderInfo[$orderInfo->id]['product_num'] 										= $nAllProductNum;
			$objOrderInfo[$orderInfo->id]['discount_price'] 									= sprintf('%.2f',$orderInfo->discount_price);
			$objOrderInfo[$orderInfo->id]['info'][$orderInfo->product_id]['user_order_detail_id'] = $orderInfo->user_order_detail_id;
			$objOrderInfo[$orderInfo->id]['info'][$orderInfo->product_id]['product_id'] 		= $orderInfo->product_id;
			$objOrderInfo[$orderInfo->id]['info'][$orderInfo->product_id]['product_name'] 		= $orderInfo->product_name;
			$objOrderInfo[$orderInfo->id]['info'][$orderInfo->product_id]['product_image'] 		= $orderInfo->product_image;
			$objOrderInfo[$orderInfo->id]['info'][$orderInfo->product_id]['stock_price'] 		= sprintf('%.2f',$orderInfo->stock_price);
			$objOrderInfo[$orderInfo->id]['info'][$orderInfo->product_id]['num'] 				= $orderInfo->num;
			$objOrderInfo[$orderInfo->id]['info'][$orderInfo->product_id]['sku_link_id'] 		= $orderInfo->sku_link_id;
			$objOrderInfo[$orderInfo->id]['info'][$orderInfo->product_id]['re_status'] 			= $orderInfo->re_status;
			$objOrderInfo[$orderInfo->id]['info'][$orderInfo->product_id]['status'] 			= $orderInfo->status;
			$objOrderInfo[$orderInfo->id]['info'][$orderInfo->product_id]['sku_desc'] 			= '';


			if ( $orderInfo->re_status > 0 && $nAvailableProductNum == 0 )
			{
				if ( ! isset($objOrderInfo[$orderInfo->id]['available_productnum']) )
				{
					$objOrderInfo[$orderInfo->id]['available_productnum'] = 0;
				}
			}
			else
			{
				$objOrderInfo[$orderInfo->id]['available_productnum'] = 1;
			}

			if ( $objOrderInfo[$orderInfo->id]['available_productnum'] == 0 )
			{
				$objOrderInfo[$orderInfo->id]['order_status_desc'] 	= $ReOrderStatusDesc[$orderInfo->re_status];
				$objOrderInfo[$orderInfo->id]['order_re_status'] 	= $orderInfo->re_status;
			}

			// 获取SKU信息
			if ( $orderInfo->sku_link_id > 0 )
			{
				$ProductModel 	 = D('Product');
				$objProductInfo  = $ProductModel->getProductInfo( $orderInfo->product_id, $orderInfo->sku_link_id, $orderInfo->activity_id );
				$objOrderInfo[$orderInfo->id]['info'][$orderInfo->product_id]['sku_desc'] 			= $objProductInfo->sku_info->sku_long_desc;
			}

		}

		return $objOrderInfo;
	}
}
?>