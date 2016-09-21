<?php
	class Db
	{
		protected $conn;
		protected $table;

		public function __construct( $db, $table )
		{
			$this->conn  = $db;
			$this->table = $table;
		}

		function get_list(  $arrWhere = '', $arrCol = '' )
		{
			return $this->conn->get_list( $this->table, $this->getSqlWhere($arrWhere), $arrCol );
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

		/**
		 * 获取重整后的sql语句条件信息
		 *
		 * @param string|array $where 条件信息
		 * @param boolean $cond2Str 是否将数组类型的条件参数转为字符串
		 * @return string|array
		 */
		private function getSqlWhere($where, $cond2Str=false){
			$rebuild = false;
			$arrWhere = array();
			if(isset($where['__IN__'])){
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

			if(isset($where['__NOTIN__'])){
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
					foreach ( $where as $key=>$val ){
						$arrWhere[] = "`{$key}`='{$this->conn->escape($val)}'";
					}
				}else{
					$arrWhere[] = $where;
				}
			}elseif($cond2Str && is_array($where) && !empty($where)){
				foreach ( $where as $key=>$val ){
					$arrWhere[] = "`{$key}`='{$this->conn->escape($val)}'";
				}
			}
			return empty($arrWhere) ? $where : implode(' AND ', $arrWhere);
		}

		/**
		 * 获取一条记录
		 *
		 * @param array $cond 条件
		 * @return object
		 */
		public function get($cond=array(), $arrCol='', $outputType=OBJECT){
			if(empty($arrCol)){
				$cols = '*';
			}elseif(is_array($arrCol)){
				$cols = '`'.implode('`,`', $arrCol).'`';
			}else{
				$cols = $arrCol;
			}
			$sql = 'SELECT '.$cols.' FROM `'.$this->table.'` WHERE '.$this->getSqlWhere($cond, true);
			return $this->conn->get_row($sql, $outputType);
		}

		/**
		 * 获取记录列表
		 *
		 * @param array $cond 条件
		 * @param array $order 排序，字段=>排序
		 * @param integer $page 页码
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
	}
?>