<?php
/**
 * 专场收藏模型
 */
class UserSpecialCollectModel extends Model
{
	 public function __construct($db, $table=''){
        $table = 'user_special_collect';
        parent::__construct($db, $table);
    }

    /**
	 *	功能: 用户收藏专场列表
	 */
	public function getCollectList( $nUser )
	{
		$arrWhere = array(
			'user_id'		=> $nUser
		);
		return $this->getAll($arrWhere);
	}

    /**
	 *	功能:获取收藏数
	 */
    public function getCollectNum( $user_id )
    {
    	return $this->getCount( array('user_id'=>$user_id) );
    }

	/**
	 *	功能:判断用户是否收藏过指定专场
	 */
	public function isCollect( $nUser, $nSpeciaID, $nActivityID )
	{
		$arrWhere = array(
			'user_id'		=> $nUser,
			'special_id'	=> $nSpeciaID,
			'activity_id'	=> $nActivityID
		);
		return $this->getCount($arrWhere);
	}

	/**
	 *	功能:判断用户是否收藏过指定专场
	 */
	public function CollectAdd( $nUser, $nSpeciaID, $nActivityID )
	{
		$data = array(
			'user_id'		=> $nUser,
			'special_id'	=> $nSpeciaID,
			'activity_id'	=> $nActivityID,
			'create_by'		=> $nUser,
			'create_date'	=> date('Y-m-d H:i:s'),
			'update_by'		=> $nUser,
			'update_date'	=> date('Y-m-d H:i:s'),
			'version'		=> 0

		);

		return $this->add($data );
	}

	/**
	 *	功能:判断用户是否收藏过指定专场
	 */
	public function CollectDel( $nUser, $nSpeciaID, $nActivityID )
	{
		$arrWhere = array(
			'user_id'		=> $nUser,
			'special_id'	=> $nSpeciaID,
			'activity_id'	=> $nActivityID
		);
		return $this->delete($arrWhere );
	}
}
?>