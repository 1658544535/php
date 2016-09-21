<?php
if ( !defined('HN1') ) die("no permission");


class testBean extends  Db
{
	private $conn;

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
