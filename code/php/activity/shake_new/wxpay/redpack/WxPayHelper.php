<?php
/**
* 	功能：微信支付的基本操作类
**/

require_once dirname(dirname(__FILE__)) . "/lib/WxPay.Config.php";
require_once dirname(dirname(__FILE__)) . "/lib/WxPay.Exception.php";


/**
 *
 * 数据对象基础类，该类中定义数据类最基本的行为，包括：
 * 计算/设置/获取签名、输出xml格式的参数、从xml读取数据对象等
 * @author widyhu
 *
 */
class WxPayHelper
{
	/**
	 *
	 * 设置指定参数值
	 * @param name 			// 要赋值的名称
	 * @param value 		// 要赋值的名称的值
	 * @return void
	 */
//	public function setParameter($name, $value)
//	{
//		$this->values[$name] = $value;
//	}

	/**
	 *
	 * 获取指定参数值
	 * @param name 		// 要获取的值
	 * @return string
	 */
//	public function getParameter($name)
//	{
//		return $this->values[$name];
//	}

	/*
	 *	设置获取到xml的返回值
	 */
	public function setResponseXml( $url )
	{
		try
		{
			if ( null == $url || "" == $url )
			{
			   throw new WxPayException("请求地址不能为空！" . "<br>");
			}

			$xml = $this->ToXml();
			return $this->postXmlCurl($xml, $url, TRUE);
		}
		catch (WxPayException $e)
		{
			die($e->errorMessage());
		}
	}

	/* 获取签名值 */
	public function get_sing()
	{
		return $this->set_sign();
	}

	/* 获取签名值 */
	public function get_rand( $num = 30 )
	{
		return $this->set_rand( $num );
	}

	/**
	 * 获取传入参数的集合值
	 *	@return array
	 */
	public function GetValues()
	{
		return $this->values;
	}

	/*
	 *	获取xml的值
	 *  @param 需要读取的xml
	 *	@return 数组
	 */
	public function get_xml_data($xml)
	{
		return $this->set_xml_array( $xml );
	}


	/**
	 * 导出xml数据
	 *	@return string
	 */
	public function output_xml_data()
	{
		return $this->ToXml();
	}




	/* 设置签名算法 */
	private function set_sign(){
		try {
			if ( null == WxPayConfig::KEY || "" == WxPayConfig::KEY )
			{
			   throw new WxPayException("密钥不能为空！" . "<br>");
			}

			return $this->MakeSign();
		}catch (WxPayException $e)
		{
			die($e->errorMessage());
		}

	}

	/**
	 * 生成随机数
	 */
	private function set_rand( $num = 30 ){
		$t1   = "";
		$str  = '1234567890abcdefghijklmnopqrstuvwxyz';
		for( $i=0; $i<$num; $i++)
		{
			$j=rand( 0, strlen($str)-1 );
			$t1 .= $str[$j];
		}
		return $t1;
	}


	/**
		 * 随机字符串
		 * */
		public function getNonceStr()
		{
			$this->values['nonce_str'] = $this->get_rand();
		}

		/**
		 * 商户订单号
		 * */
		public function getMchBillno()
		{
			$this->values['mch_billno'] = WxPayConfig::MCHID.date('YmdHis').rand(1000, 9999);
		}

		/**
		 * 获取商户号
		 * */
		public function getMchId()
		{
			$this->values['mch_id'] = WxPayConfig::MCHID;
		}

		/**
		 * 获取公众账号appid
		 * */
		public function getWxAppId()
		{
			$this->values['wxappid'] = WxPayConfig::APPID;
		}


		/**
		 * 获取Ip地址
		 * */
		public function getClientIp()
		{
			$this->values['client_ip'] = '127.0.0.1';
			//$this->values['client_ip'] = '10.10.66.17';
		}


		/**
		 * 获取签名
		 * */
		public function getSign()
		{
			$this->values['sign'] = $this->get_sing();
		}


