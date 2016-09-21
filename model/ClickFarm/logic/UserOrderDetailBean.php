<?php
if ( !defined('SCRIPT_ROOT') ) die ("no permission");

class UserOrderDetailBean extends  Db
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

	public function changeOrderData( $date, $order_id )
	{
		$arrParam = array(
			'create_date' 		=> 	$date,
			'update_date' 		=> 	$date,
		);

		$this->update( $arrParam, array( 'order_id'=>$order_id ));
	}

}
?>