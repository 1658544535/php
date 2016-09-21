<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");

class game_brain_userBean
{
	private $id;
	private $name;
	private $openid;
	private $img;
	private $sex;
	private $province;
	private $city;
	private $country;
	private $unionid;
	private $score;
	private $isExchange;
	private $time;
	private $conn;

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
	 * 功能：增加用户
	 * */
	function creat()
	{
		$name 		= $this->conn->escape($this->name);
		$openid 	= $this->conn->escape($this->openid);
		$img 		= $this->conn->escape($this->img);
		$sex 		= $this->conn->escape($this->sex);
		$province 	= $this->conn->escape($this->province);
		$city 		= $this->conn->escape($this->city);
		$country 	= $this->conn->escape($this->country);
		$unionid 	= $this->conn->escape($this->unionid);
		$time   	= time();

		$sql = "INSERT INTO `game_brain_user`(`name`,`openid`,`img`,`sex`,`province`,`city`,`country`,`unionid`,`time`)VALUES('{$name}','{$openid}','{$img}','{$sex}','{$province}','{$city}','{$country}','{$unionid}',{$time})";
		$this->conn->query($sql);
		return $this->conn->insert_id;
	}

	/*
	 * 功能：获取指定用户的信息
	 * */
	function get_one()
	{
		$openid = $this->conn->escape($this->openid);
		$sql = "SELECT * FROM `game_brain_user` WHERE `openid`='{$openid}'";
		return $this->conn->get_row($sql);
	}


	/*
	 * 功能：修改该用户的关注状态
	 * */
	 function set_attention()
	 {
		$openid 	= $this->conn->escape($this->openid);
		$sql = "UPDATE `game_brain_user` SET `is_attention`=1 WHERE `openid`='{$openid}'";
		return $this->conn->query($sql);
	 }

}
?>
