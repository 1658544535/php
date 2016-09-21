<?php

class LogSeas
{
	private $handle 	 = null;
	private $modulePath  = '';
	private $isShowLevel = FALSE;

    public function __construct()
    {

    }


    public function __destruct()
    {
    	if ( $this->handle != NULL )
    	{
    		fclose($this->handle);
    	}
    }

    /**
     *	功能：插入操作
     */
    protected function write( $level, $msg )
	{
		$wLevel = $this->isShowLevel == TRUE ?  strtolower($level) . '_' : '';
		$dir = $this->getBasePath() .'/'. $this->getLogger() . '/' . $wLevel . date('Y_m_d') . '.log';
		$this->handle = fopen($dir, 'a');
		$msg = '['.date('Y-m-d H:i:s').']['.$level.'] '.$msg."\n";
		fwrite($this->handle, $msg, 4096);
	}

	public function isSHowLevel( $bShow = FALSE )
	{
		$this->isShowLevel = $bShow;
	}


    /**
     * 设置basePath
     * @param $basePath
     * @return bool
     */
    public function setBasePath( $basePath )
    {
		if ( !file_exists( $basePath ) )
		{
			mkdir($basePath, 0777, true);
		}

		$this->basePath = $basePath;
    }


    /**
     * 获取basePath
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }


    /**
     * 设置模块目录
     * @param $module
     * @return bool
     */
    public function setLogger($module)
    {
    	$dir = $this->getBasePath() .'/'. $module;
        if ( !file_exists( $dir ) )
		{
			mkdir($dir, 0777, true);
		}

		$this->modulePath = $module;
    }


    /**
     * 获取最后一次设置的模块目录
     * @return string
     */
    public function getLogger()
    {
        return $this->modulePath;
    }



    /**
     * 获得当前日志buffer中的内容
     * @return array
     */
    public function getBuffer()
    {
        return array();
    }

    /**
     * 将buffer中的日志立刻刷到硬盘
     *
     * @return bool
     */
    public function flushBuffer()
    {
        return TRUE;
    }


    /**
     * 记录debug日志
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function debug($message)
    {
        $this->write('DEBUG',$message);
    }


    /**
     * 记录info日志
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function info($message)
    {
        $this->write('INFO',$message);
    }


    /**
     * 记录notice日志
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function notice($message)
    {
        $this->write('NOTICE',$message);
    }


    /**
     * 记录warning日志
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function warning($message)
    {
         $this->write('WARNING',$message);
    }


    /**
     * 记录error日志
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function error($message)
    {
        $this->write('ERROR',$message);
    }


    /**
     * 记录critical日志
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function critical($message)
    {
        $this->write('CRITICAL',$message);
    }


    /**
     * 记录alert日志
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function alert($message)
    {
        $this->write('ALERT',$message);
    }


    /**
     * 记录emergency日志
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function emergency($message)
    {
        $this->write('EMERGENCY',$message);
    }


    /**
     * 通用日志方法
     * @param $level
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function log($level,$message)
    {
		$this->write($level,$message);
    }
}
?>
