<?php
if ( !defined('SCRIPT_ROOT') ) die ("no permission");

class shake_prize_recordsBean extends  Db
{
	private $id;
	private $userid;
	private $prize_id;
	private $shake_id;
	private $is_used;
	private $used_time;
	private $book_time;
	private $status;
	private $addtime;
	private $ticket_no;


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

	public function get_user_record( $uid )
	{
		//$strSQL = "SELECT sp.`name`,sp.`image`, spr.`addtime` FROM `shake_prize_records` as spr, `shake_prize` as sp, `shake_activity` as sa where spr.`prize_id`=sp.`id`  AND spr.`shake_id`=sa.`id` AND sp.prize_no != 0 AND spr.`userid`='{$uid}' AND spr.`shake_id`='{$aid}'";
		$strSQL = "SELECT sp.`name`,sp.`image`, spr.`addtime`, spr.`is_used`, spr.`id` AS spr_id FROM `shake_prize_records` as spr, `shake_prize` as sp, `shake_activity` as sa where spr.`prize_id`=sp.`id`  AND spr.`shake_id`=sa.`id` AND sp.prize_no != 0 AND spr.`userid`='{$uid}'";
		return $this->query($strSQL);
	}

	public function get_record_list( $aid )
	{
		//$strSQL = "SELECT spr.`id`, sa.`title`, sp.`name` as prize_name, spr.`addtime`, sl.`nickname`, sl.`subscribe`,spr.`userid` FROM `shake_prize_records` as spr, `shake_prize` as sp, `shake_activity` as sa, `shake_link` as sl WHERE spr.`userid`=sl.`openid` AND spr.`prize_id`=sp.`id` AND spr.`shake_id`=sa.`id`  AND spr.`shake_id`='{$aid}' ORDER BY addtime DESC";
		$strSQL = "
			SELECT
				spr.`id`,
				( SELECT `name` FROM `shake_prize` WHERE `id`= `prize_id` ) AS prize_name,
				( SELECT `name` FROM `sys_login` WHERE `openid`=`userid` LIMIT 1 ) AS user_name,
				( SELECT `loginname` FROM `sys_login` WHERE `openid`=`userid` LIMIT 1 ) AS loginname,
				spr.`addtime`,
				spr.`userid`
			FROM
				`shake_prize_records` as spr
			WHERE
				spr.`shake_id`='{$aid}'

			ORDER BY addtime DESC";
		return $this->query($strSQL);
	}

}
?>