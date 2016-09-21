<?php
/**
 * 模型基类
 */
class Model{
	protected $conn;
	protected $table;

	/**
	 * 构造方法
	 *
	 * @param object $db 数据库句柄
	 * @param string $table 表名
	 */
	public function __construct($db, $table=''){
		$this->conn  = $db;
		$this->table = $table;
	}

	public function setTable($table){
		$this->table = $table;
	}

	public function getTable($table=''){
		empty($table) && $table = $this->table;
		return T($table);
	}

	/**
	 * 获取一条记录
	 *
	 * @param array $cond 条件
	 * @param string|array $fields 需获取的字段
	 * @param string $outputType 返回的结构类型，OBJECT对象，ARRAY_A关联数组，ARRAY_N数值数组
	 * @param string|array $paramTable 数据表
	 * @return object
	 *
	 */
	public function get($cond=array(), $fields='*', $outputType=OBJECT, $paramTable='')
	{
		$sql = $this->getSQL(  $cond, $fields, '', '', $this->getTable($paramTable) );
		return $this->conn->get_row($sql, $outputType);
	}

	/**
	 * 获取记录列表
	 *
	 * @param array $cond 			条件
	 * @param string|array $order 	排序，字段=>排序
	 * @param integer $page 		页码，负数则不分页获取全部
	 * @param integer $perpage 		每页数量
	 * @param string|array $fields 	需获取的字段
	 * @param string $paramTable 	数据表
	 * @return array
	 */
	public function gets($cond=array(), $order=array(), $page=1, $perpage=20, $fields='', $paramTable='')
	{
		$sql = $this->getSQL( $cond, $fields, $order, '', $this->getTable($paramTable) );
		return $this->get_pager_data($sql, $page, $perpage);
	}

	/**
	 * 添加记录
	 *
	 * @param array $data 数据，字段名=>值
	 * @param string $table 表名，未指定则使用实例化时指定的表名
	 * @param boolean $replace 是否使用replace语句
	 * @return integer|boolean false失败
	 */
	public function add($data, $table='', $replace=false,$is_mysql_real_escape=false){
		if(empty($data))
		{
			return false;
		}
		else
		{
			$fields = array();
			$values = array();
			foreach($data as $k => $v)
			{
				$fields[] = $k;

				if ( $is_mysql_real_escape )
				{
					$values[] = mysql_real_escape_string($v);
				}
				else
				{
					$values[] = $this->conn->escape($v);
				}

			}
			$table = $this->getTable($table);
			$sql = ($replace ? 'REPLACE' : 'INSERT').' INTO `'.$table.'`(`'.implode('`,`', $fields)."`) VALUES('".implode("','", $values)."')";

			try{
				if(($result = $this->conn->query($sql)) === false){
					return false;
				}else{
					return $replace ? $result : $this->conn->insert_id;
				}
			}catch(Exception $e){
				return false;
			}
		}
	}

	/**
	 * 修改记录
	 *
	 * @param array $data 数据，字段名=>值
	 * @param array|string $cond 条件
	 * @param string $table 表名
	 * @return integer|boolean false失败
	 */
	public function modify($data, $cond, $table='', $is_mysql_real_escape=false){
		if(empty($data))
		{
			return false;
		}
		else
		{
			$table = $this->getTable($table);
			$sqlSet = array();
			foreach($data as $k => $v)
			{
				$sqlTmp = "`{$k}`=";
				if ( $is_mysql_real_escape )
				{
					$sqlTmp .= is_string($v) ? "'" . mysql_real_escape_string($v) . "'" : $v;
				}
				else
				{
					$sqlTmp .= is_string($v) ? "'{$this->conn->escape($v)}'" : $v;
				}

				$sqlSet[] = $sqlTmp;
			}
			$sql = "UPDATE `{$table}` SET ".implode(',', $sqlSet).' WHERE 1=1'.$this->getSqlWhere($cond, true);

			try{
				return $this->conn->query($sql);
			}catch(Exception $e){
				return false;
			}
		}
	}

	/**
	 * 删除记录
	 *
	 * @param array|string $cond 条件
	 * @param string $table 表名
	 * @return integer|boolean false失败
	 */
	public function delete($cond, $table=''){
		if(empty($cond)){
			return false;
		}else{
			$table = $this->getTable($table);
			$sql = "DELETE FROM `{$table}` WHERE 1=1 ".$this->getSqlWhere($cond, true);

			try{
				return $this->conn->query($sql);
			}catch(Exception $e){
				return false;
			}
		}
	}

