<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");

class game_brain_scoreBean
{
	private $id;
	private $uid;
	private $openid;
	private $score;
	private $is_allow;
	private $is_exchange;
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
	 * 功能：获取排行榜列表
	 * */
	function get_rank_list()
	{
		$sql = "SELECT score.score, user.name, user.img FROM `game_brain_user_score` as score,`game_brain_user` as user WHERE score.openid=user.openid ORDER BY score.score DESC LIMIT 10";
		return $this->conn->get_results($sql);
	}

	/*
	 * 功能：获取我的排行
	 * */
	function get_my_rank()
	{
		$openid = $this->conn->escape($this->openid);
		$sql = "SELECT count(*) as num FROM `game_brain_user_score` WHERE openid='{$openid}'";

		if ( $this->conn->get_row($sql)->num == 0 )
		{
			$res  = null;
		}
		else
		{
			$sql  = "SELECT count(*) as rank FROM `game_brain_user_score` WHERE score > ( SELECT score FROM `game_brain_user_score` WHERE openid='{$openid}')";
			$rank = $this->conn->get_row($sql)->rank + 1;
			$res  = $this->conn->get_row($sql)->rank + 1;
		}

		return $res;

	}

	/*
	 * 功能：获取指定用户的游戏信息
	 * */
	function get_user_info()
	{
		$openid = $this->conn->escape($this->openid);
		$sql = "SELECT score.score, score.is_allow, score.exchange_code, user.name, user.img FROM `game_brain_user_score` as score,`game_brain_user` as user WHERE score.openid=user.openid  AND score.openid='{$openid}'";
		return $this->conn->get_row($sql);
	}



	/*
	 * 功能：增加记录
	 * */
	function creat()
	{
		$uid 			= $this->conn->escape($this->uid);
		$openid 		= $this->conn->escape($this->openid);
		$score 			= $this->conn->escape($this->score);
		$exchange_code 	= $this->conn->escape($this->exchange_code);

		$sql = "INSERT INTO `game_brain_user_score`(`uid`,`openid`,`score`,`exchange_code`)VALUES('{$uid}','{$openid}','{$score}','{$exchange_code}')";
		$this->conn->query($sql);
		return $this->conn->insert_id;
	}

	/*
	 * 功能：获取指定用户的分数信息
	 * */
	function get_one()
	{
		$openid = $this->conn->escape($this->openid);
		$sql = "SELECT * FROM `game_brain_user_score` WHERE `openid`='{$openid}'";
		return $this->conn->get_row($sql);
	}

	/*
	 * 功能：修改用户的分数
	 * */
	function update()
	{
		$score 			= $this->conn->escape($this->score);
		$openid 		= $this->conn->escape($this->openid);
		$is_allow 		= $this->conn->escape($this->is_allow);
		$exchange_code 	= $this->conn->escape($this->exchange_code);
		$sql = "UPDATE `game_brain_user_score` SET `is_allow`={$is_allow}, `score`={$score},`exchange_code`='{$exchange_code}' WHERE `openid`='{$openid}'";
		return $this->conn->query($sql);
	}

	/*
	 * 功能：设置用户关注后的二维码
	 * */
	function set_exchange_code()
	{
		$openid 		= $this->conn->escape($this->openid);
		$exchange_code 	= $this->conn->escape($this->exchange_code);
		$sql = "UPDATE `game_brain_user_score` SET `exchange_code`={$exchange_code} WHERE `openid`='{$openid}'";
		return $this->conn->query($sql);
	}


}
?>
