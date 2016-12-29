<?php
/**
 * 微信类
 */
$__CUR_DIR = dirname(__FILE__);
include_once($__CUR_DIR.'/weixin/wechat.class.php');
define('WX_CACHE_DIR', $__CUR_DIR.'/../../data/wx');
define('WX_LOG_DIR', $__CUR_DIR.'/../../logs/wx');

class Weixin extends Wechat{
    private $cacheDir;
    private $logDir;
    private $oauthAccessTokenVar = 'oauth_access_token';

    const TAG_GET_URL='/tags/get?';
	const TAG_CREATE_URL='/tags/create?';
	const TAG_UPDATE_URL='/tags/update?';
    const TAG_DELETE_URL='/tags/delete?';
    const TAG_USER_URL='/user/tag/get?';
    const TAG_MEMBER_BATCHTAG_URL = '/tags/members/batchtagging?';
    const TAG_MEMBER_BATCHUNTAG_URL = '/tags/members/batchuntagging?';
    const TAG_MEMBER_IDLIST_URL = '/tags/getidlist?';

    public function __construct($options){
        parent::__construct($options);
        $this->cacheDir = WX_CACHE_DIR.'/';
        !file_exists($this->cacheDir) && mkdir($this->cacheDir, 0777, true);
        $this->logDir = WX_LOG_DIR.'/';
        !file_exists($this->logDir) && mkdir($this->logDir, 0777, true);
    }

    /**
     * 设置缓存，按需重载
     * @param string $cachename
     * @param mixed $value
     * @param int $expired
     * @return boolean
     */
    protected function setCache($cachename,$value,$expired){
        $cacheFile = $this->cacheDir.$cachename.'.php';
        $data = array(
            $cachename => $value,
            'expire' => time() + $expired,
        );
        $content = "<?php\r\nreturn ".var_export($data, true).";\r\n?>";
        file_put_contents($cacheFile, $content, LOCK_EX);
    }

    /**
     * 获取缓存，按需重载
     * @param string $cachename
     * @return mixed
     */
    protected function getCache($cachename)
    {
        static $wxCache = array();
        $time = time();
        if(!empty($wxCache[$cachename]) && ($wxCache[$cachename]['expire'] - $time > 0))
        {
            return $wxCache[$cachename][$cachename];
        }
        $cacheFile = $this->cacheDir.$cachename.'.php';

        if(file_exists($cacheFile))
        {
            $wxCache[$cachename] = include($cacheFile);
            return ($wxCache[$cachename]['expire'] - $time > 0) ? $wxCache[$cachename][$cachename] : false;
        }
        else
        {
            return false;
        }
    }

    /**
     * 清除缓存，按需重载
     * @param string $cachename
     * @return boolean
     */
    protected function removeCache($cachename){
        $cacheFile = $this->cacheDir.$cachename.'.php';
        @unlink($cacheFile);
    }

    /**
     * 记录日志文件
     *
     * @param string $msg 日志信息
     * @param array $data 额外/详细信息
     */
    public function writeLog($msg, $data=array()){
        $file = $this->logDir.'wx_'.date('Y-m-d', time()).'.log';
        $str = '['.date('Y-m-d H:i:s', time()).'] '.$msg;
        !empty($data) && $str .= "\r\n".print_r($data, true);
        $str .= "\r\n";
        $handler = fopen($file,'a');
        fwrite($handler, $str, 4096);
        fclose($handler);
    }

    public function sendTemplateMessage($data){
        $result = parent::sendTemplateMessage($data);
        if($result === false){
            $this->writeLog('发送模板消息失败', array('openid'=>$data['touser'], 'errcode'=>$this->errCode, 'errmsg'=>$this->errMsg));
            return false;
        }else{
            return true;
        }
    }

    /**
	 * 获取标签列表
     *
	 * @return boolean|array
	 */
	public function getTag(){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_get(self::API_URL_PREFIX.self::TAG_GET_URL.'access_token='.$this->access_token);
		if ($result)
		{
			$json = json_decode($result,true);
			if (isset($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * 新增自定标签
     *
	 * @param string $name 标签名称
	 * @return boolean|array
	 */
	public function createTag($name){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$data = array(
			'tag'=>array('name'=>$name)
		);
		$result = $this->http_post(self::API_URL_PREFIX.self::TAG_CREATE_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * 更改标签名称
     *
	 * @param int $tagid 标签id
	 * @param string $name 标签名称
	 * @return boolean
	 */
	public function updateTag($tagid,$name){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$data = array(
			'tag'=>array('id'=>$tagid,'name'=>$name)
		);
		$result = $this->http_post(self::API_URL_PREFIX.self::TAG_UPDATE_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return true;
		}
		return false;
	}

    /**
     * 删除标签
     *
     * @return boolean
     */
    public function deleteTag($tagid){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array(
			'tag'=>array('id'=>$tagid,'name'=>$name)
		);
        $result = $this->http_post(self::API_URL_PREFIX.self::TAG_DELETE_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return true;
		}
		return false;
    }

    /**
	 * 获取标签下的粉丝
     *
     * @param integer $tagid 标签id
	 * @param string $openid
	 * @return boolean|array
	 */
	public function getUserTag($tagid, $openid=''){
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $data = array(
            'tagid' => $tagid,
	        'next_openid'=>$openid
	    );
	    $result = $this->http_post(self::API_URL_PREFIX.self::TAG_USER_URL.'access_token='.$this->access_token,self::json_encode($data));
	    if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
            return $json;
	    }
	    return false;
	}

    /**
     * 批量给用户打标签
     *
     * @param integer $tagid 标签id
     * @param array $openids 用户openid
     * @return boolean
     */
    public function memberBatchTag($tagid, $openids){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array(
            'tagid' => $tagid,
	        'openid_list' => $openids
	    );
        $result = $this->http_post(self::API_URL_PREFIX.self::TAG_MEMBER_BATCHTAG_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
            return true;
	    }
	    return false;
    }

    /**
     * 批量给用户取消标签
     *
     * @param integer $tagid 标签id
     * @param array $openids 用户openid
     * @return boolean
     */
    public function memberBatchUnTag($tagid, $openids){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array(
            'tagid' => $tagid,
	        'openid_list' => $openids
	    );
        $result = $this->http_post(self::API_URL_PREFIX.self::TAG_MEMBER_BATCHUNTAG_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
            return true;
	    }
	    return false;
    }

    /**
     * 获取用户的标签
     *
     * @param string $openid 用户openid
     * @return array
     */
    public function memberTagidList($openid){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array(
            'openid' => $openid
	    );
        $result = $this->http_post(self::API_URL_PREFIX.self::TAG_MEMBER_IDLIST_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }else{
                if(isset($json['tagid_list'])) return $json['tagid_list'];
            }
	    }
	    return false;
    }
}