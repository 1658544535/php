<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");

class game_brain_answer_bankBean
{
	private $id;
	private $subject_id;
	private $text;
	private $is_right;
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
	 * 功能：获取指定问题的答案列表
	 * */
	function get_answer_list($db, $question_id)
	{
		$sql = "SELECT `id`,`text`,`is_right` FROM `game_brain_answer_bank`  WHERE subject_id={$question_id}";
		return $db->get_results($sql);
	}


	/*
	 * 功能：获取选中答案的正确性
	 * */
	function get_answer_result($db, $question_id, $answer_id)
	{
		$sql = "SELECT `is_right` FROM `game_brain_answer_bank`  WHERE `id`={$answer_id} AND `subject_id`={$question_id}";
		return $db->get_row($sql)->is_right;
	}

	/*
	 * 功能：添加问题
	 * */
	 function add()
	 {
	 	$subject_id 	= $this->conn->escape($this->subject_id);
	 	$text 			= $this->conn->escape($this->text);
		$is_right 		= $this->conn->escape($this->is_right);

		$sql = "INSERT INTO `game_brain_answer_bank`(`subject_id`,`text`,`is_right`)VALUES('".$subject_id."','".$text."','".$is_right."')";
		$this->conn->query($sql);
		return $this->conn->insert_id;
	 }

	 /*
	 * 功能：更新问题
	 * */
	 function edit()
	 {
	 	$id 	  = $this->conn->escape($this->id);
	 	$text 	  = $this->conn->escape($this->text);

		$sql = "UPDATE `game_brain_answer_bank` SET `text`='".$text."' WHERE `id`='".$id."'";
		return $this->conn->query($sql);
	 }

	 /*
	  * 获取正确的选项
	  * */
	 function get_right_list($db, $question_id)
	 {
		$sql = "SELECT `id`,`text` FROM `game_brain_answer_bank`  WHERE `is_right`=1 AND `subject_id`={$question_id}";
		return $db->get_results($sql);
	 }

	 /*
	  * 获取错误的选项
	  * */
	 function get_wrong_list($db, $question_id)
	 {
		$sql = "SELECT `id`,`text` FROM `game_brain_answer_bank`  WHERE `is_right`=0 AND `subject_id`={$question_id}";
		return $db->get_results($sql);
	 }

}
?>
