<?php
date_default_timezone_set('Asia/Shanghai'); 							// 设置默认时区
class Log_
{
	// 打印log
	function  log_result($file,$word)
	{
	    $fp = fopen($file,"a");
	    flock($fp, LOCK_EX) ;
	    fwrite($fp,"执行日期：".date("Y-m-d H：i:s")."\n".$word."\n\n");
	    flock($fp, LOCK_UN);
	    fclose($fp);
	}
}


?>