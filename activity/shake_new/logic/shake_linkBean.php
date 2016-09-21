<?php
if ( !defined('SCRIPT_ROOT') ) die ("no permission");

class shake_linkBean extends  Db
{
	private $subscribe;
	private $openid;
	private $nickname;
	private $sex;
	private $language;
	private $city;
	private $province;
	private $country;
	private $headimgurl;
	private $subscribe_time;
	private $unionid;
	private $remark;
	private $groupid;

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