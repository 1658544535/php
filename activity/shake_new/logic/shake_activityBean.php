<?php
if ( !defined('SCRIPT_ROOT') ) die ("no permission");

class shake_activityBean extends  Db
{
	private $id;
	private $title;
	private $starttime;
	private $endtime;
	private $addTime;
	private $sorting;
	private $status;


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

}
?>