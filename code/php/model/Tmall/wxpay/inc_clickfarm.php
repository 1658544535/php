<?php

	define('WXPAID_ROOT', dirname(__FILE__) . '/');
	require_once WXPAID_ROOT . 'func_wxpay.php';
	require_once WXPAID_ROOT . 'log_.php';

	class ClickFarm extends WxPayHelper
	{
		private $logs;
		private $log_file;

		public function __construct()
		{
			$this->logs		= new Log_();
			$this->log_file = LOG_INC . "ClickFarm/" . date('Ymd') . ".txt";
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
		 *	功能：发送支付二维码
		 */
		public function getQrCode( $total_fee, $out_trade_no )
		{
			try
			{
				$this->setParameter("appid", WxPayConf_pub::APPID);
				$this->setParameter("mch_id", WxPayConf_pub::MCHID);
				$this->setParameter("nonce_str", $this->get_rand());
				$this->setParameter("body", '刷单订单支付');
				$this->setParameter("out_trade_no", $out_trade_no );
				$this->setParameter("total_fee", $total_fee );
				$this->setParameter("spbill_create_ip", '127.0.0.1');
				$this->setParameter("notify_url", 'http://weixinm2c.taozhuma.com/model/ClickFarm/wxpay/notify_url.php');
				$this->setParameter("trade_type", 'NATIVE');
				$this->setParameter("sign", $this->get_sing());

				//header("Content-type: text/xml");
				//echo $output_xml_data   = $this->output_xml_data();					// 生成xml

				$url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
				$response_xml_data = $this->setResponseXml( $url );						// 调用接口，并获取返回xml
				$this->logs->log_result($this->log_file,$response_xml_data);
				return $this->get_xml_data($response_xml_data);							// 把获取的xml转换成arr
			}
			catch (SDKRuntimeException $e)
			{
				$this->logs->log_result($this->log_file,$e->errorMessage());
				return false;
			}
		}

	}
?>