<?php
if ( !defined('SCRIPT_ROOT') ) die ("no permission");

class user_consumerBean extends  Db
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

}
?>