<?php
/**
 * 支付
 */
include_once(LOGIC_ROOT.'comBean.php');

class Payment extends comBean{

	public function __construct( $db )
    {
        parent::__construct( $db );
        $this->conn 	= $db;
        $this->log_name	=	"../logs/wxpay/notify_url_".date('Y-m-d').".log";//log文件路径
    }

    public function __get( $key )
    {
        return $this->$key;
    }

    public function __set( $key, $val )
    {
        $this->$key = $val;
    }

    /**
     * 获取订单支付金额
     *
     * @param string $outTradeNo 提交给支付方的订单号
     * @return numeric
     */
     public function getOrderPayAmount($outTradeNo)
     {
        $totalAmount 	= 0;	//订单金额
        $orderIds 		= array();
        $sql 			= "SELECT `fact_price`,`wallet_price` FROM `user_order` WHERE `out_trade_no`='{$outTradeNo}'";
        $orders 		= $this->conn->get_results($sql);

        if(!empty($orders))
        {
            foreach($orders as $_order)
            {
                $totalAmount += $_order->fact_price - $_order->wallet_price;		// 实收价 - 钱包价
            }
        }

        return $totalAmount;
    }


    /*
	 * 功能：触发付款时，新增wxpay_order_info记录
	 * */
	public function w_wxpay_order_info( $arr )
	{
		$strSQL = "INSERT INTO `wxpay_order_info` (
						`out_trade_no`,
						`total_fee`,
						`trade_status`,
						`create_date`,
						`update_date`
					)VALUES(
						'{$arr['out_trade_no']}',
						'{$arr['total_fee']}',
						'WAIT_BUYER_PAY',
						'{$arr['date']}',
						'{$arr['date']}'
					)";

		$rs = $this->conn->query( $strSQL );
		return ( $rs > 0 ) ? true : false;
	}

	/*
	 * 功能：付款成功后触发
	 * 流程：
	 * 1、更新wxpay_order_info记录
	 * 2、更新用户订单的状态 user_order.status = 2
	 * 3、更新产品销售数量
	 * */
	 public function u_order_info( $arr, $log_ )
	 {
	 	$this->conn->query("BEGIN");
	 	$bSuccess  = false;

		do {

			/*==================================== 1、 更新wxpay_order_info记录  ======================================*/
			$strSQL = "UPDATE `wxpay_order_info` SET
							`transaction_id` 	= '{$arr['transaction_id']}',
							`fee_type`			= '{$arr['fee_type']}',
							`bank_type`			= '{$arr['bank_type']}',
							`time_end`			= '{$arr['time_end']}',
							`trade_status`		= 'TRADE_SUCCESS',
							`update_by`			= '990',
							`update_date`		= '{$arr['date']}',
							`total_fee`			= '{$arr['total_fee']}'
						WHERE
							`out_trade_no` 		= '{$arr['out_trade_no']}'
					 ";

			$rs = $this->conn->query( $strSQL );

			if ( $rs == 0 )
			{
				$this->conn->query("ROLLBACK");
				$log_->log_result($this->log_name,"【{$arr['out_trade_no']}】【订单状态修改有误,原因：更新wxpay_order_info记录失败】\n{$strSQL}\n");
				break;
			}


			/*==================================== 2、更新用户订单的状态 user_order.status = 2  ======================================*/
			$strSQL = "UPDATE `user_order` SET `pay_status`=1, `order_status`=2, `update_date`='".date('Y-m-d H:i:s')."' WHERE `out_trade_no`= '{$arr['out_trade_no']}' AND `order_status`=1";
		 	$rs = $this->conn->query( $strSQL );

		 	if ( $rs == 0 )
			{
				$this->conn->query("ROLLBACK");
				$log_->log_result($this->log_name,"【{$arr['out_trade_no']}】【订单状态修改有误,原因：更新user_order记录失败】\n{$strSQL}\n");
				break;
			}

			/*==================================== 3、更新 coupon_order.status 的状态  ======================================*/
			$strSQL = "UPDATE `coupon_order` SET `status`=1 WHERE `order_id` in ( SELECT `id` FROM `user_order` WHERE `out_trade_no`='{$arr['out_trade_no']}' )";
			$rs = $this->conn->query( $strSQL );

			if ( $rs > 0 )
			{
				$log_->log_result($this->log_name,"【{$arr['out_trade_no']}】【修改coupon_order.status的记录】\n{$strSQL}\n");
				break;
			}

			/*==================================== 4、更新产品销售数量  ======================================*/
			$strSQL   = "SELECT `id` FROM `user_order` WHERE `out_trade_no`= '{$arr['out_trade_no']}'";
			$arrOrder = $this->conn->get_results($strSQL);															// 获取out_trade_no对应的order_id

			foreach( $arrOrder as $order )
			{
				$strSQL 	= "SELECT `product_id`,`num` FROM `user_order_detail` WHERE `order_id`={$order->id}";
				$arrProduct = $this->conn->get_results($strSQL);													// 获取order_id到对应的order_detail里面获取产品信息和数量

				foreach ( $arrProduct as $product )
				{
					$sql = "UPDATE `product` SET `sell_number`= `sell_number` + {$product->num} WHERE `id` = {$product->product_id}";
					$this->conn->query($sql);																		// 更新产品的数量
				}

			}


			$bSuccess  = true;
			$this->conn->query("COMMIT");
			$log_->log_result($this->log_name,"【{$arr['out_trade_no']}】【微信支付成功,订单状态修改成功】");
		}while(0);

		return $bSuccess;
	 }

	 /*
	  *  更新user_order.out_trade_no
	  * */
	 public function u_user_order_trade_no( $order_id, $user_id, $out_trade_no )
	 {
	 	$strSQL = "UPDATE `user_order` SET `out_trade_no`= '{$out_trade_no}'  WHERE `id`={$order_id} AND `user_id`={$user_id} AND `order_status`=1";
	 	$rs = $this->conn->query( $strSQL );
	 	return ( $rs > 0 ) ? true : false;
	 }



}