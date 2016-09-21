<?php

	require_once "WxPayHelper.php";

	class RedPackCore extends WxPayHelper
	{
		private $value;
		private $url;


		public function __construct($type)
		{
			$this->value = array();
			$this->init( $type );
		}


		/**
		 * 根据类型做出现有的红包操作
		 * */
		private function init( $type )
		{
			switch ( $type )
			{
				case 'cash':
					$this->url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
				break;

				case 'group':
					$this->url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendgroupredpack';
				break;

				case 'error':
				break;
			}
		}


		/**
		 * 现金红包操作
		 * */
		public function cash_option()
		{
			$this->getNonceStr();
			$this->getMchBillno();
			$this->getMchId();
			$this->getWxAppId();
			$this->setTotalNum(1);
			$this->getClientIp();
			$this->getSign();

$isDebug = TRUE;

			if ($isDebug)
			{
				$output_xml_data   = $this->setResponseXml($this->url);					// 生成xml
				$rs = $this->get_xml_data($output_xml_data);							// 把获取的xml转换成arr
			}
			else
			{
				$rs = array(
					"return_code"	=> "FALT",
					"return_msg"	=> "此IP地址不允许调用接口，如有需要请登录微信支付商户平台更改配置" ,
					"result_code"	=> "SUCCESS" ,
					"err_code"		=> "NO_AUTH" ,
					"err_code_des"	=> "此IP地址不允许调用接口，如有需要请登录微信支付商户平台更改配置" ,
					"mch_billno"	=> "1288970801201512151133168728" ,
					"mch_id"		=> "1288970801" ,
					"wxappid"		=> "wx94138c1f4a3126d0" ,
					"re_openid"		=> "oqhMswGN1Od_tUDErqHbSLeMCMmE" ,
					"total_amount"	=> "1"
				);
			}

			return $rs;

		}

	}
?>