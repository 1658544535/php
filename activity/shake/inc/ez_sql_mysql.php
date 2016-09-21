<?php
	!defined('HN1') && exit('Access Denied.');

	/**********************************************************************
	*  Author: Justin Vincent (justin@visunet.ie)
	*  Web...: http://php.justinvincent.com
	*  Name..: ezSQL_mysql
	*  Desc..: mySQL component (part of ezSQL databse abstraction library)
	*
	*/

	/**********************************************************************
	*  ezSQL error strings - mySQL
	*/

	$ezsql_mysql_str = array
	(
		1 => 'Require $dbuser and $dbpassword to connect to a database server',
		2 => 'Error establishing mySQL database connection. Correct user/password? Correct hostname? Database server running?',
		3 => 'Require $dbname to select a database',
		4 => 'mySQL database connection is not active',
		5 => 'Unexpected error while trying to select database'
	);

	/**********************************************************************
	*  ezSQL Database specific class - mySQL
	*/

	if ( ! function_exists ('mysql_connect') ) die('<b>Fatal Error:</b> ezSQL_mysql requires mySQL Lib to be compiled and or linked in to the PHP engine');
	if ( ! class_exists ('ezSQLcore') ) die('<b>Fatal Error:</b> ezSQL_mysql requires ezSQLcore (ez_sql_core.php) to be included/loaded before it can be used');

	class ezSQL_mysql extends ezSQLcore
	{

		var $dbuser = false;
		var $dbpassword = false;
		var $dbname = false;
		var $dbhost = false;

		/**********************************************************************
		*  Constructor - allow the user to perform a qucik connect at the
		*  same time as initialising the ezSQL_mysql class
		*/

		function ezSQL_mysql($dbuser='', $dbpassword='', $dbname='', $dbhost='localhost')
		{
			$this->dbuser = $dbuser;
			$this->dbpassword = $dbpassword;
			$this->dbname = $dbname;
			$this->dbhost = $dbhost;
		}

		/**********************************************************************
		*  Short hand way to connect to mySQL database server
		*  and select a mySQL database at the same time
		*/

		function quick_connect($dbuser='', $dbpassword='', $dbname='', $dbhost='localhost')
		{
			$return_val = false;
			if ( ! $this->connect($dbuser, $dbpassword, $dbhost,true) ) ;
			else if ( ! $this->select($dbname) ) ;
			else $return_val = true;
			return $return_val;
		}

		/**********************************************************************
		*  Try to connect to mySQL database server
		*/

		function connect($dbuser='', $dbpassword='', $dbhost='localhost')
		{
			global $ezsql_mysql_str; $return_val = false;

			// Must have a user and a password
			if ( ! $dbuser )
			{
				$this->register_error($ezsql_mysql_str[1].' in '.__FILE__.' on line '.__LINE__);
				$this->show_errors ? trigger_error($ezsql_mysql_str[1],E_USER_WARNING) : null;
			}
			// Try to establish the server database handle
			else if ( ! $this->dbh = @mysql_connect($dbhost,$dbuser,$dbpassword,true) )
			{
				$this->register_error($ezsql_mysql_str[2].' in '.__FILE__.' on line '.__LINE__);
				$this->show_errors ? trigger_error($ezsql_mysql_str[2],E_USER_WARNING) : null;
			}
			else
			{
				$this->dbuser = $dbuser;
				$this->dbpassword = $dbpassword;
				$this->dbhost = $dbhost;
				$return_val = true;
			}

			return $return_val;
		}

		/**********************************************************************
		*  Try to select a mySQL database
		*/

		function select($dbname='')
		{
			global $ezsql_mysql_str; $return_val = false;

			// Must have a database name
			if ( ! $dbname )
			{
				$this->register_error($ezsql_mysql_str[3].' in '.__FILE__.' on line '.__LINE__);
				$this->show_errors ? trigger_error($ezsql_mysql_str[3],E_USER_WARNING) : null;
			}

			// Must have an active database connection
			else if ( ! $this->dbh )
			{
				$this->register_error($ezsql_mysql_str[4].' in '.__FILE__.' on line '.__LINE__);
				$this->show_errors ? trigger_error($ezsql_mysql_str[4],E_USER_WARNING) : null;
			}

			// Try to connect to the database
			else if ( !@mysql_select_db($dbname,$this->dbh) )
			{
				// Try to get error supplied by mysql if not use our own
				if ( !$str = @mysql_error($this->dbh))
					  $str = $ezsql_mysql_str[5];

				$this->register_error($str.' in '.__FILE__.' on line '.__LINE__);
				$this->show_errors ? trigger_error($str,E_USER_WARNING) : null;
			}
			else
			{
				$this->dbname = $dbname;
				$return_val = true;
			}

			return $return_val;
		}

		/**********************************************************************
		*  Format a mySQL string correctly for safe mySQL insert
		*  (no mater if magic quotes are on or not)
		*/

		function escape($str="")
		{
			return mysql_escape_string(stripslashes($str));
		}

		/**********************************************************************
		*  Return mySQL specific system date syntax
		*  i.e. Oracle: SYSDATE Mysql: NOW()
		*/

		function sysdate()
		{
			return 'NOW()';
		}

		/**********************************************************************
		*  Perform mySQL query and try to detirmin result value
		*/

		function query($query="")
		{

			// Initialise return
			$return_val = 0;

			// Flush cached values..
			$this->flush();

			// For reg expressions
			$query = trim($query);

			// Log how the function was called
			$this->func_call = "\$db->query(\"$query\")";

			// Keep track of the last query for debug..
			$this->last_query = $query;

			// Count how many queries there have been
			$this->num_queries++;

			// Use core file cache function
			if ( $cache = $this->get_cache($query) )
			{
				return $cache;
			}

			// If there is no existing database connection then try to connect
			if ( ! isset($this->dbh) || ! $this->dbh )
			{
				$this->connect($this->dbuser, $this->dbpassword, $this->dbhost);
				$this->select($this->dbname);
			}

			// Perform the query via std mysql_query function..
			$this->result = @mysql_query($query,$this->dbh);

			// If there is an error then take note of it..
			if ( $str = @mysql_error($this->dbh) )
			{
				$is_insert = true;
				$this->register_error($str);
				$this->show_errors ? trigger_error($str,E_USER_WARNING) : null;
				return false;
			}

			// Query was an insert, delete, update, replace
			$is_insert = false;
			if ( preg_match("/^(insert|delete|update|replace)\s+/i",$query) )
			{
				$this->rows_affected = @mysql_affected_rows();

				// Take note of the insert_id
				if ( preg_match("/^(insert|replace)\s+/i",$query) )
				{
					$this->insert_id = @mysql_insert_id($this->dbh);
				}

				// Return number fo rows affected
				$return_val = $this->rows_affected;
			}
			// Query was a select
			else
			{

				// Take note of column info
				$i=0;
				while ($i < @mysql_num_fields($this->result))
				{
					$this->col_info[$i] = @mysql_fetch_field($this->result);
					$i++;
				}

				// Store Query Results
				$num_rows=0;
				while ( $row = @mysql_fetch_object($this->result) )
				{
					// Store relults as an objects within main array
					$this->last_result[$num_rows] = $row;
					$num_rows++;
				}

				@mysql_free_result($this->result);

				// Log number of rows the query returned
				$this->num_rows = $num_rows;

				// Return number of rows selected
				$return_val = $this->num_rows;
			}

			// disk caching of queries
			$this->store_cache($query,$is_insert);

			// If debug ALL queries
			$this->trace || $this->debug_all ? $this->debug() : null ;

			return $return_val;
		}

		/*
		 * 功能： 添加数据
		 *
		 * 参数：
		 * $table: 数据表
		 * $arr: 要添加的数据
		 *
		 * 实例：
		 * $arr = array(
		 *		'content' =>'ab"c',
		 *		'type'=>2
		 *	);
		 *	$db->create( 'about', $arr );
	   * */
		function create( $table, $arr )
		{
			$rs = '';
			if ( is_array($arr) )
			{
				foreach( $arr as $key=>$val )
				{
					$arrKey[] = "`".$key."`";
					$arrVal[] = "'".$this->escape($val)."'";

					$strKey = implode(',',$arrKey);
					$strVal = implode(',',$arrVal);
				}
				$strSQL = "INSERT INTO `{$table}` ($strKey) VALUES({$strVal})";

				try
				{
					$this->query($strSQL);
					$rs =  $this->insert_id;
				}catch( Exception $e )
				{
					$rs = 0;
				}
			}

			return $rs;
		}

		/*
		 * 功能： 添加数据
		 *
		 * 参数：
		 * $table: 数据表
		 * $arr: 要添加的数据
		 *
		 * 实例：
		 * $arrParam = array(
		 *		'content' =>'abcd',
		 *		'type'=>1
		 *	);
		 *
		 *	$arrCondition = array(
		 *		'id' => 1
		 *	);
		 *
		 *	$db->update( 'about', $arrParam, $arrCondition );
	     * */
		function update( $table, $arrParam, $arrCondition )
		{
			$rs = '';
			if ( is_array($arrParam) )
			{
				foreach( $arrParam as $key=>$val )
				{
					$arrVal[] = "`{$key}`='{$this->escape($val)}'";
					$strVal = implode(',',$arrVal);
				}

				foreach ( $arrCondition as $key=>$val )
				{
					$arrVal2[] = " AND `{$key}`='{$this->escape($val)}'";
					$strWhere = implode('',$arrVal2);
				}

 				$strSQL = "UPDATE `{$table}` SET {$strVal} WHERE 1=1 {$strWhere}";
				$rs =  $this->query($strSQL);
			}

			return $rs;
		}

		/*
		 * 功能： 查找数据
		 *
		 * 参数：
		 * $table: 数据表
		 * $arrWhere: 要查询的条件
		 * $arrCol: 要输出的列
		 *
		 * 实例：
		 *
		 *	$arrWhere = array(
		 *		'id' => 1
		 *	);
		 *
		 *	$db->get_list( 'about', $arrWhere );
	     * */
		function get_list( $table, $arrWhere, $arrCol )
		{
			$strWhere = "";
			$strCol   = "*";

			if ( is_array( $arrWhere ) )
			{
				foreach ( $arrWhere as $key=>$val )
				{
					$arrVal2[] = " AND `{$key}`='{$this->escape($val)}'";
					$strWhere = implode(' ',$arrVal2);
				}
			}

			if ( is_array( $arrCol ) )
			{
				$strCol = implode(',',$arrCol);
			}

			$strSQL = "SELECT {$strCol} FROM `{$table}` WHERE 1=1 {$strWhere} ";
			return $this->get_results($strSQL);
		}

		/*
		 * 功能： 查找数据(单一记录)
		 *
		 * 参数：
		 * $table: 数据表
		 * $arrWhere: 要查询的条件
		 * $arrCol: 要输出的列
		 *
		 * 实例：
		 *
		 *	$arrWhere = array(
		 *		'id' => 1
		 *	);
		 *
		 *	$db->get_list( 'about', $arrWhere );
	     * */
		function get_one( $table, $arrWhere, $arrCol, $strOrderBy )
		{
			$strWhere = "";
			$strCol   = "*";
			$OrderBy = "";

			if ( is_array( $arrWhere ) )
			{
				foreach ( $arrWhere as $key=>$val )
				{
					$arrVal2[] = " AND `{$key}`='{$this->escape($val)}'";
					$strWhere = implode(' ',$arrVal2);
				}
			}

			if ( is_array( $arrCol ) )
			{
				$strCol = implode(',',$arrCol);
			}

			if ( $strOrderBy != "" )
			{
				$OrderBy = "ORDER BY " . $strOrderBy;
			}

			$strSQL = "SELECT {$strCol} FROM `{$table}` WHERE 1=1 {$strWhere} {$OrderBy}";
			return $this->get_row($strSQL);
		}

		/*
		 * 功能： 删除数据
		 *
		 * 参数：
		 * $table: 数据表
		 * $arrWhere: 要删除的条件
		 *
		 * 实例：
		 *
		 *	$arrWhere = array(
		 *		'id' => 1
		 *	);
		 *
		 *	$db->get_list( 'about', $arrWhere );
	     * */
		function del( $table, $arrWhere )
		{
			$strWhere = "";

			if ( is_array( $arrWhere ) )
			{
				foreach ( $arrWhere as $key=>$val )
				{
					$arrVal2[] = " AND `{$key}`='{$this->escape($val)}'";
					$strWhere = implode(' ',$arrVal2);
				}
			}

			$strSQL = "DELETE FROM `{$table}` WHERE 1=1 {$strWhere} ";
			return $this->query($strSQL);
		}

	}

?>