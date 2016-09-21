<?php
if ( !defined('HN1') ) die("no permission");

/**
 *	足迹模型类
 */

class HistoryModel extends Model
{
	 public function __construct($db, $table='')
	 {
        $table = 'history';
        parent::__construct($db, $table);
    }


	/*
	 * 功能：检测该产品当天的浏览记录是否存在
	 * */
	public function checkIsHas( $user_id, $type, $bussiness_id )
	{
		return $this->getCount(array('user_id'=>$user_id,'business_id'=>$bussiness_id,'type'=>$type,'_string_'=>"date_format(`create_date`,'%Y-%m-%d') = '".date('Y-m-d')."'"));
	}

	// 插入产品浏览记录
	public function HistoryAdd( $user_id, $type, $bussiness_id, $activity_id )
	{
		$arrParam = array(
			'user_id' 		=> $user_id,
			'type'			=> $type,
			'business_id'	=> $bussiness_id,
			'create_by'		=> $user_id,
			'create_date'	=> date('Y-m-d H:i:s'),
			'update_by'		=> $user_id,
			'update_date'	=> date('Y-m-d H:i:s'),
			'activity_id'	=> $activity_id
		);

		return $this->add($arrParam);
	}

	// 更新产品浏览记录
	public function HistoryUpdate( $user_id, $type, $bussiness_id, $activity_id )
	{
		$arrParam = array(
			'update_date'	=> date('Y-m-d H:i:s')
		);

		$arrWhere = array(
			'user_id' 		=> $user_id,
			'type'			=> $type,
			'business_id'	=> $bussiness_id,
			'activity_id'	=> $activity_id,
			'_string_'	=> "date_format(`create_date`,'%Y-%m-%d') = CURDATE()"
		);

		return $this->modify( $arrParam, $arrWhere );
	}

	/*
	 * 获取浏览的商品列表(1周内)
	 * */
	public function getHistoryList( $user_id, $Limit='' )
	{
		$arrWhere = array(
			'user_id' 	=> $user_id,
			'type'		=> 1,
			'_string_'	=> "TO_DAYS(NOW()) - TO_DAYS(`create_date`) <= 7"
		);

		return $this->getAll( $arrWhere,'*', '`update_date` DESC', $Limit );
	}

	/*
	 * 获取用户的浏览数（一周内）
	 * */
	public function getHistoryCount( $user_id )
	{
		$arrWhere = array(
			'user_id' 	=> $user_id,
			'type'		=> 1,
			'_string_'	=> "TO_DAYS(NOW()) - TO_DAYS(`create_date`) <= 7"
		);
		return $this->getCount( $arrWhere );
	}

	/*
	 * 功能：清空用户的历史记录
	 * */
	public function setHistoryFlush( $user_id )
	{
		return $this->delete( array( 'user_id'=>$user_id ) );
	}

}
?>
