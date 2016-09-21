<?php
/**
 * 商品收藏模型
 */
class UserCollectModel extends Model
{
	 public function __construct($db, $table=''){
        $table = 'user_collect';
        parent::__construct($db, $table);
    }

    /**
	 *	功能:获取收藏数
	 */
    public function getCollectNum( $user_id )
    {
    	return $this->getCount( array('user_id'=>$user_id) );
    }

    /**
	 *	功能:用户的收藏列表
	 */
	public function getCollectList( $nUser )
	{
		$arrWhere = array(
			'user_id'		=> $nUser
		);
		return $this->getAll($arrWhere, '*', '`id` DESC');
	}

	/**
	 *	功能:判断用户是否收藏过指定产品
	 */
	public function isCollect( $nUser, $nProductID )
	{
		$arrWhere = array(
			'user_id'		=> $nUser,
			'product_id'	=> $nProductID
		);
		return $this->getCount($arrWhere, 'user_collect');
	}

	/**
	 *	功能:判断用户是否收藏过指定产品
	 */
	public function CollectAdd( $nUser, $nProductID, $nActivityID )
	{
		$data = array(
			'user_id'		=> $nUser,
			'product_id'	=> $nProductID,
			'create_by'		=> $nUser,
			'create_date'	=> date('Y-m-d H:i:s'),
			'version'		=> 0,
			'activity_id'	=> $nActivityID,
		);

		return $this->add($data, 'user_collect' );
	}

	/**
	 *	功能:判断用户是否收藏过指定产品
	 */
	public function CollectDel( $nUser, $nProductID )
	{
		$arrWhere = array(
			'user_id'		=> $nUser,
			'product_id'	=> $nProductID
		);
		return $this->delete($arrWhere, 'user_collect' );
	}


}
?>