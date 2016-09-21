<?php
if ( !defined('HN1') ) die("no permission");

/**
 *	活动模型类
 */

class ActivityTimeModel extends Model
{
	 public function __construct($db, $table='')
	 {
        $table = 'activity_title';
        parent::__construct($db, $table);
        $this->ProductModel = D('Product');
    }


	/**
	 *	功能：获取抢购商品列表
	 */
	public function getProductList( $nActivityID )
	{
		$arrSeckillProduct	= $this->ProductModel->getProductListFromActicityID( $nActivityID );
		$nAllProductNum		= 0;

		foreach( $arrSeckillProduct as $SeckillProduct )
		{
			$nAllProductNum 												+= $SeckillProduct->activity_stock;
			$objProduct['list'][$SeckillProduct->product_id] 				= $SeckillProduct;
			$sales = intval( (($SeckillProduct->activity_num - $SeckillProduct->activity_stock) / $SeckillProduct->activity_num) * 100 );
			$objProduct['list'][$SeckillProduct->product_id]->sales			= $sales;
		}

		$objProduct['all_num']	=	$nAllProductNum;

		return $objProduct;
	}


	/**
	 *	获取当天抢购专场
	 */
	public function getSeckillActivityList()
	{
		$todate 	= date( 'Y-m-d' );
		$tomorow 	= date( 'Y-m-d',time() + 86400 * 2 );
		$strSQL 	= "
						SELECT
							atime.`id`,
							atime.`begin_time`,
							atime.`end_time`,
							atime.`title`,
							atime.`activity_date`,
							atime.`banner`
						FROM
							activity_time atime
						WHERE
							1=1
						AND
							atime.type=0
						AND
							atime.channel=2
						AND
						(
							'{$todate}' <= date_format(atime.activity_date,'%Y-%m-%d')
						AND
							'{$tomorow}' > date_format(atime.activity_date,'%Y-%m-%d')
						)
						ORDER BY
							`activity_date` ASC
					";

		$SeckillActivityList = $this->query( $strSQL );

		if ( $SeckillActivityList == NULL )
		{
			return NULL;
		}

		foreach( $SeckillActivityList as $SeckillInfo )
		{
			$arrSeckill[$SeckillInfo->id] 				= $SeckillInfo;
		}

		return $arrSeckill;
	}

}
?>
