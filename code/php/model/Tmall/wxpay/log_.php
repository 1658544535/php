<?php

class Log_
{
	// 打印log
	function  log_result($file,$word)
	{
	    $fp = fopen($file,"a");
	    flock($fp, LOCK_EX) ;
	    fwrite($fp,"执行日期：".date("Y-m-d H：i：s",time())."\n".$word."\n\n");
	    flock($fp, LOCK_UN);
	    fclose($fp);
	}
}

?>