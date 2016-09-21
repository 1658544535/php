<?php
/**
 * 用户售后列表
 */
class UserOrderRefundModel extends Model
{
	public function __construct($db, $table='')
	{
        $table = 'user_order_refund';
        parent::__construct($db, $table);
    }

    /**
     *	功能：获取用户售后列表
     *	@param int		$nUserID		用户ID
     *  @param float	$fCheckVaild	是否只获取有效的优惠券
     */
	public function getUserOrderRefundList( $nUserID )
	{
		$strSQL = "SELECT
						uor.*,
						uod.`product_image`,
						( SELECT `name` FROM `user_shop` WHERE `id`= uor.`shop_id` ) as `shop_name`
					FROM
						`user_order_refund` AS uor
					LEFT JOIN
						`user_order_detail`	AS uod
					ON
						uor.`detail_id`=uod.`id`
					WHERE
						uor.`user_id`={$nUserID}
					ORDER BY
						uor.`create_date` DESC
					";

		return $this->query( $strSQL );
	}

	public function getUserOrderRefundCount( $nUserID )
	{
		$rs = $this->getUserOrderRefundList( $nUserID );
		return count($rs);
	}

	/**
	 *	功能：获取用户售后订单信息
	 */
	public function getUserOrderRefundInfo( $nUserID, $nRefundID )
	{
		$strSQL = "SELECT
						uor.*,
						uod.`product_image`,
						( SELECT `name` FROM `user_shop` WHERE `id`= uor.`shop_id` ) as `shop_name`
					FROM
						`user_order_refund` AS uor
					LEFT JOIN
						`user_order_detail`	AS uod
					ON
						uor.`detail_id`=uod.`id`
					WHERE
						uor.`user_id`={$nUserID}
					AND
						uor.`id`={$nRefundID}
					ORDER BY
						uor.`create_date` DESC
					";

		return $this->query( $strSQL, true );
	}

	/**
	 *	功能：获取状态信息
	 */
	public function getStatusDesc( $nStatus )
	{
		$arr = array(
			1 => '审核',
			2 => '请退货',
			3 => '退货中',
			4 => '退货成功',
			5 => '退货失败',
			6 => '审核不成功'
		);

		return $arr[$nStatus];
	}
}
?>