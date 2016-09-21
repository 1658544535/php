<?php
	/*
	 *   日志管理类
	 *
	 * */

	 class Log
	 {
	 	private $type;
	 	private $log_file;
	 	private $log_root;

	 	public function __construct()
	    {
			$this->log_root = dirname(dirname(dirname(__FILE__)));
	    }

		/*
		 * 添加log的记录
		 * */
	    public function put( $file_name, $msg, $level='debug',  $module="" )
	    {
			$content = " ". $level ." | " . date('Y-m-d H:i:s') . " | ". $msg ." \n";
			$rs = file_put_contents(  $this->log_root . '/logs' . $file_name . '_'.date('Ymd') .'.txt', $content, FILE_APPEND );
	    }

		/*
		 * 输出log的记录
		 * */
	    public function get( $file_name )
	    {
			$str = file_get_contents( $this->log_root . '/logs' . $file_name . '_'.date('Ymd') .'.txt' );

			return preg_replace( '#(\n)#', '</br>', $str );
	    }

	    /*
		 * 功能：输出json文件
		 * */
	    public function put_json( $file_name, $msg )
	    {
			$rs = file_put_contents( $this->log_root . '/logs' . $file_name.'.txt', $msg );
	    }

		/*
		 * 功能：读取json文件
		 * */
	    public function get_json( $file_name )
	    {
			return file_get_contents( $this->log_root . '/logs' . $file_name .'.txt' );
	    }
	 }

//	 $Log = new Log();
//	 $log_nr = "openid:{$openid}　　phone:{$phone}　　code:{$api_result}";
//	 $Log->put('/wx/user_reg_from_qrcode','user registered');
?>
