<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");

class game_brain_question_bankBean
{
	private $id;
	private $question;
	private $type;
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
	 * 功能：获取指定的问题
	 * */
	function get_question($db, $question_id)
	{
		$sql = "SELECT `id`,`question`,`type` FROM `game_brain_question_bank` WHERE `id`={$question_id}";
		return $db->get_row($sql);
	}

	/*
	 * 功能：获取问题列表
	 * */
	function get_question_list()
	{
		$sql = "SELECT * FROM `game_brain_question_bank`";
		return $this->conn->get_results($sql);
	}

	/*
	 * 功能：添加问题
	 * */
	 function add()
	 {
	 	$question 	= $this->conn->escape($this->question);
		$type 		= $this->conn->escape($this->type);
		$sql = "INSERT INTO `game_brain_question_bank`(`question`,`type`)VALUES('".$question."','".$type."')";
		$this->conn->query($sql);
		return $this->conn->insert_id;
	 }

	 /*
	 * 功能：修改问题
	 * */
	 function edit()
	 {
	 	$question 	= $this->conn->escape($this->question);
		$id 		= $this->conn->escape($this->id);
		$sql 		= "UPDATE `game_brain_question_bank` SET `question`='".$question."' WHERE `id`=$id";
		return $this->conn->query($sql);
	 }


	 /*
	  * 功能：统计总的问题数量
	  * */
	 function get_question_count($db)
	 {
	 	$sql = "SELECT count(*) as num FROM `game_brain_question_bank`";
		return $db->get_var($sql);
	 }
}
?>
