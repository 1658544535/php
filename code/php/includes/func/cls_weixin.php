<?php
/**
 * 微信
 */
include_once(SCRIPT_ROOT.'includes/func/wechat.class.php');
class Weixin extends Wechat{
    protected $cacheDir;

    public function __construct($options){
        parent::__construct($options);
        $this->cacheDir = SCRIPT_ROOT.'data/wxcache/';
    }

    /**
     * 设置缓存，按需重载
     * @param string $cachename
     * @param mixed $value
     * @param int $expired
     * @return boolean
     */
    protected function setCache($cachename,$value,$expired){
        if(strpos($cachename, 'wechat_access_token') === FALSE){
            !file_exists($this->cacheDir) && mkdir($this->cacheDir, 0777, true);
            $data = array(
                'value' => $value,
                'expired' => time()+$expired,
            );
            file_put_contents($this->cacheDir.$cachename.'.php', json_encode($data));
        }else{//为兼容系统原来保存的access_token
            $data = array(
                'access_token' => $value,
                'expire_time' => time()+7000,
            );
            file_put_contents(LOG_INC.'access_token.json', json_encode($data));
        }
        return true;
    }

    /**
     * 获取缓存，按需重载
     * @param string $cachename
     * @return mixed
     */
    protected function getCache($cachename){
        if(strpos($cachename, 'wechat_access_token') === FALSE){
            $cacheFile = $this->cacheDir.$cachename.'.php';
            if(!file_exists($cacheFile)) return null;
            $cache = file_get_contents($cacheFile);
            $cache = json_decode($cache, true);
            return ($cache['expired'] < time()) ? null : $cache['value'];
        }else{//为兼容系统原来保存的access_token
            $cacheFile = LOG_INC.'access_token.json';
            if(!file_exists($cacheFile)) return null;
            $cache = file_get_contents($cacheFile);
            $cache = json_decode($cache, true);
            return ($cache['expire_time'] < time()) ? null : $cache['access_token'];
        }
    }
}