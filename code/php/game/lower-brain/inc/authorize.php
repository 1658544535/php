<?php
/*
 * 	功能：网页用户授权
 *  1、第一步：用户同意授权，获取code
 *  2、第二步：通过code换取网页授权access_token
 *  3、第三步：刷新access_token
 *  4、第四步：拉取用户信息(需scope为 snsapi_userinfo)
 * */
class authorize
{
  private $appId;
  private $appSecret;

  public function __construct( $appId, $appSecret )
  {
    $this->appId = $appId;
    $this->appSecret = $appSecret;
  }


  /*
   * 功能：用户同意授权，获取code
   * 参数：
   * $type : userinfo(弹出授权页面) / base(不弹出授权页面)
   * $return_url: 回调的网址
   * */
  public function get_code( $type, $return_url )
  {
  		if ( $type == 'userinfo' )
  		{
  			$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->appId&redirect_uri=".urlencode($return_url)."&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
  		}
  		else
  		{
			$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->appId&redirect_uri=".urlencode($return_url)."&response_type=code&scope=snsapi_base&state=2#wechat_redirect";
  		}

		return $url;
  }

  /*
   * 功能：通过code换取网页授权access_token，并刷新access_token
   * 返回结果：
   * 	{
   *		"openid":" OPENID",
   *		" nickname": NICKNAME,
   *		"sex":"1",
   *		"province":"PROVINCE"
   *		"city":"CITY",
   *		"country":"COUNTRY",
   *		"headimgurl":    "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46",
   *		"privilege":[
   *			"PRIVILEGE1"
   *			"PRIVILEGE2"
   *		 ],
   *		"unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
   *	}
   * */
  public function get_user_info( $code )
  {
		// 1、通过code换取网页授权access_token
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appId&secret=$this->appSecret&code=$code&grant_type=authorization_code";
		$data = json_decode($this->httpGet($url), true);

		if ( isset( $data['errcode'] ) )
		{
        	file_put_contents("user_info_error.json" , json_encode($data));
			return false;
		}

		// 2、刷新access_token
		$url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid={$this->appId}&grant_type=refresh_token&refresh_token={$data['refresh_token']}";
		$data = json_decode($this->httpGet($url), true);


		if ( isset( $data['errcode'] ) )
		{
			file_put_contents("user_info_error.json" , json_encode($data));
			return false;
		}

		// 3、拉取用户信息(需scope为 snsapi_userinfo)
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token={$data['access_token']}&openid={$data['openid']}&lang=zh_CN";
		$data = json_decode($this->httpGet($url), true);

		if ( isset( $data['errcode'] ) )
		{
			file_put_contents("user_info_error.json", json_encode($data));
			return false;
		}

		return $data;
  }

    /*
   * 功能：通过code换取openid
   * 返回结果：
   * 	{
   *		"access_token":"ACCESS_TOKEN",
   *		"expires_in":7200,
   *		"refresh_token":"REFRESH_TOKEN",
   *		"openid":"OPENID",
   *		"scope":"SCOPE",
   *		"unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
   *	}
   * */
  public function get_user_base( $code )
  {
  		// 1、通过code换取openid
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appId&secret=$this->appSecret&code=$code&grant_type=authorization_code";
		return json_decode($this->httpGet($url));
  }


  // 远程操作
  private function httpGet($url)
  {
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    curl_setopt($curl, CURLOPT_URL, $url);

	    $res = curl_exec($curl);
	    curl_close($curl);

	    return $res;
  }
}

