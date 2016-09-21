<?php
/**
 * 产品模型
 */
class ProductModel extends Model
{
	 public function __construct($db, $table=''){
        $table = 'product';
        parent::__construct($db, $table);
    }

    /**
	 *	功能：获取每日10件的商品信息
	 */
// 	public function getTopTenList()
// 	{
// 		$strSQL = "SELECT
// 						pa.`product_id`
// 					FROM
// 						`product_activity` as pa
// 					WHERE
// 						pa.`type`=1
// 					ORDER BY
// 						pa.`product_id` DESC";

// 		$objProductID = $this->query( $strSQL );

// 		foreach( $objProductID as $nProductID )
// 		{
// 			$ProductList[] = $this->getProductInfo( $nProductID->product_id );
// 		}

// 		return $ProductList;
// 	}

	/**
	 *	功能：获取钱包专区产品信息
	 */
	public function getWalletProductList()
	{
		$objProductList = NULL;
		$strSQL = "SELECT
						ag.`product_id` ,
						p.`product_name`,
						p.`image`,
						ag.`active_price`
					FROM
						`activity_goods` as ag
					LEFT JOIN
						`product` as p
					ON
						p.`id`=ag.`product_id`
					WHERE
						`time_id`=(
							SELECT
								`id`
							FROM
								`activity_time`
							WHERE
								`title`='钱包专区'
							AND
								`isdelete`=0
						)
					ORDER BY
						ag.`sorting` DESC,
						ag.`create_date` DESC
				";

		return $this->query( $strSQL );
	}


	/**
	 *	功能：获取产品列表( 通过活动ID )
	 */
    public function getProductListFromActicityID( $nActiveID, $LimitCount='' )
    {
		$Limit = '';

    	if ( $LimitCount != '' )
    	{
    		$Limit = " LIMIT " . $LimitCount;
    	}

    	$strSQL = "SELECT
    					*
					FROM
						`product`
					WHERE
						1=1
					ORDER BY
						`id` DESC
					{$Limit}
			";
		return $this->query( $strSQL );
    }

    /**
	 *	功能：获取指定产品分类的产品信息
	 *	@param  int 	$nProductType	产品类型
	 *	@param  string 	$strOrderBy		排序
	 *	@param  string 	$strKeyword		关键字
	 *  @param  string 	$from			来源（  ）
	 */
	public function getProductList( $nProductType='', $strOrderBy='', $strKeyword='', $strLimit='', $from='' )
    {
    	$strWhere = '';

    	if ( $strOrderBy == '' )
    	{
    		$strOrderBy = "`id` DESC";
    	}

    	if ( $strLimit != '' )
    	{
    		$strLimit = ' LIMIT ' . $strLimit;
    	}

    	if ( $nProductType != '' )
    	{
    		$from = 'type';
    	}

    	if ( $strKeyword != '' )
    	{
    		$from = 'search';
    	}

    	switch ( $from )
    	{
    		case "type":
    			$strWhere .= ' AND `product_type_id`=' . $nProductType;
    		break;

    		case 'search':
    			$strWhere .= " AND `product_name` LIKE '%" . $this->escape($strKeyword) . "%'  AND `status` =1   ";
    		break;

    		case 'rank':
    			$strWhere .= " AND `sell_number` + `base_number` > 0 ";
				$strOrderBy = 	"`sell_number`+`base_number` DESC, `id` DESC";
    		break;
    	}

    	$strSQL = $this->getProductListSQL( $strWhere, $strOrderBy, $strLimit );

    	return $this->query( $strSQL );
    }

	/**
	 *	功能：获取产品列表的SQL语句
	 */
    private function getProductListSQL( $strWhere, $strOrderBy, $strLimit )
    {
		$strSQL = "SELECT
    					*
					FROM
						`product`
					WHERE
						1=1
					$strWhere
						
					AND
						`status` = 1
					
					ORDER BY
						{$strOrderBy}
					$strLimit
		";

		return $strSQL;
    }



