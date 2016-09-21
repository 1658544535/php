<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");

class game_brain_recordBean
{
	private $id;
	private $sponsor;
	private $challenger;
	private $result;
	private $time;
	private $from;
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
		$sponsor 	= $this->conn->escape($this->sponsor);
		$challenger = $this->conn->escape($this->challenger);
		$from 		= $this->conn->escape($this->from);
		$time   	= time();

		$sql = "INSERT INTO `game_brain_user_record`(`sponsor`,`challenger`,`result`,`time`,`from`)VALUES('{$sponsor}','{$challenger}','-2',{$time},'{$from}')";
		$this->conn->query($sql);
		return $this->conn->insert_id;
	}

	/*
	 * 功能：获取未对战的场次
	 * */
	function get_no_game_record()
	{
		$sponsor 	= $this->conn->escape($this->sponsor);
		$challenger = $this->conn->escape($this->challenger);

		$sql = "SELECT `id` FROM `game_brain_user_record` WHERE `sponsor`='{$sponsor}' AND `challenger`='{$challenger}' AND `result`=-2";
		return $this->conn->get_row($sql);
	}

	/*
	 *	功能：获取指定两帐号最近一次交战的信息
	 * */
	 function get_last_game_info()
	 {
	 	$sponsor 	= $this->conn->escape($this->sponsor);
		$challenger = $this->conn->escape($this->challenger);
		$sql = "SELECT * FROM `game_brain_user_record` WHERE `sponsor`='{$sponsor}' AND `challenger`='{$challenger}' AND `result`!=-2";
		return $this->conn->get_row($sql);
	 }

	 /*
	  * 功能：对战结束后更新对战信息
	  * */
	 function update()
	 {
	 	$id 				= $this->conn->escape($this->id);
		$challenger 		= $this->conn->escape($this->challenger);
		$sponsor_scroe 		= $this->conn->escape($this->sponsor_scroe);
		$challenger_score 	= $this->conn->escape($this->challenger_score);
		$result 			= $this->conn->escape($this->result);
		$exchange_code 		= $this->conn->escape($this->exchange_code);

		$sql = "UPDATE `game_brain_user_record` SET `sponsor_scroe`='{$sponsor_scroe}',`challenger_score`='{$challenger_score}',`result`='{$result}',`exchange_code`='{$exchange_code}' WHERE `id`={$id} AND `challenger`='{$challenger}'";
	 	return $this->conn->query($sql);
	 }


	 function get_battle_result()
	 {
	 	$sponsor 	= $this->conn->escape($this->sponsor);
		$challenger = $this->conn->escape($this->challenger);

		$sql 		= "SELECT count(*) FROM `game_brain_user_record` WHERE (`sponsor`='{$sponsor}' AND `result`=1) OR (`challenger`='{$challenger}' AND `result`=-1)";
		$winNum		= $this->conn->get_var($sql);

		$sql 		= "SELECT count(*) FROM `game_brain_user_record` WHERE (`sponsor`='{$sponsor}' OR `challenger`='{$challenger}') AND `result`=0";
		$drawNum		= $this->conn->get_var($sql);

		$sql 		= "SELECT count(*) FROM `game_brain_user_record` WHERE (`sponsor`='{$sponsor}' AND `result`=-1) OR (`challenger`='{$challenger}' AND `result`=1)";
		$loseNum	= $this->conn->get_var($sql);

		return (object)array( 'winNum'=>$winNum, 'drawNum'=>$drawNum, 'loseNum'=>$loseNum  );
	 }

	 function get_battle_list()
	 {
	 	$sponsor 	= $this->conn->escape($this->sponsor);
		$challenger = $this->conn->escape($this->challenger);

	 	$sql 		= "SELECT *, (SELECT `name` FROM `game_brain_user` WHERE `openid`= record.sponsor) AS sponsor_name, (SELECT `img` FROM `game_brain_user` WHERE `openid`= record.sponsor) AS sponsor_img, (SELECT `name` FROM `game_brain_user` WHERE `openid`= record.challenger) AS challenger_name, (SELECT `img` FROM `game_brain_user` WHERE `openid`= record.challenger) AS challenger_img  FROM `game_brain_user_record` as record WHERE (record.`sponsor`='{$sponsor}' OR record.`challenger`='{$challenger}') AND record.`result` != -2";
		return $this->conn->get_results($sql);
	 }




}
?>
