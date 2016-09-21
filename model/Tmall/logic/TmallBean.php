<?php
if ( !defined('SCRIPT_ROOT') ) die ("no permission");

class TmallBean extends  Db
{
	function __construct( $db, $table )
	{
		parent::__construct( $db, $table );
		$this->conn = $db;
	}

	function __get( $key )
	{
		return $this->$key;
	}

	function __set( $key, $val )
	{
		$this->$key = $val;
	}


/********获取信息列表*********/
	public function getTmallList($arr)
	{
		$sql = "SELECT * FROM `tmall` WHERE 1=1 ";
		return $this->conn->get_results($sql);
	}


















}
?>