    /**
	 *	功能：获取产品信息
	 */
    public function getProductInfo( $nProductID, $nSkuID='', $nActivityID=0, $nActivityType=3 )
    {

//     	if ( $nActivityID == 0 )
//     	{
//     			// 通过判断获取指定活动信息
//     		$ActivityInfo = $this->getProductActivity( $nProductID, $nActivityType );
//     	}
//     	else
//     	{
//     		// 获取指定活动信息
//     		$ActivityInfo = $this->get( array( 'id'=>$nActivityID ),array( 'id','begin_time','end_time','title','activity_date','type' ),'OBJECT','activity_time' );
//     	}

		if ( $ActivityInfo == NULL && $nActivityID == 0 )
		{

			// 如果商品没参与活动，则显示普通商品（不予购买）
			$objProductInfo  = $this->getPublicProduct( $nProductID );
			
			$objProductInfo->activity_id 		= 0;
// 			$objProductInfo->enable 			= 0;
//      		$objProductInfo->msg_tip 			= '该商品没有参与活动，不予购买';
		}
// 		else
// 		{
			
// 			// 如果商品参与活动，则根据活动ID显示相应的商品（给予购买）
// 			$objProductInfo  = $this->getActivityProduct( $nProductID, $ActivityInfo->id );

// 			if ( $objProductInfo == NULL )
// 			{
// 				return NULL;
// 			}

// 			// 查找商品的有效性
// 			$this->getProductEnable( $objProductInfo );

// 			// 添加活动信息
// 			$objProductInfo->activity_info 			= $ActivityInfo;
// 			$objProductInfo->activity_info->status 	= 1; 				// 进行中

			// 如果是抢购活动
// 			if ( $objProductInfo->activity_type == 0 )
// 			{
// 				// 判断状态，进行中、结束还是即将开始
// 				$Time 				= time();
// 				$ActivityBeginTime 	= $objProductInfo->activity_info->activity_date .' '. $objProductInfo->activity_info->begin_time .':00';
// 				$ActivityEndTime 	= $objProductInfo->activity_info->activity_date .' '. $objProductInfo->activity_info->end_time   .':00';

// 				if ( $Time < strtotime($ActivityBeginTime) )
// 				{
// 					$objProductInfo->msg_tip 				= '该产品活动还未开始';
// 					$objProductInfo->activity_info->status 	= 2; 				// 未开始
// 				}

// 				if( $Time > strtotime($ActivityEndTime) )
// 				{
// 					$objProductInfo->enable 				= 0;
// 					$objProductInfo->msg_tip 				= '该产品活动已结束';
// 					$objProductInfo->activity_info->status 	= 0; 				// 已结束
// 				}

// 			}
// 		}

		if ( $objProductInfo == NULL )
		{
			return NULL;
		}

		if ( intval($nSkuID) > 0 )
		{
			// 是否根据SKI进行查找
			$this->getProductSkuInfo( $objProductInfo, $nSkuID );
		}
		return $objProductInfo;
    }

