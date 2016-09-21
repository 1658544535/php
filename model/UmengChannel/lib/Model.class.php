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

	/**
	 * 获取重整后的sql语句条件信息
	 *
	 * @param string|array $where 条件信息
	 * 有两种格式：
	 * 1、 $arr['id'] = 123
	 * 2、 $arr['id'] = array( '!=','123' )  ==> id != 123
	 *
	 * @param boolean $cond2Str 是否将数组类型的条件参数转为字符串
	 * @return string|array
	 */
	private function getSqlWhere($where, $cond2Str=false){
		$rebuild = false;
		$arrWhere = array();
		if(is_array($where) && isset($where['__IN__'])){
			$arrWhereIn = array();
			$whereIn = $where['__IN__'];
			unset($where['__IN__']);
			foreach($whereIn as $_field => $_val){
				$_tmpVal = is_array($_val) ? implode("','", $_val) : $_val;
				$arrWhereIn[] = "`{$_field}` IN ('".$_tmpVal."')";
			}
			!empty($arrWhereIn) && $arrWhere[] = implode(' AND ', $arrWhereIn);
			$rebuild = true;
		}

		if(is_array($where) && isset($where['__NOTIN__'])){
			$arrWhereNotIn = array();
			$whereNotIn = $where['__NOTIN__'];
			unset($where['__NOTIN__']);
			foreach($whereNotIn as $_field => $_val){
				$_tmpVal = is_array($_val) ? implode("','", $_val) : $_val;
				$arrWhereNotIn[] = "`{$_field}` NOT IN ('".$_tmpVal."')";
			}
			!empty($arrWhereNotIn) && $arrWhere[] = implode(' AND ', $arrWhereNotIn);
			$rebuild = true;
		}

		if($rebuild && !empty($where)){
			if(is_array($where)){
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
			}else{
				$arrWhere[] = $where;
			}
		}elseif($cond2Str && is_array($where) && !empty($where)){
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
		return empty($arrWhere) ? $where : implode(' AND ', $arrWhere);
	}

	/**
	 * 获取一条记录
	 *
	 * @param array $cond 条件
	 * @param string|array $fields 需获取的字段
	 * @param string $outputType 返回的结构类型，OBJECT对象，ARRAY_A关联数组，ARRAY_N数值数组
	 * @return object
	 */
	public function get($cond=array(), $fields='*', $outputType=OBJECT){
		if(empty($fields)){
			$cols = '*';
		}elseif(is_array($fields)){
			$cols = '`'.implode('`,`', $fields).'`';
		}else{
			$cols = $fields;
		}
		echo $sql = 'SELECT '.$cols.' FROM `'.$this->table.'` WHERE '.$this->getSqlWhere($cond, true);
		return $this->conn->get_row($sql, $outputType);
	}

	/**
	 * 获取记录列表
	 *
	 * @param array $cond 条件
	 * @param array $order 排序，字段=>排序
	 * @param integer $page 页码，负数则不分页获取全部
	 * @param integer $perpage 每页数量
	 * @return array
	 */
	public function gets($cond=array(), $order=array(), $page=1, $perpage=20){
		$sql = 'SELECT * FROM `'.$this->table.'` WHERE 1=1';
		$sqlWhere = $this->getSqlWhere($cond, true);
		$sqlWhere && $sql .= ' AND '.$sqlWhere;
		if(!empty($order)){
			$arrOrder = array();
			foreach($order as $f => $o){
				$arrOrder[] = $f.' '.$o;
			}
			!empty($arrOrder) && $sql .= ' ORDER BY '.implode(',', $arrOrder);
		}

		return get_pager_data($this->conn, $sql, $page, $perpage);
	}

	/**
	 * 添加记录
	 *
	 * @param array $data 数据，字段名=>值
	 * @param string $table 表名，未指定则使用实例化时指定的表名
	 * @param boolean $replace 是否使用replace语句
	 * @return integer|boolean false失败
	 */
	public function add($data, $table='', $replace=false){
		if(empty($data)){
			return false;
		}else{
			$fields = array();
			$values = array();
			foreach($data as $k => $v){
				$fields[] = $k;
				$values[] = $v;
			}
			empty($table) && $table = $this->table;
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
	public function modify($data, $cond, $table=''){
		if(empty($data)){
			return false;
		}else{
			empty($table) && $table = $this->table;
			$sqlSet = array();
			foreach($data as $k => $v){
				$sqlTmp = "`{$k}`=";
				$sqlTmp .= is_string($v) ? "'{$v}'" : $v;
				$sqlSet[] = $sqlTmp;
			}
			$sql = "UPDATE `{$table}` SET ".implode(',', $sqlSet).' WHERE '.$this->getSqlWhere($cond, true);
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
			empty($table) && $table = $this->table;
			$sql = "DELETE FROM `{$table}` WHERE ".$this->getSqlWhere($cond, true);
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
	 * @param array $cond 条件
	 * @param array $order 排序，字段=>排序
	 * @param string $output 返回的结构类型，OBJECT对象，ARRAY_A关联数组，ARRAY_N数值数组
	 * @return array
	 */
	public function getAll($cond=array(), $order=array(), $output = OBJECT){
		$sql = 'SELECT * FROM `'.$this->table.'` WHERE 1=1';
		$sqlWhere = $this->getSqlWhere($cond, true);
		$sqlWhere && $sql .= ' AND '.$sqlWhere;
		if(!empty($order)){
			$arrOrder = array();
			foreach($order as $f => $o){
				$arrOrder[] = $f.' '.$o;
			}
			!empty($arrOrder) && $sql .= ' ORDER BY '.implode(',', $arrOrder);
		}

		return $this->conn->get_results($sql, $output);
	}

	/*
	 * 功能：获取记录数
	 * 参数：
	 * @param array cond: 查询条件
	 * @return int  :记录数
	 * */
	public function getCount($cond=array())
	{
		$sql = 'SELECT count(*) FROM `'.$this->table.'` WHERE 1=1';
		$sqlWhere = $this->getSqlWhere($cond, true);
		$sqlWhere && $sql .= ' AND '.$sqlWhere;
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

		if ( $isPage )
		{
			return get_pager_data($this->conn, $sql, $page, $perpage);
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
}
?>