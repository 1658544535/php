<?php
/**
 * 优惠券模型
 */
class UserCouponModel extends Model
{
	 public function __construct($db, $table=''){
        $table = 'user_coupon';
        parent::__construct($db, $table);
    }

    /**
     *	功能：获取指定用户获得的优惠券列表
     *	@param int		$nUserID		用户ID
     *  @param float	$fCheckVaild	是否只获取有效的优惠券
     */
	public function getUserCouponList( $nUserID, $fCheckVaild=FALSE )
	{
		$strWhere = '';

		if ( $fCheckVaild )
		{
			$strWhere .= " AND uc.`used`=0 AND uc.`valid_etime` >= unix_timestamp(now())";
		}

		$strSQL = "SELECT
						c.*,
						uc.`coupon_no`,
						uc.`user_id`,
						uc.`status` AS cpn_status,
						uc.`gen_time`,
						uc.`used`,
						uc.`use_time`,
						uc.`valid_stime` AS usercoupon_valid_stime,
						uc.`valid_etime` AS userconpon_valid_etime
					FROM
						`user_coupon` AS uc
					LEFT JOIN
						`coupon` AS c
					ON
						uc.`coupon_id`=c.`coupon_id`
					WHERE
						uc.`user_id`={$nUserID}
						{$strWhere}
					ORDER BY
						uc.`used` ASC,
						uc.`valid_etime` DESC";

		$rs = $this->query( $strSQL );

		if ( $rs == NULL )
		{
			return NULL;
		}

		foreach( $rs as $CouponInfo )
		{
			$objCouponInfo[$CouponInfo->coupon_no] = $CouponInfo;
			$arr = json_decode($objCouponInfo[$CouponInfo->coupon_no]->content);
			$objCouponInfo[$CouponInfo->coupon_no]->coupon_info = $arr;
		}

		return $objCouponInfo;

	}

	/**
     * 根据券码获取券信息（兑换时使用）
     *
     * @param string $CouponID 券码
     * @return object
     */
    public function getCouponInfo( $CouponID )
    {
        $strSQL = "
					SELECT
						c.*,
						uc.`coupon_no`,
						uc.`user_id`,
						uc.`status` AS cpn_status,
						uc.`gen_time`,
						uc.`used`,
						uc.`use_time`,
						uc.`source`,
						uc.`valid_stime` AS usercoupon_valid_stime,
						uc.`valid_etime` AS userconpon_valid_etime
					FROM
						`user_coupon` AS uc
					LEFT JOIN
						`coupon` AS c
					ON
						uc.`coupon_id`=c.`coupon_id`
					WHERE
						uc.`coupon_no`='{$CouponID}'
				";

		$CouponInfo = $this->query( $strSQL,TRUE );

		if ( $CouponInfo == NULL )
		{
			return NULL;
		}

		$objCouponInfo = $CouponInfo;
		$arr = json_decode($objCouponInfo->content);
		$objCouponInfo->coupon_info = $arr;

		return $objCouponInfo;
    }


   /**
     * 激活
     *
     * @param string $cpnno 券号
     * @param integer $uid 用户id
     * @param array $info 其他信息
     *      cpnid 优惠券id
     *      start 有效开始时间
     *      end 有效结束时间
     *      source 来源类型
     * @return boolean
     */
    public function useCoupon( $cpnno, $uid, $source='' )
    {
    	$nSource = ( $source == '' ) ? 5 : $source;

		$arrParam = array(
			'user_id'	=> $uid,
			'gen_time'	=> time(),
			'source'	=> $nSource
		);

		return $this->modify( $arrParam, array('coupon_no'=>$cpnno) );



//        isset($info['cpnid']) && $val[] = '`coupon_id`='.$info['cpnid'];
//        isset($info['start']) && $val[] = '`valid_stime`='.$info['start'];
//        isset($info['end']) && $val[] = '`valid_etime`='.$info['end'];
//        echo $sql = "UPDATE `user_coupon` SET ".implode(',', $val)." WHERE `coupon_no`='{$cpnno}'";
//        return $this->db->query($sql);
    }

	/**
	 *	获取指定价格内可用的优惠券
	 */
	public function getCanUseCouponList( $nUserID, $nowPrice )
	{
		// 获取全部的优惠券列表
		$getAllCouponList = $this->getUserCouponList( $nUserID, TRUE );

		if ( $getAllCouponList == NULL )
		{
			return NULL;
		}

		foreach( $getAllCouponList as $Coupon )
		{
			if ( $nowPrice >= $Coupon->coupon_info->om )
			{
				$CanUseCouponList[$Coupon->coupon_no] = $Coupon;
			}
		}

		return $CanUseCouponList;
	}



	/**
	 *	功能：添加系统优惠券
	 */
	public function addCoupon( $om, $m )
	{
		$arrContent = array('om'=>strval($om), 'm'=>strval($m));
		$arrParam   = array(
			'name'			=> '满' . $om .'元减'. $m.'元',
			'type'			=> 1,
			'status'		=> 1,
			'valid_stime'	=> time(),
			'valid_etime'	=> time() + 86400 * 30,
			'create_time'	=> time(),
			'content'		=> json_encode( $arrContent )
		);

		return $this->add( $arrParam, 'coupon' );
	}

	/**
	 *	功能：通过优惠券名搜索优惠券信息
	 */
	public function getCouponInfoFromName( $om, $m )
	{
		$content = '{"om":"'.$om.'","m":"'.$m.'"}';
		$rs = $this->get( array('content'=>$content), 'coupon_id', 'OBJECT', 'coupon' );

		if ( $rs == NULL )
		{
			return NULL;
		}

		return $rs->coupon_id;
	}

	/**
	 *	功能：添加用户优惠券
	 */
	public function addUserCoupon( $arrParam )
	{
		return $this->add( $arrParam );
	}
}
?>