     /**
	 *	功能：获取产品指定SKU信息(与getProductInfo关联)
	 *	@param object $objProductInfo  	product表指定商品信息
	 *  @param int $nSkuID  			商品对应sku的信息
	 */
    public function getProductSkuInfo( $objProductInfo, $nSkuID )
    {
    	
    	if ( intval( $nSkuID ) > 0 )
		{
// 			$arrWhere = array( 'product_id'=>$objProductInfo->id, 'activity_id'=>$objProductInfo->activity_id, 'Id'=>$nSkuID );
			$arrWhere = array( 'product_id'=>$objProductInfo->id,  'Id'=>$nSkuID );
		
			$rs = $this->get( $arrWhere, array('stock','price','sku_color_id','sku_format_id'), 'OBJECT', 'product_sku_link');

			if ( $rs != NULL )
			{
// 				$objProductInfo->active_price 	= $rs->price;
// 				$objProductInfo->activity_stock = $rs->stock;
// 				$objProductInfo->sku_link_id 	= $nSkuID;
				
				$objProductInfo->distribution_price 	= $rs->price;
				$objProductInfo->stock_num      = $rs->stock;
				$objProductInfo->sku_link_id 	= $nSkuID;

				$ProductSkuDesc = $this->getProductSkuDesc( array( $rs->sku_color_id, $rs->sku_format_id ) );

				$objProductInfo->sku_info->color_id			= $rs->sku_color_id;
				$objProductInfo->sku_info->format_id		= $rs->sku_format_id;
				
				if ( $rs->sku_color_id == $rs->sku_format_id )
				{
					$objProductInfo->sku_info->sku_desc 		= $ProductSkuDesc[0]->value . ',' . $ProductSkuDesc[0]->value;
					$objProductInfo->sku_info->sku_long_desc 	= '颜色：' . $ProductSkuDesc[0]->value . '，' . '规格：' . $ProductSkuDesc[0]->value;
				}
				else
				{
					$objProductInfo->sku_info->sku_desc 		= $ProductSkuDesc[0]->value . ',' . $ProductSkuDesc[1]->value;
					$objProductInfo->sku_info->sku_long_desc 	= '颜色：' . $ProductSkuDesc[1]->value . '，' . '规格：' . $ProductSkuDesc[0]->value;
				}

				//$objProductInfo->product_name				= $objProductInfo->product_name . '('. $objProductInfo->sku_info->sku_desc .')';
				$objProductInfo->product_name				= $objProductInfo->product_name;
			}
		}

		return $objProductInfo;
    }

	/**
	 *	获取商品的有效性
	 */
    private function getProductEnable( $objProductInfo )
    {

    		$objProductInfo->enable 		= 1;
    		$objProductInfo->msg_tip 		= '该产品活动进行中';

    		if ( $objProductInfo->status == 0 )
			{
				$objProductInfo->enable 	= 0;
				$objProductInfo->msg_tip 	= '该产品已下架';
			}

			if ( $objProductInfo->activity_stock == 0 )
			{
				$objProductInfo->enable 	= 0;
				$objProductInfo->msg_tip 	= '该产品已售罄';
			}

			if ( strtotime( $objProductInfo->end_time ) < time() )
			{
				$objProductInfo->enable 	= 0;
				$objProductInfo->msg_tip 	= '该活动已结束';
			}

		return $objProductInfo;
    }


	/**
	 *	功能：更新产品浏览数
	 */
	public function UpdateViewedNum( $nProductID, $nNowNum )
	{
		$arrData  = array('hits'=> $nNowNum + 1);
		$arrWhere = array( 'id' => $nProductID );
		return $this->modify( $arrData, $arrWhere);
	}


	/**
	 *	功能：获取指定商品对应的品牌信息
	 *	@param int $nActivityID  活动ID
	 */
	public function getProductShopInfo( $nUserID )
	{
		$strSQL = "SELECT
						us.`name`,
						us.`images`,
						us.`product_commt`,
						us.`deliver_commt`,
						us.`logistics_commt`
					FROM
						`user_shop` as us
					WHERE
						us.`user_id` = {$nUserID}";

		return $this->query( $strSQL,true );
	}