	/**
	 * 获取数据列表，不分页
	 *
	 * @param array  $cond   条件
	 * @param array  $order  排序，字段=>排序
	 * @param string $output 返回的结构类型，OBJECT对象，ARRAY_A关联数组，ARRAY_N数值数组
	 * @param string $limit  限制
	 * @param string|array $fields 需获取的字段
	 * @param string|array $paramTable 数据表
	 * @return array
	 */
	public function getAll($cond=array(), $order=array(), $output = OBJECT, $limit='',$fields='',$paramTable='')
	{
		$sql = $this->getSQL( $cond, $fields, $order, $limit, $this->getTable($paramTable) );
		return $this->conn->get_results($sql, $output);
	}

	/*
	 * 功能：获取记录数
	 * 参数：
	 * @param array cond: 查询条件
	 * @return int  :记录数
	 * */
	public function getCount($cond=array(),$paramTable='')
	{
		$sql = 'SELECT count(*) FROM `'.$this->getTable($paramTable).'` WHERE 1=1';
		$sqlWhere = $this->getSqlWhere($cond, true);
		$sqlWhere && $sql .= $sqlWhere;
		$rs = $this->conn->get_var($sql);
		return $rs;
	}

	/*
	 * 功能：直接运行sql语句
	 *
	 * @param  string $sql: 		sql语句
	 * @param  string $getOne:		单一返回结果
	 * @param  bool   $isPage:		是否显示分页
	 * @param  int 	  $page:		当前页数
	 * @param  int    $perpage:		每页显示页数
	 * @return object : 结果集
	 * */
	 public function query( $sql='',$getOne=false, $isPage=false, $page=1, $perpage=20 )
	 {
	 	if ( $sql == '' )
	 	{
	 		return null;
	 	}

		$option = strtoupper(substr($sql,0,6));

		if ( $option == 'SELECT' )
		{
			if ( $isPage )
			{
				return $this->get_pager_data($sql, $page, $perpage);
			}
			else
			{
				if ( $getOne == false )
			 	{
					return $this->conn->get_results($sql);
			 	}
			 	else
			 	{
					return $this->conn->get_row($sql);
			 	}
			}
		}
		else
		{
			$result = $this->conn->query($sql);
			if ( $option == 'INSERT' )
			{
				return $result === false ? false : $this->conn->insert_id;
			}
			else
			{
				return $this->conn->query($sql);
			}
		}
	 }

	/**
	 * 开始事务
	 */
	public function startTrans(){
		$this->conn->query('BEGIN');
	}

	/**
	 * 提交事务
	 */
	public function commit(){
		$this->conn->query('COMMIT');
	}

	/**
	 * 回滚事务
	 */
	public function rollback(){
		$this->conn->query('ROLLBACK');
	}

