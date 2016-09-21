<?php
if ( !defined('SCRIPT_ROOT') ) die ("no permission");

class shake_prizeBean extends  Db
{
	private $id;
	private $shake_id;
	private $price;
	private $image;
	private $name;
	private $prize_no;
	private $probability;
	private $sorting;
	private $status;
	private $source;
	private $introduce;
	private $addtime;


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