	/*
	 * 功能：获取该产品的颜色属性
	 *
	 * @param integer $pid 	商品id
	 * @param integer $aid 	活动id，-1不限
	 * @param string  $type	获取类型 color | format  颜色|规格
	 *
	 * */
	public function getSkuList( $pid, $type='color')
	{
		$arr = null;
		$getCol = ($type=='color') ? '`sku_color_id`' :  '`sku_format_id`';

		$strSQL = "SELECT
						`Id`,
						`attribute`,
						`value`,
						`image`
					FROM
						`sku_attribute`
					WHERE
						`status`=1
					AND
						`Id` IN (
							SELECT
								{$getCol}
							FROM
								`product_sku_link` as psl
							WHERE
								`product_id`={$pid}
							AND
								`status`=1
				";

// 		if ($aid >= 0)
// 		{
// 			$strSQL .= ' AND `activity_id`='.$aid;
// 		}

		$strSQL .= ")";

		$rs 	= $this->query( $strSQL );

		if ( $rs != null )
		{
			foreach( $rs as $info )
			{
				$arr[$info->Id] = $info;
			}
		}

		return $arr;
	}

	/*
	 * 功能：获取该产品是否存在sku
	 * */
	function getProductHasSku( $pid)
	{
		$arrWhere['product_id'] = $pid;

// 		if ( $nActiveId >= 0 )
// 		{
// 			$arrWhere['activity_id'] = $nActiveId;
// 		}

		$total = $this->getCount($arrWhere,'product_sku_link');

		return $total ? TRUE : FALSE;
	}


	/*
	 * 功能：获取产品sku描述
	 * */
	public function getProductSkuDesc($sku_attr)
	{
		$str_attr 	= implode( ',',$sku_attr );
		$strSQL 	= "SELECT `Id`,`attribute`,`value`,`image` FROM `sku_attribute` WHERE `status`=1 AND `Id` in ({$str_attr})";
		$rs 		= $this->query( $strSQL );
		return $rs;
	}


	/**
	 * 获取产品有效的sku信息
	 *
	 * @param string $type 类型，color颜色，format规则
	 * @param integer $pid 产品id
	 * @param integer $skuid sku id
	 * @param integer $aid 活动id
	 * @return array
	 */
	public function getValidSku( $type, $pid, $skuid, $aid )
	{
		$list = array();
		$types = array('color'=>array('get'=>'sku_color_id','set'=>'sku_format_id'), 'format'=>array('get'=>'sku_format_id','set'=>'sku_color_id'));
		$strSQL = "
					SELECT
						*
					FROM
						`sku_attribute`
					WHERE
						`status`=1
					AND
						`Id` IN (
							SELECT
								`{$types[$type]['get']}`
							FROM
								`product_sku_link` as psl
							WHERE
								`product_id`={$pid}
							AND
								`{$types[$type]['set']}`={$skuid}
							AND
								`status`=1
							AND
								`stock`>0
							AND
								`activity_id`={$aid}
						)
				";

		$rs = $this->query( $strSQL );
		if ( $rs != null )
		{
			foreach($rs as $info)
			{
				$list[$info->id] = $info;
			}
		}

		return $list;
	}

	/**
	 * 获取产品对应的sku信息
	 *
	 * @param integer $pid 产品id
	 * @param integer $scid sku颜色id
	 * @param integer $sfid sku规格id
	 * @param integer $aid 活动id
	 * @return object
	 */
	public function getSkuInfo( $pid, $scid, $sfid, $aid )
	{
		$arrWhere = array(
			'product_id' 	=> $pid,
			'sku_color_id' 	=> $scid,
			'sku_format_id'	=> $sfid,
			
		);

		return $this->get( $arrWhere, $fields='*', 'OBJECT', 'product_sku_link' );
	}

	/**
	 * 根据sku id获取sku信息
	 *
	 * @param int $nSkuid
	 * @return obj
	 */
	public function getSkuById( $nSkuid )
	{
		return $this->get( array('Id'=>$nSkuid), $fields='*', 'OBJECT', 'product_sku_link');
	}

	/**
	 * 根据sku id获取多个sku信息
	 *
	 * @param object $db 数据库句柄
	 * @param array $skuids sku id
	 * @return array
	 */
	public function getSkusById($db, $skuids){
		$list = array();
		if(!empty($skuids)){
			$sql = 'SELECT * FROM `product_sku_link` WHERE `Id` IN ('.implode(',', $skuids).')';
			$list = $this->query($sql);
		}
		return $list;
	}


	/**
	 *	功能：通过指定的产品来获取产品活动ID（与getProductInfo方法关联）
	 *
	 *	原理：
	 *	1、如果为抢购商品(activity_time.type=0) 则判断activity_date是否为当天，在判断正在进行的活动
	 *  2、如果商品为其他活动且不是专场，则判断开始结束时间
	 *  3、如果商品为其他活动且是专场，则判断开始结束时间,且判断special_show.stauts=4是否进行中
	 *
	 * 	tip:因为一件商品可以对应多个活动，所以需添加活动类型参数
	 */
    private function getProductActivity( $nProductID, $nActivityType )
    {
    		$strSQL = "SELECT
							atime.`id`,
							atime.`begin_time`,
							atime.`end_time`,
							atime.`title`,
							atime.`activity_date`,
							atime.`type`
						FROM
							`activity_time` AS atime
						LEFT JOIN
							`activity_goods` AS agoods
						ON
							agoods.`time_id`=atime.`id`
						LEFT JOIN
							`special_show` AS ss
						ON
							ss.`activity_id`=atime.`id`
						WHERE
							1=1
							". $this->getActivityTimeSQL( $nActivityType ) ."
						AND
							agoods.`product_id`={$nProductID};
						";

		$rs = $this->query( $strSQL, true );
		return ( $rs == null ) ? 0 : $rs;
    }


	/**
	 *	功能：获取品牌列表
	 */
	public function getBrandList()
	{
		$strSQL = "
					SELECT
						b.logo as logo,
						s.*
					FROM (
							SELECT
								s.user_brand_id,
								s.begin_time,
								s.update_date,
								s.activity_id,
								s.title as title
							FROM
								special_show s
							WHERE
								1=1
							AND
								s.isdelete = 0
							AND (
									UNIX_TIMESTAMP(s.`begin_time`) <= UNIX_TIMESTAMP()
							AND
									UNIX_TIMESTAMP(s.`end_time`) >= UNIX_TIMESTAMP()
								)
							AND
								s.status=4
							ORDER BY
							s.begin_time DESC,
							s.update_date DESC
						) s
					LEFT JOIN
						user_brand u
					ON
						u.id = s.user_brand_id
					LEFT JOIN
						brand_dic b
					ON
						b.id = u.brand_id
					GROUP BY
						b.id
					ORDER BY
						s.begin_time DESC,
						s.update_date DESC
				";

		$rs = $this->query( $strSQL );

		$nowBrandId 	= '';
		$arrBrandList 	= '';

		if ( $rs == NULL )
		{
			return NULL;
		}

		foreach( $rs as $BrandInfo )
		{
			if ( $nowBrandId != $BrandInfo->user_brand_id )
			{
				$nowBrandId 	= $BrandInfo->user_brand_id;
				$arrBrandList[] = $BrandInfo;
			}
		}

		return $arrBrandList;

	}

	/**
	 *	功能：获取活动时间控制的SQL语句
	 */
	private function getActivityTimeSQL( $nActivityType )
	{
		if ( $nActivityType == 0)
		{
			$strWhere = "
							AND
								atime.`type`={$nActivityType}
							AND
								(
									date_format(NOW(),'%Y-%m-%d') = date_format(atime.`activity_date`,'%Y-%m-%d')
							AND
									(
											date_format(NOW(),'%H:%i') >= atime.begin_time
										AND
											date_format(NOW(),'%H:%i') < atime.end_time
									)
								)
							AND
								atime.channel=2
						";
			$strWhere = "
							AND
								atime.`type`={$nActivityType}
							AND
								date_format(NOW(),'%Y-%m-%d') = date_format(atime.`activity_date`,'%Y-%m-%d')
							AND
								atime.channel=2
						";

		}

		if ( $nActivityType > 0 && $nActivityType != 3 )
		{
			$strWhere = "
							AND
								atime.`type`={$nActivityType}
							AND
								(
										date_format(NOW(),'%Y-%m-%d %T') >= date_format(atime.`begin_time`,'%Y-%m-%d %T')
									AND
										date_format(NOW(),'%Y-%m-%d %T') < date_format(atime.`end_time`,'%Y-%m-%d %T')
								)
						";

		}

		if ( $nActivityType > 0 && $nActivityType == 3 )
		{
			$strWhere = "
							AND
								atime.`type`={$nActivityType}
							AND
								(
										date_format(NOW(),'%Y-%m-%d %T') >= date_format(atime.`begin_time`,'%Y-%m-%d %T')
									AND
										date_format(NOW(),'%Y-%m-%d %T') < date_format(atime.`end_time`,'%Y-%m-%d %T')
								)
							AND
								ss.`status`=4
						";

		}

		return $strWhere;
	}

	/**
	 *	功能：获取普通商品的ID（找不到活动ID的商品）
	 */
	public function getPublicProduct( $nProductID )
	{
		$strSQL = "
					SELECT
						p.`id`,
						p.`user_id`,
						p.`product_no`,
						p.`product_num`,
						p.`product_type_id`,
						p.`product_type_ids`,
						p.`product_name`,
						p.`product_sketch`,
						p.`selling_price` ,
						p.`distribution_price`,
						p.`content`,
						p.`unit`,
						p.`discount`,
						p.`image`,
						p.`qrcode`,
						p.`hits`,
						p.`is_introduce`,
						p.`sell_number`,
						p.`is_new`,
						p.`recommend`,
						p.`brand`,
						p.`texture`,
						p.`age`,
						p.`location`,
						p.`is_power`,
						p.`pack`,
						p.`is_hotsale`,
						p.`postage_type`,
						p.`weight`,
						p.`status`,
						p.`user_brand_id`,
						p.`product_type1`,
						p.`product_commt`,
						p.`tag`,
						p.`age_desc`,
						( SELECT `brand_name` FROM `user_brand` WHERE `id`= p.`user_brand_id` ) as `brand_name`
					FROM
						`product` as p
					WHERE
						p.`id`={$nProductID}
					AND
						p.`status`=1
		";

		return $objProductInfo = $this->query( $strSQL, true );
	}


	/**
	 *	功能：获取普通商品的ID（找到活动ID的商品）
	 */
	public function getActivityProduct( $nProductID, $nActivityID )
	{
		$strSQL = "
					SELECT
						at.`title` as activity_title,
						at.`type` as activity_type,
						at.`end_time`,
						ag.`time_id` as activity_id,
						ag.`sell_price`,
						ag.`active_price`,
						ag.`tips`,
						ag.`activity_stock`,
						ag.`activity_num`,
						ag.`sku_link_id`,
						p.`id`,
						p.`user_id`,
						p.`product_no`,
						p.`product_num`,
						p.`product_type_id`,
						p.`product_type_ids`,
						p.`product_name`,
						p.`product_sketch`,
						p.`content`,
						p.`unit`,
						p.`discount`,
						p.`image`,
						p.`qrcode`,
						p.`hits`,
						p.`is_introduce`,
						p.`sell_number`,
						p.`version`,
						p.`is_new`,
						p.`recommend`,
						p.`brand`,
						p.`texture`,
						p.`age`,
						p.`location`,
						p.`is_power`,
						p.`pack`,
						p.`distribution_price`,
						p.`is_hotsale`,
						p.`postage_type`,
						p.`weight`,
						p.`status`,
						p.`user_brand_id`,
						p.`product_type1`,
						p.`product_commt`,
						p.`tag`,
						p.`age_desc`,
						( SELECT `brand_name` FROM `user_brand` WHERE `brand_id`= p.`user_brand_id` LIMIT 1) as `brand_name`
					FROM
						`activity_time` as at,
						`activity_goods` as ag,
						`product` as p
					WHERE
						p.`id`={$nProductID}
					AND
						p.`id`=ag.`product_id`
					AND
						ag.`time_id`= at.`id`
					AND
						ag.`time_id`={$nActivityID}
					AND
						ag.`status`=1
		";

		return $this->query( $strSQL, true );
	}

	/**
	 *	功能：通过user_id或brand_id获取用户品牌信息
	 */
	 public function getUderBrandInfoFromUserIDORBrandID( $nUserID='', $nBrandID='' )
	 {
	 	$UserBrandModel = M('user_brand');

	 	if ( (int)$nUserID != 0 )
	 	{
	 		$arrParam['user_id'] = $nUserID;
	 	}

	 	if ( (int)$nBrandID != 0 )
	 	{
	 		$arrParam['brand_id'] = $nBrandID;
	 	}

	 	return $UserBrandModel->get( $arrParam );
	 }

}
?>