	/**
	 * 获取重整后的sql语句条件信息
	 *
	 * @param string|array $where 条件信息
	 * 格式如下：
	 * 	'id'=>array(array('>',5),array('<=',10),'_logic_'=>'AND'),					==> (`id`>5 AND `id`<=10)
	 *	'name'=>array('dennis'),													==> (`name`='dennis')
	 *	'name2'=>array('dennis2','_logic_'=>'AND'),									==> AND (`name2`='dennis2')
	 *	'address'=>'hello',															==> (`address`='hello')
	 *	'country'=>array('like'=>'%abc%'),											==> (`country` LIKE '%abc%')
	 *	'_string_'=> ' (name like "%thinkphp%")  OR ( title like "%thinkphp") ',	==> ((name like "%thinkphp%")  OR ( title like "%thinkphp"))
	 *	'_logic_'=>'OR',															==> 查询条件为OR
	 *	array( 'id'=>array('IN','(1,2,3)'),'sex'=>array(1),'_logic_'=>'AND' )		==> (`id` IN(1,2,3) AND `sex`=1)
	 *
	 * @param boolean $cond2Str 是否将数组类型的条件参数转为字符串
	 * @return string|array
	 */
	private function getSqlWhere($where, $cond2Str=false)
	{

		if ( empty( $where ) || count( $where ) == 0 )
		{
			return '';
		}

		if ( is_string( $where ) )
		{
			return ' AND ' . $where;
		}

		$strWhere = '';

		if ( isset($where['__IN__']) || isset($where['__NOTIN__']) )
		{
			$strWhere = $this->whereExtend($where, $cond2Str=false);
			return $strWhere;
		}

		if ( is_array( $where ) )
		{
			$_logic_  = isset($where['_logic_']) ? ' ' . $where['_logic_'] . ' ' : ' AND ';		// 连接符
			$_string_ = isset($where['_string_']) ? ' ' . $where['_string_'] . ' ' : '';

			if ( ! empty($_string_) )
			{
				$strWhere .= '(' . $_string_ . ')';
				unset( $where['_string_'] );
			}

			unset( $where['_logic_'] );

			foreach( $where as $key=>$val )
			{
				if ( ! is_array( $val ) )
				{
					if ( is_string($val) )
					{
						$strWhere .= $_logic_ . '(`'.$key.'`' . ' = ' .  "'{$this->conn->escape($val)}')";
					}
					else
					{
						$strWhere .= $_logic_ . '(`'.$key.'`' . ' = ' .  "'{$val}')";
					}

				}
				else
				{
					$_sub_logic_  = isset($val['_logic_']) ? ' ' . $val['_logic_'] . ' ' : $_logic_;		// 连接符
					unset( $val['_logic_'] );
					$arrWhere = '';

					foreach( $val as $subKey=>$subVal )
					{
						if ( count( $val ) == 1 && is_numeric($subKey) ) 			// $key['name'] = array('Hello');
						{
							$strWhere .= $_sub_logic_ . '(`'.$key.'`' . ' = ' .  "'{$this->conn->escape($subVal)}')";
						}
						elseif ( count( $val ) == 1 && !is_numeric($subKey) )		// $key['name'] = array('!='=>'Hello');
						{
							$strWhere .= $_sub_logic_ . '(`'.$key.'`' .  $subKey  .  "'{$this->conn->escape($subVal)}')";
						}
						elseif ( strtoupper($subKey) == 'LIKE' )
						{
							$strWhere .= $_sub_logic_ . '(`'.$key.'`' . ' LIKE ' .  "'{$this->conn->escape($subVal)}')";
						}
						elseif( is_array($subVal) )
						{
							if ( is_numeric($subKey) )
							{
								if ( count($subVal) == 1 )
								{
									$arrWhere[] = '`'.$key.'`=' . $subVal[0];
								}
								else
								{
									$arrWhere[] = '`'.$key.'` ' . $subVal[0] . ' ' . $subVal[1];
								}

							}
							else
							{
								if ( count($subVal) == 1 )
								{
									$arrWhere[] = '`'.$subKey.'` = ' . $subVal[0];
								}
								else
								{
									$arrWhere[] = '`'.$subKey.'` ' . $subVal[0] . ' ' .  $subVal[1];
								}
							}
						}
						elseif (strtoupper($subKey) == 'IN')
						{
							$strWhere .= $_sub_logic_ . '(`'.$key.'`' . ' IN ' .  "({$this->conn->escape($subVal)}))";
						}
					}

					if ( ! empty($arrWhere) )
					{
						$strWhere .= $_logic_ . '(' . implode( $_sub_logic_, $arrWhere ) . ')';
					}
				}
			}
		}

		return $strWhere;
	}

	/**
	 * 得到sql语句
	 *
	 * @param array|string 	$paramWhere		条件语句
	 * @param array|string 	$paramFields	显示字段
	 * @param string|array  $paramOrderBy	排序
	 * @param string 		$paramLimit		限制
	 * @param array|string 	$paramTable		操作表
	 */
	public function getSQL( $paramWhere='', $paramFields='', $paramOrderBy='', $paramLimit='' , $paramTable='' )
	{
		$strOrderBy = '';
		$strLimit 	= '';

		if(empty($paramTable))
		{
			$strTable = '`' . $this->table . '`';
		}
		else
		{
			$strTable = '';
			if ( is_array($paramTable) )
			{
				foreach( $paramTable as $k =>$table )
				{
					if( is_numeric($k) )
					{
						$arrTable[] = $table;
					}
					else
					{
						$arrTable[] =  '`'.$k.'` ' . $table;
					}
				}

				$strTable = implode(',',$arrTable);
			}
			else
			{
				$strTable = '`' . $paramTable . '`';
			}
		}

		if(empty($paramFields))
		{
			$cols = '*';
		}
		elseif(is_array($paramFields))
		{
			$cols = '`'.implode('`,`', $paramFields).'`';
		}else{
			$cols = $paramFields;
		}

		$strWhere = $this->getSqlWhere($paramWhere, true);

		if ( ! empty($strWhere) )
		{
			$strWhere = $strWhere;
		}


		if( ! empty($paramOrderBy))
		{
			if ( is_array($paramOrderBy) )
			{
				$arrOrder = array();
				foreach($paramOrderBy as $f => $o){
					$arrOrder[] = $f.' '.$o;
				}

				$strOrderBy = ' ORDER BY '.implode(',', $arrOrder);
			}
			else
			{
				$strOrderBy = 'ORDER BY ' . $paramOrderBy;
			}
		}

		if ( ! empty($paramLimit) )
		{
			$strLimit = 'LIMIT ' . $paramLimit;
		}

		$strSQL = 'SELECT %s FROM %s WHERE 1=1 %s %s %s';
		return sprintf( $strSQL, $cols, $strTable, $strWhere, $strOrderBy, $strLimit );
	}

