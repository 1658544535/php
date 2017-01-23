<?php
require_once "WxPay.Exception.php";
require_once "WxPay.Config.php";
require_once "WxPay.Data.php";

class WxHongBaoApi{
	private $urlRedPack = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
	private $values = array();

	/**
	* 设置签名，详见签名生成算法
	* @param string $value 
	**/
	private function SetSign()
	{
		$sign = $this->MakeSign();
		$this->values['sign'] = $sign;
		return $sign;
	}
	
	/**
	* 获取签名，详见签名生成算法的值
	* @return 值
	**/
	private function GetSign()
	{
		return $this->values['sign'];
	}
	
	/**
	* 判断签名，详见签名生成算法是否存在
	* @return true 或 false
	**/
	private function IsSignSet()
	{
		return array_key_exists('sign', $this->values);
	}

	/**
	 * 输出xml字符
	 * @throws WxPayException
	**/
	private function ToXml()
	{
		if(!is_array($this->values) 
			|| count($this->values) <= 0)
		{
    		throw new WxPayException("数组数据异常！");
    	}
    	
    	$xml = "<xml>";
    	foreach ($this->values as $key=>$val)
    	{
    		if (is_numeric($val)){
    			$xml.="<".$key.">".$val."</".$key.">";
    		}else{
    			$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
    		}
        }
        $xml.="</xml>";
        return $xml; 
	}
	
    /**
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
	private function FromXml($xml)
	{	
		if(!$xml){
			throw new WxPayException("xml数据异常！");
		}
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);		
		return $data;
	}

	/**
	 * 格式化参数格式化成url参数
	 */
	private function ToUrlParams()
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
	
	/**
	 * 生成签名
	 * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
	 */
	private function MakeSign()
	{
		//签名步骤一：按字典序排序参数
		ksort($this->values);
		$string = $this->ToUrlParams();
		//签名步骤二：在string后加入KEY
		$string = $string . "&key=".WxPayConfig::KEY;
		//签名步骤三：MD5加密
		$string = md5($string);
		//签名步骤四：所有字符转为大写
		$result = strtoupper($string);
		return $result;
	}
	
	/**
	 * 获取设置的值
	 */
	private function GetValues()
	{
		return $this->values;
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
	private static function postXmlCurl($xml, $url, $useCert = false, $second = 30)
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
	 * 生成随机字段串
	 *
	 * @param integer $len 长度
	 * @param integer $type 类型，0大小字母与数字，1数字，2小写字母，3大写字母，4小写字母与数字，5大写字母与数字
	 * @return string
	 */
	private function generateRandStr($len=6, $type=0){
		$lowerLetters = 'abcdefghijklmnopqrstuvwxyz';
		$upperLetters = strtoupper($lowerLetters);
		$numbers = '0123456789';
		$map = array(
			0 => $numbers.$lowerLetters.$upperLetters,
			1 => $numbers,
			2 => $lowerLetters,
			3 => $upperLetters,
			4 => $lowerLetters.$numbers,
			5 => $upperLetters.$numbers,
		);
		!in_array($type, array_keys($map)) && $type = 0;
		return substr(str_shuffle($map[$type]), 0, $len);
	}

	/**
	 * 发送普通红包
	 *
	 * @param array $data 数据
	 *	billNo 商户订单号
	 *	openid 红包接收者openid
	 *	sendName 红包发送者名称(商户名称)
	 *	amount 金额，单位分
	 *	num 发放总人数
	 *	wishing 祝福语
	 *	activityName 活动名称
	 *	remark 备注
	 */
	public function sendRedPack($data){
		$this->values['mch_id'] = WxPayConfig::MCHID;
		$this->values['wxappid'] = WxPayConfig::APPID;
		$this->values['mch_billno'] = $data['billNo'];
		$this->values['re_openid'] = $data['openid'];
		$this->values['send_name'] = $data['sendName'];
		$this->values['total_amount'] = $data['amount'];
		$this->values['total_num'] = $data['num'];
		$this->values['wishing'] = $data['wishing'];
		$this->values['act_name'] = $data['activityName'];
		$this->values['remark'] = $data['remark'];
		$this->values['nonce_str'] = $this->generateRandStr(32, 5);
		$this->SetSign();
		$xml = $this->ToXml();
		$response = self::postXmlCurl($xml, $this->urlRedPack, true, 4);
		return $this->FromXml($response);
	}
}
?>