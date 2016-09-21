<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");

class game_brain_exchange_codeBean
{
	private $id;
	private $openid;
	private $value;
	private $time;
	private $from;
	private $status;

	public function __get($para_name)
	{
		if(isset($this->$para_name))
		{
			return($this->$para_name);
		}
		else
		{
			return(NULL);
		}
	}

	//__set()方法用来设置私有属性
	public function __set($para_name, $val)
	{
		$this->$para_name = $val;
	}


	/*
	 * 功能：增加兑奖码库
	 * */
	function creat()
	{
		$value 		= $this->conn->escape($this->value);
		$sql = "INSERT INTO `game_brain_exchange_code` (`value`) VALUES ('".  $this->value ."')";
		$this->conn->query($sql);
	}

	/*
	 * 功能：随机获取兑奖码
	 * */
	function get_code()
	{
		$sql = "SELECT `value` FROM `game_brain_exchange_code` WHERE `status`=0 ORDER BY RAND() LIMIT 1";
		return $this->conn->get_row($sql)->value;
	}

	/*
	 * 	功能：将兑奖码设置为无效
	 * */
	 function set_code_status()
	 {
	 	$value 		= $this->conn->escape($this->value);
	 	$openid 	= $this->conn->escape($this->openid);
	 	$from 		= $this->conn->escape($this->from);
	 	$time 		= time();
	 	$sql = "UPDATE `game_brain_exchange_code` SET `openid`='{$openid}',`from`='{$from}',`time`={$time},`status`=-1 WHERE `value`={$value}";
	 	return $this->conn->query($sql);
	 }

	 /*
	  * 功能：获取我的兑换码
	  * */
	 function get_my_exchange_code()
	 {
	 	$openid = $this->conn->escape($this->openid);
		/*
		$sql 	= "SELECT `is_attention` FROM `game_brain_user` WHERE `openid`='{$openid}'";

		if ( $this->conn->get_var($sql) == 0 )
		{
			return "";
		}
		*/
		$openid  = $this->conn->escape($this->openid);
		$sql	 = "SELECT * FROM `game_brain_exchange_code` WHERE `openid`='{$openid}' ORDER BY `value` ASC";
		return $this->conn->get_results($sql);
	 }


	 /*
	  * 功能：获取兑换码已使用和未使用的数量
	  * */
	 function get_code_status_count()
	 {
	 	$sql = "SELECT COUNT(*) as num FROM `game_brain_exchange_code` GROUP BY `status` ORDER BY `status` DESC";
	 	return $this->conn->get_results($sql);
	 }


}
?>
