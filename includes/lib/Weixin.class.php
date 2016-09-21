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
}