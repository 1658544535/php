<?php
	class Db
	{
		private $conn;
		private $table;

		public function __construct( $db, $table )
		{
			$this->conn  = $db;
			$this->table = $table;
		}

		function get_list(  $arrWhere = '', $arrCol = '' )
		{
			return $this->conn->get_list( $this->table, $arrWhere, $arrCol );
		}

		function create( $arrList )
		{
			return $this->conn->create( $this->table, $arrList);
		}

		function update( $arrList, $arrWhere)
		{
			return $this->conn->update( $this->table, $arrList, $arrWhere);
		}

		function del( $arrWhere )
		{
			return $this->conn->del( $this->table, $arrWhere);
		}

		function get_one( $arrWhere = '', $arrCol = '', $strOrderBy = '' )
		{
			return $this->conn->get_one( $this->table, $arrWhere, $arrCol, $strOrderBy );
		}

		function query( $sql )
		{
			return $this->conn->get_results( $sql );
		}

	}
?>