<?php
class JSSDK
{
  private $appId;
  private $appSecret;

  public function __construct($appId, $appSecret)
  {
	$this->appId = $appId;
	$this->appSecret = $appSecret;
  }

	public function getSignPackage()
	{
		return $this->setSignPackage();
	}


   /* 获取 AccessToken */
	public function get_AccessToken()
	{
		return $this->setAccessToken();
	}

	/* 获取用户信息 */
	public function get_userinfo( $openid )
	{
		return $this->getuserinfo( $openid );
	}

	/* 获取二维码ticket */
	public function getQrcodePic( $action_name, $scene_id, $expire_seconds='604800', $download_file_name='' )
	{
		return $this->setQrcodeTicket( $action_name, $scene_id, $expire_seconds, $download_file_name );
	}


	/* 下载图片 */
	public function downloadMedia( $media_id, $download_file_name='' )
	{
		return $this->setDownloadMedia(  $media_id, $download_file_name );
	}




  /*
   *  功能：签名，将jsapi_ticket、noncestr、timestamp、分享的url按字母顺序连接起来，进行sha1签名。
   */
  public function setSignPackage() {
    $jsapiTicket = $this->getJsApiTicket();

    // 注意 URL 一定要动态获取，不能 hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
      "appId"     => $this->appId,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage;
  }


  /*
   *  功能：设置随机值
   */
  private function createNonceStr($length = 16)
  {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++)
    {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }


  /*
   *  功能：通过access_token，获取jsapi的ticket。jsapi_ticket是公众号用于调用微信JS接口的临时票据，有效期7200秒
   */
  private function getJsApiTicket() {
    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode(file_get_contents( LOG_INC. "jsapi_ticket.json"));
    if ($data->expire_time < time())
    {
      $accessToken = $this->setAccessToken();
      // 如果是企业号用以下 URL 获取 ticket
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->https_request($url));
      $ticket = $res->ticket;
      if ($ticket)
      {
        $data->expire_time = time() + 7000;
        $data->jsapi_ticket = $ticket;
        $fp = fopen( LOG_INC. "jsapi_ticket.json", "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
      }
    }
    else
    {
      $ticket = $data->jsapi_ticket;
    }

    return $ticket;
  }


  /*
   *  功能：获取令牌，access_token
   */
  private function setAccessToken()
  {
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode(file_get_contents( LOG_INC. "access_token.json"));

    if ($data->expire_time < time())
    {
      // 如果是企业号用以下URL获取access_token
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
      $res = json_decode($this->https_request($url));
      $access_token = $res->access_token;
      if ($access_token) {
        $data->expire_time = time() + 7000;
        $data->access_token = $access_token;
        $fp = fopen(LOG_INC. "access_token.json", "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
      }
    }
    else
    {
      $access_token = $data->access_token;
    }
    return $access_token;
  }

  /*
   *	功能：赋值二维码ticket
   *	参数：
   *	$action_name： QR_SCENE为临时 / QR_LIMIT_SCENE为永久
   *	$scene_id：场景值ID
   *	$expire_seconds: 有效期，供 QR_SCENE使用
   *	$download_file_name : 如果为空则不下载
   */
  private function setQrcodeTicket( $action_name, $scene_id, $expire_seconds, $download_file_name )
  {
	$accessToken = $this->setAccessToken();
	$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={$accessToken}";

	if ( $action_name == 'QR_LIMIT_SCENE' )
	{
		$data = '{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "'. $scene_id .'"}}}';
	}
	else
	{
		$data 	= '{"expire_seconds": 604800, "action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "'. $scene_id .'"}}}';
	}

	$res 		= json_decode($this->https_request( $url, $data));		// 创建二维码ticket,并获取返回信息

	if ( $download_file_name != "" )
	{
		$url 		= "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode( $res->ticket );
		$imageinfo 	= $this->downloadWeixinFile( $url );
		$this->saveWeixinFile($download_file_name, $imageinfo['body']);
	}

	return $res->ticket;
  }

  	/*
  	 * 功能：下载多媒体文件
  	 * */
  	 private function setDownloadMedia( $media_id, $download_file_name )
  	 {
  	 	$accessToken = $this->setAccessToken();
		$url 		= "https://api.weixin.qq.com/cgi-bin/media/get?access_token={$accessToken}&media_id={$media_id}";
		$imageinfo 	= $this->downloadWeixinFile( $url );
		$this->saveWeixinFile($download_file_name, $imageinfo['body']);
  	 }


    /*
	 *  功能：获取用户信息
	 */
	private function getuserinfo( $openid )
	{
		$accessToken = $this->setAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$accessToken}&openid={$openid}&lang=zh_CN";
		$res = json_decode($this->https_request($url));
		return $res;
	}

	/*
	 *	功能：获取微信文件文件
	 */
	function downloadWeixinFile($url)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$package = curl_exec($ch);
		$httpinfo = curl_getinfo($ch);
		curl_close($ch);
		return array_merge(array('header' => $httpinfo), array('body' => $package));
	}

	/* 保存微信文件 */
	function saveWeixinFile($filename, $filecontent)
	{
		$local_file = fopen($filename, 'w');
		if (false !== $local_file)
		{
			if (false !== fwrite($local_file, $filecontent))
			{
				fclose($local_file);
			}
		}
	}

	/*
	 *	功能：获取远程数据
	 */
	function https_request( $url, $data = null )
	{
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, FALSE  );
		if ( $data != null )
		{
			curl_setopt( $curl, CURLOPT_POST, 1);
			curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$output = curl_exec($curl);
		curl_close($curl);

		return $output;
	}

}