	/**
	 * where语句拓展
	 **/
	private function whereExtend($where, $cond2Str=false)
	{
		$arrWhere = array();
		if(is_array($where) && isset($where['__IN__']))
		{
			$arrWhereIn = array();
			$whereIn = $where['__IN__'];
			unset($where['__IN__']);
			foreach($whereIn as $_field => $_val)
			{
				$_tmpVal = is_array($_val) ? implode("','", $_val) : $_val;
				$arrWhereIn[] = "`{$_field}` IN ('".$_tmpVal."')";
			}
			!empty($arrWhereIn) && $arrWhere[] = implode(' AND ', $arrWhereIn);
		}

		if(is_array($where) && isset($where['__NOTIN__']))
		{
			$arrWhereNotIn = array();
			$whereNotIn = $where['__NOTIN__'];
			unset($where['__NOTIN__']);
			foreach($whereNotIn as $_field => $_val)
			{
				$_tmpVal = is_array($_val) ? implode("','", $_val) : $_val;
				$arrWhereNotIn[] = "`{$_field}` NOT IN ('".$_tmpVal."')";
			}
			!empty($arrWhereNotIn) && $arrWhere[] = implode(' AND ', $arrWhereNotIn);
		}

		if(is_array($where))
		{
			foreach ( $where as $key=>$val )
			{
				if ( !is_array( $val ) )
				{
					$arrWhere[] = "`{$key}`='{$this->conn->escape($val)}'";
				}
				else
				{
					$arrWhere[] = "`{$key}`{$val[0]}'{$this->conn->escape($val[1])}'";
				}
			}
		}
		else
		{
			$arrWhere[] = $where;
		}


		return empty($arrWhere) ?  ' AND ' . $where : ' AND ' . implode(' AND ', $arrWhere);
	}

	/**
	 *	分页函数
	 *
	 *	@param string 	$sql  		sql语句
	 * 	@param int		$page		当前页面
	 *  @param int 		$pageSize	每页页数
	 */
	private function get_pager_data( $sql = '', $page = 1, $pageSize = 20 )
	{
		$recordCount = 0;
		$pageCount = 1;
		$fPageIdx= $pPageIdx = $nPageIdx = $lPageIdx = 1;
		$rows = null;
		$recordCount = $this->conn->get_var("select count(*) from ($sql) as pagertable");
		if($recordCount > 0) {
			$pageCount = $lPageIdx = ceil($recordCount/$pageSize);

			$page = $page <= 0 ? 1 : $page;
			$page = $page > $pageCount ? $pageCount : $page;
			$pPageIdx = $page > 1 ? $page - 1 : 1;
			$nPageIdx = $page >= $pageCount ? $pageCount : $page + 1;
			$start = ($page - 1)*$pageSize;
			$rows = $this->conn->get_results($sql . " limit " . $start . "," . $pageSize);
		}

		$data = array(
			'RecordCount' => $recordCount,
			'PageCount' => $pageCount,
			'PageSize' => $pageSize,
			'CurrentPage' => $page,
			'First'	=> $fPageIdx,
			'Prev' => $pPageIdx,
			'Next' => $nPageIdx,
			'Last' => $lPageIdx,
			'PagerStr' => '',
			'DataSet' => $rows,
		);

		return $data;
	}
}
?>