		/**
		 * 设置商户名称
		 */
		public function setSendName( $strParam  )
		{
			$this->values['send_name'] = $strParam;
		}


		/**
		 * 设置用户openid
		 */
		public function setReOpenID( $strParam  )
		{
			$this->values['re_openid'] = $strParam;
		}


		/**
		 * 设置付款金额
		 */
		public function setTotalAmount( $intParam  )
		{
			$this->values['total_amount'] = $intParam;
		}


		/**
		 * 设置红包发放总人数
		 */
		public function setTotalNum( $intParam  )
		{
			if ( $intParam == "" )
			{
				$this->values['total_num'] = 1;
			}
			else
			{
				$this->values['total_num'] = $intParam;
			}
		}


		/**
		 * 设置红包祝福语
		 */
		public function setWishing( $strParam  )
		{
			$this->values['wishing'] = $strParam;
		}


		/**
		 * 设置活动名称
		 */
		public function setActName( $strParam  )
		{
			$this->values['act_name'] = $strParam;
		}


		/**
		 * 设置备注
		 */
		public function setRemark( $strParam  )
		{
			$this->values['remark'] = $strParam;
		}


	/**
	 * 以post方式提交xml到对应的接口url
	 *
	 * @param string $xml  需要post的xml数据
	 * @param string $url  url
	 * @param bool $useCert 是否需要证书，默认不需要
	 * @param int $second   url执行超时时间，默认30s
	 * @throws WxPayException
	 */
	private function postXmlCurl($xml, $url, $useCert = false, $second = 30)
	{
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);

		//如果有配置代理这里就设置代理
		if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0"
			&& WxPayConfig::CURL_PROXY_PORT != 0){
			curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
			curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
		}
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		if($useCert == true){
			//设置证书
			//使用证书：cert 与 key 分别属于两个.pem文件
			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLCERT, WxPayConfig::SSLCERT_PATH);
			curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLKEY, WxPayConfig::SSLKEY_PATH);
		}
		//post提交方式
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

		//运行curl
		$data = curl_exec($ch);
		//返回结果
		if($data){
			curl_close($ch);
			return $data;
		} else {
			$error = curl_errno($ch);
			curl_close($ch);
			throw new WxPayException("curl出错，错误码:$error");
		}
	}


	/**
	 * 生成签名
	 * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
	 */
	private function MakeSign()
	{
		//签名步骤一：按字典序排序参数
		ksort($this->values);
		$string = $this->set_xml_params();
		//签名步骤二：在string后加入KEY
		$string = $string . "&key=".WxPayConfig::KEY;
		//签名步骤三：MD5加密
		$string = md5($string);
		//签名步骤四：所有字符转为大写
		$result = strtoupper($string);
		return $result;
	}

	/**
	 * 输出xml字符
	 * @throws WxPayException
	**/
	private function ToXml()
	{
		if(!is_array($this->values) || count($this->values) <= 0)
		{
    		throw new WxPayException("数组数据异常！");
    	}

    	$xml = "<xml>";
    	foreach ($this->values as $key=>$val)
    	{
    		//if (is_numeric($val)){
    		//	$xml.="<".$key.">".$val."</".$key.">";
    		//}else{
    		//	$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
    		//}

			$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
        }
        $xml.="</xml>";
        return $xml;
	}

	/**
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
	private function  set_xml_array($xml)
	{
		if(!$xml){
			throw new WxPayException("xml数据异常！");
		}
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $this->values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $this->values;
	}

	/**
	 * 格式化参数格式化成url参数
	 */
	private function set_xml_params()
	{
		$buff = "";
		foreach ($this->values as $k => $v)
		{
			if($k != "sign" && $v != "" && !is_array($v)){
				$buff .= $k . "=" . $v . "&";
			}
		}

		$buff = trim($buff, "&");
		return $buff;
	}
}
