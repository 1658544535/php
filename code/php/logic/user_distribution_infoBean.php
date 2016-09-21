<?php
if ( !defined('HN1') ) die("no permission");

include_once APP_INC . 'db.php';


class user_distribution_infoBean extends db
{

	public function __construct( $db, $table )
	{
		parent::__construct( $db,$table );
	}

}
?>