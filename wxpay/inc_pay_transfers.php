<?php

	require_once WXPAID_ROOT . 'func_wxpay.php';
	require_once WXPAID_ROOT . 'log_.php';

	class PayTransfers extends WxPayHelper
	{
		private $logs;
		private $log_file;

		public function __construct()
		{
			$this->logs		= new Log_();
			$this->log_file = LOG_INC . "paymkttransfers/" . date('Ymd') . ".txt";
		}

		public function get_val( $name )
		{
			return  ( isset($this->$name) ) ? $this->$name : null;
		}

		public function set_val( $name, $val )
		{
			$this->$name = $val;
		}

		/*
		 *	功能：企业付款
		 */
		public function transfers( $arrParam )
		{
			try
			{
				if ( ! isset( $arrParam['openid'] ) )
				{
				   throw new SDKRuntimeException("openid不存在！" . "<br>");
				}

				if ( empty($arrParam['openid']) )
				{
					throw new SDKRuntimeException("openid不能为空！" . "<br>");
				}

				return $this->_set_transfers( $arrParam );			// 调用企业付款

			}
			catch (SDKRuntimeException $e)
			{
				$this->logs->log_result($this->log_file,$e->errorMessage());
				return false;
			}
		}


		/*
		 *	功能：查询企业付款
		 */
		public function get_transfer_info( $partner_trade_no )
		{
			try
			{
				if ( empty( $partner_trade_no ) )
				{
					throw new SDKRuntimeException("订单号不能为空！\n");
				}

				return $this->_get_transfer_info( $partner_trade_no );			// 调用查询企业付款

			}
			catch (SDKRuntimeException $e)
			{
				$this->logs->log_result($this->log_file,$e->errorMessage());
				return false;
			}

		}


		/*
		 *	功能：设置企业付款
		 */
		private function _set_transfers( $arrParam )
		{
			$this->setParameter("mch_appid", WxPayConf_pub::APPID);
			$this->setParameter("mchid", WxPayConf_pub::MCHID);
			$this->setParameter("nonce_str", $this->get_rand());
			$this->setParameter("partner_trade_no", WxPayConf_pub::MCHID.date('YmdHis').rand(1000, 9999));
			$this->setParameter("check_name", 'NO_CHECK');
			$this->setParameter("spbill_create_ip", '127.0.0.1');

			foreach ( $arrParam as $key=>$data )
			{
				$this->setParameter( $key, $data);
			}

			$this->setParameter("sign", $this->get_sing());

			$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
			$response_xml_data = $this->setResponseXml( $url );						// 调用红包接口，并获取返回xml

			$this->logs->log_result($this->log_file,$response_xml_data);
			return $this->get_xml_data($response_xml_data);							// 把获取的xml转换成arr
		}


		/*
		 *	功能：查询企业付款
		 */
		private function _get_transfer_info( $partner_trade_no )
		{
			$this->setParameter("appid", WxPayConf_pub::APPID);
			$this->setParameter("mch_id", WxPayConf_pub::MCHID);
			$this->setParameter("nonce_str", $this->get_rand());
			$this->setParameter("partner_trade_no", $partner_trade_no);
			$this->setParameter("sign", $this->get_sing());

			$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/gettransferinfo';
			$response_xml_data = $this->setResponseXml( $url );						// 调用红包接口，并获取返回xml

			$this->logs->log_result($this->log_file,$response_xml_data);
			return $this->get_xml_data($response_xml_data);							// 把获取的xml转换成arr
		}

	}



//$PayTransfers = new PayTransfers();
//
// 企业支付
//$arrParam = array(
//	'openid'=> 'o6MuHtwL7s7gntl6xYmXHikcD6zQ',
//	'amount'=> '100',
//	'desc'=>'测试企业付款'
//);
//
//$rs = $PayTransfers->transfers( $arrParam );
//var_dump($rs);

?>