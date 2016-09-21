<?php
/**
 * 用户地址模型
 */
class UserAddressModel extends Model
{
	public function __construct($db, $table='')
	{
        $table = 'user_address';
        parent::__construct($db, $table);
    }

	/**
	 *	功能：获取地址相关的省市区信息
	 */
   	public function getAreaInfo( $ids )
   	{
   		$list = array();
		if($ids)
		{
			!is_array($ids) && $ids = array($ids);
			$strSQL = 'SELECT * FROM `sys_area` WHERE `id` IN ('.implode(',', $ids).')';
			$list = $this->query($strSQL);
		}

		return $list;
   	}

    /**
	 *	获取用户地址列表
	 */
   	public function getUserAddressList( $nUserID )
   	{
   		$addressList 	= $this->getAll( array('user_id'=>$nUserID), '*', '`is_default` desc' );

		if ( $addressList == NULL )
		{
			return NULL;
		}

   		foreach( $addressList as $k=>$address )
   		{
   			$arrAddressList[$k] 		= $address;
   			$arrAddressList[$k]->desc 	= $this->getAddressDesc( $address->province, $address->city, $address->area ) . $address->address;
   		}

		return $arrAddressList;
   	}

	/**
	 *	获取订单时默认使用的用户地址
	 */
   	public function getUserAddressOne( $nUserID )
   	{
   		$strSQL 			= "SELECT * FROM `user_address` WHERE `user_id`={$nUserID} ORDER BY `is_default` DESC, `id` DESC LIMIT 1";
		$AddressInfo 	   	= $this->query( $strSQL, TRUE );
		if ( $AddressInfo == NULL )
		{
			return NULL;
		}

		$AddressDesc = $this->getAddressDesc( $AddressInfo->province, $AddressInfo->city, $AddressInfo->area );
		$AddressInfo->desc 	= $AddressDesc .  $AddressInfo->address;
		return $AddressInfo;
   	}

   	/**
	 *	获取用户指定用户指定地点ID的用户地址信息
	 */
   	public function getUserAddressInfo( $nUserID,$nAddressID )
   	{
   		$strSQL = "SELECT * FROM `user_address` WHERE `id`={$nAddressID} AND `user_id`={$nUserID} LIMIT 1";
		$AddressInfo 	   	= $this->query( $strSQL, TRUE );
		if ( $AddressInfo == NULL )
		{
			return NULL;
		}

		$AddressDesc = $this->getAddressDesc( $AddressInfo->province, $AddressInfo->city, $AddressInfo->area );
		$AddressInfo->desc 	= $AddressDesc .  $AddressInfo->address;
		return $AddressInfo;
   	}

	/**
	 *	获取地址描述
	 */
   	private function getAddressDesc( $nProvince, $nCity, $nArea )
   	{
		$SysAreaModel 		= D('SysArea');
		$AddressDesc 	= $SysAreaModel->getAreaDesc( $nProvince ) .  $SysAreaModel->getAreaDesc( $nCity ) . $SysAreaModel->getAreaDesc( $nArea );
   		return $AddressDesc;
   	}


}
?>