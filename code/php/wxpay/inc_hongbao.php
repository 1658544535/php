<?php
	require_once WXPAID_ROOT . 'func_wxpay.php';
	require_once WXPAID_ROOT . 'log_.php';

	class HongBao extends WxPayHelper
	{
		private $openid;
		private $nick_name 		= 'nick_name';
		private $send_name 		= 'send_name';
		private $total_amount;
		private $wishing 		= 'wishing';
		private $act_name 		= 'act_name';
		private $remark 		= "remark";
		private $total_num      = 1;
		private $logs;
		private $log_file;

		public function __construct()
		{
			$this->logs		= new Log_();
			$this->log_file = LOG_INC . "redpacket/" . date('Ymd') . ".txt";
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
		 *	功能：发送现金红包
		 */
		public function sendredpack()
		{
			try
			{
				if ( null == $this->openid || "" == $this->openid )
				{
				   throw new SDKRuntimeException("openid不能为空！" . "<br>");
				}

				$this->setParameter("nonce_str", $this->get_rand());
				$this->setParameter("mch_billno", WxPayConf_pub::MCHID.date('YmdHis').rand(1000, 9999));
				$this->setParameter("mch_id", WxPayConf_pub::MCHID);
				$this->setParameter("wxappid", WxPayConf_pub::APPID);
				$this->setParameter("nick_name", $this->nick_name);
				$this->setParameter("send_name", $this->send_name);
				$this->setParameter("re_openid", $this->openid);
				$this->setParameter("total_amount", $this->total_amount);
				$this->setParameter("min_value", $this->total_amount);
				$this->setParameter("max_value", $this->total_amount);
				$this->setParameter("total_num", 1);
				$this->setParameter("wishing", $this->wishing);
				$this->setParameter("client_ip", '127.0.0.1');
				$this->setParameter("act_name", $this->act_name);
				$this->setParameter("remark", $this->remark);
				$this->setParameter("sign", $this->get_sing());

				//header("Content-type: text/xml");
				//echo $output_xml_data   = $this->output_xml_data();					// 生成xml

				$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
				$response_xml_data = $this->setResponseXml( $url );						// 调用红包接口，并获取返回xml
				$this->logs->log_result($this->log_file,$response_xml_data);
				return $this->get_xml_data($response_xml_data);							// 把获取的xml转换成arr
			}
			catch (SDKRuntimeException $e)
			{
				$this->logs->log_result($this->log_file,$e->errorMessage());
				return false;
			}


		}



		/*
		 *	功能：发送裂变红包
		 */
		public function sendgroupredpack()
		{
			try
			{
				if ( null == $this->openid || "" == $this->openid )
				{
				   throw new SDKRuntimeException("openid不能为空！" . "<br>");
				}

				$this->setParameter("nonce_str", $this->get_rand());
				$this->setParameter("mch_billno", WxPayConf_pub::MCHID.date('YmdHis').rand(1000, 9999));
				$this->setParameter("mch_id", WxPayConf_pub::MCHID);
				$this->setParameter("wxappid", WxPayConf_pub::APPID);
				$this->setParameter("send_name", $this->send_name);
				$this->setParameter("re_openid", $this->openid);
				$this->setParameter("total_amount", $this->total_amount);
				$this->setParameter("total_num", $this->total_num);
				$this->setParameter("amt_type", 'ALL_RAND');
				$this->setParameter("wishing", $this->wishing);
				$this->setParameter("act_name", $this->act_name);
				$this->setParameter("remark", $this->remark);
				$this->setParameter("sign", $this->get_sing());

				header("Content-type: text/xml");
				echo $output_xml_data   = $this->output_xml_data();			// 生成xml
exit;
				$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendgroupredpack';
				$response_xml_data = $this->setResponseXml( $url );					// 调用红包接口，并获取返回xml

				$rs = $this->get_xml_data($response_xml_data);					// 把获取的xml转换成arr
				var_dump($rs);
				return $rs;
			}
			catch (SDKRuntimeException $e)
			{
				die($e->errorMessage());
			}
		}
	}
?>