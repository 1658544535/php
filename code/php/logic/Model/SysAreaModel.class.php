<?php
if ( !defined('HN1') ) die("no permission");

/**
 *	系统地址
 */

class SysAreaModel extends Model
{
	 public function __construct($db, $table='')
	 {
        $table = 'sys_area';
        parent::__construct($db, $table);
    }



	/**
	 *	 根据地址ID获取地址信息
	 */
	public function getAreaDesc( $nAreaID )
	{
		$rs = $this->get( array('id'=>$nAreaID), 'name' );
		return $rs->name;
	}

}
?>
