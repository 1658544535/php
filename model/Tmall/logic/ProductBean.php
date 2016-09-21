<?php
if ( !defined('SCRIPT_ROOT') ) die ("no permission");

class ProductBean extends  Db
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


	public function getProductList( $limit, $price )
	{
		$strWhere = '';

		if ( $price != '' )
		{
			$strWhere =  " AND `distribution_price` <= {$price}";
		}

		$strSQL = "SELECT
				`id`,
				`product_name`,
				`distribution_price`,
				`image`,
				`location`
			FROM
				`product`
			WHERE
				`user_id`=220
			AND
				`status`=1
				{$strWhere}
			ORDER BY
				`sell_number` ASC
			LIMIT
				{$limit}
		";

		return $this->conn->get_results( $strSQL );
	}

}
?>