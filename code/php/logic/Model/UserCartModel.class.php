<?php
/**
 * 用户购物车模型
 */
class UserCartModel extends Model
{
	 public function __construct($db, $table=''){
        $table = 'user_cart';
        parent::__construct($db, $table);
    }

	/**
	 *	功能：获取指定购物车ID的信息
	 *	参数：$strCartIds string 购物车ID
	 *	@return null:记录为空   array( 'list'(有效列表) 'cardid'(有效ID) )
	 */
   	public function getCartInfoFromCartId( $user_id, $strCartIds )
   	{
   		$isWallet						= TRUE;			// 是否为钱包商品
   		if ( $strCartIds == NULL )
   		{
   			return NULL;
   		}

		$strSQL = "
					SELECT
						uc.`id`,
						uc.`user_id`,
						uc.`shop_id`,
						uc.`product_id`,
						uc.`product_name`,
						uc.`product_image`,
						uc.`stock_price_old`,
						uc.`stock_price`,
						uc.`num`,
						uc.`type`,
						uc.`status`,
						uc.`postage_type`,
						uc.`weight`,
						uc.`sku_link_id`,
						uc.`activity_id`,
						uc.`activity_name`,
						uc.`product_model`,
						uc.`stock_id`,
						uc.`channel`,
						at.`activity_date`,
						at.`end_time`,
						at.`type`,
						ss.`discount_type`,
						ss.`discount_context`
					FROM
						`user_cart` 	as uc
					LEFT JOIN
						`activity_time` as at
					ON
						uc.`activity_id`=at.`id`
					LEFT JOIN
						`special_show` as ss
					ON
						ss.`activity_id`=at.`id`
					WHERE
						uc.`user_id`={$user_id}
					AND
						uc.`id` IN ({$strCartIds})
					ORDER BY
						uc.`id` DESC
				";

//		$strSQL = "SELECT * FROM `user_cart` WHERE `user_id`={$user_id} AND `id` IN ({$strCartIds})";
		$objCartData = $this->query($strSQL);

		if ( $objCartData == NULL )
		{
			return NULL;
		}

		$fAllProductPrice 		= 0;	// 全部商品金额
		$AllProductWeight 		= 0;	// 全部商品总重
		$AllProductWeightNoPack = 0;	// 无包邮商品总重

		foreach( $objCartData as $CartInfo )
		{
			if( $CartInfo->type != 3 )
			{
				$isWallet = FALSE;
			}

			if ( $CartInfo->postage_type == 0 )
			{
				$AllProductWeightNoPack += $CartInfo->weight;
			}

			$AllProductWeight += $CartInfo->weight;

			$fAllProductPrice += $CartInfo->stock_price * $CartInfo->num;

			$arrCartList 	= $this->getCartInfo( $objCartData );
			$arrValid[]		= $CartInfo->id;
		}

		return array( 'list'=>$arrCartList, 'cartid'=>$arrValid, 'isWallet'=>$isWallet, 'AllPrice'=>$fAllProductPrice, 'AllWeight'=>ceil($AllProductWeight), 'AllWeightNoPack'=>ceil($AllProductWeightNoPack) );
   	}

   	public function addCart($arrParam)
   	{
   		$objParam = (object)$arrParam;

		$strSQL  = "INSERT INTO ".USER_CART_TABLE." (
					`user_id`,
					`shop_id`,
					`product_id`,
					`product_name`,
					`product_image`,
					`stock_price`,
					`num`,
					`channel`,
					`create_date`,
					`update_date`,
					`postage_type`,
					`weight`,
					`sku_link_id`,
					`type`,
					`create_by`,
					`update_by`,
					`activity_id`,
					`activity_name`
				) values (
					{$objParam->user_id},
					{$objParam->shop_id},
					{$objParam->product_id},
					'{$objParam->product_name}',
					'{$objParam->product_image}',
					'{$objParam->stock_price}',
					{$objParam->num},
					'{$objParam->channel}',
					'{$objParam->create_date}',
					'{$objParam->update_date}',
					'{$objParam->postage_type}',
					'{$objParam->weight}',
					IF( $objParam->sku_link_id>0,$objParam->sku_link_id,null),
					{$objParam->type},
					{$objParam->user_id},
					{$objParam->user_id},
					{$objParam->activity_id},
					'{$objParam->activity_name}'
				)";
			
		return $this->query($strSQL);
   	}


	/**
	 *	功能：获取购物车列表
	 */
// 	public function getUserCartList( $strCartIds='' )
// 	{
// 		global $user;
// 		$OrderList 		= array();
// 		$strWhere 		= '';

// 		if ( $strCartIds != '' )
// 		{
// 			$strWhere 	.= " AND uc.`id` IN ({$strCartIds})";
// 		}

// 		$strSQL = "
// 					SELECT
// 						uc.`id`,
// 						uc.`user_id`,
// 						uc.`shop_id`,
// 						uc.`product_id`,
// 						uc.`product_name`,
// 						uc.`product_image`,
// 						uc.`stock_price_old`,
// 						uc.`stock_price`,
// 						uc.`num`,
// 						uc.`type`,
// 						uc.`status`,
// 						uc.`postage_type`,
// 						uc.`weight`,
// 						uc.`sku_link_id`,
// 						uc.`activity_id`,
// 						uc.`activity_name`,
// 						at.`activity_date`,
// 						at.`end_time`,
// 						at.`type`,
// 						ss.`discount_type`,
// 						ss.`discount_context`
// 					FROM
// 						`user_cart` 	as uc
// 					LEFT JOIN
// 						`activity_time` as at
// 					ON
// 						uc.`activity_id`=at.`id`
// 					LEFT JOIN
// 						`special_show` as ss
// 					ON
// 						ss.`activity_id`=at.`id`
// 					WHERE
// 						uc.`user_id`={$user->id}
// 					{$strWhere}
// 					ORDER BY
// 						uc.`id` DESC
// 				";

// 		$objCartList = $this->query( $strSQL );

// 		if ( $objCartList == NULL )
// 		{
// 			return NULL;
// 		}

// 		return $this->getCartInfo( $objCartList );
// 	}
	
	
	public function getUserCartList( $strCartIds='' )
	{
		global $user;
		$OrderList 		= array();
		$strWhere 		= '';
	
		if ( $strCartIds != '' )
		{
			$strWhere 	.= " AND `id` IN ({$strCartIds})";
		}
	
		$strSQL = "
		SELECT
		*
		FROM
		`user_cart`
		WHERE
		`user_id`={$user->id}
 		{$strWhere}
		
		ORDER BY
		`id` DESC
		";
		
		$objCartList = $this->query( $strSQL );
	
		if ( $objCartList == NULL )
		{
			return NULL;
		}
	
		return $this->getCartInfo( $objCartList );
	}
	
	

	/**
	 *	功能：获取购物车列表信息（整合后）
	 */
	private function getCartInfo( $objCartList )
	{
		$ProductModel 	 = D('Product');
		$arrCart 		 = array();
		$AllWeight		 = 0;					// 总产品重量
		$AllWeightNoPost = 0;					// 不包邮的产品重量
		foreach( $objCartList as $CartList )
		{
			$arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['activity_id'] 		= $CartList->activity_id;
			$arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['activity_name'] 		= $CartList->activity_name;
			$arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['type'] 				= $CartList->type;
			$arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['discount_type'] 		= $CartList->discount_type;
			$arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['discount_context'] 	= '';
			if ( $CartList->discount_type != '' )
			{
				$discount_context = json_decode( $CartList->discount_context, true );
				$arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['discount_context'] 	= $discount_context[0];
			}
			$discount_context = json_decode( $CartList->discount_context, true );
			$arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['discount_context'] 	= $discount_context[0];

			$arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['product'][$CartList->id] 	= $CartList;
			$objProductInfo = $ProductModel->getProductInfo( $CartList->product_id, $CartList->sku_link_id, $CartList->activity_id );

			// 判断商品状态
			if ( $objProductInfo->activity_stock <= 0 )
			{
				$arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['product'][$CartList->id]->enable 		= 0;
				$arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['product'][$CartList->id]->activity_tip 	= '该产品已售罄';
			}
			elseif ( $objProductInfo->status == 0 )
			{
				$arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['product'][$CartList->id]->enable 		= 0;
				$arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['product'][$CartList->id]->activity_tip 	= '该产品已下架';
			}
			else
			{
				$arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['product'][$CartList->id]->enable		 	= 1;
				$arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['product'][$CartList->id]->activity_tip 	= '活动进行中';

//				// 判断活动状态
//				if ( $CartList->type == 0 )
//				{
//					$product_activity_date = strtotime( $CartList->activity_date .' '. $CartList->end_time . ':00' );
//					$bActivityDate = (  $product_activity_date - time() ) <= 0 ? FALSE : TRUE;
//				}
//				else
//				{
//					$bActivityDate = strtotime($CartList->end_time) - time()   <= 0 ? FALSE : TRUE;
//				}

				// 判断活动状态
				if ( $objProductInfo->activity_info->type == 0 )
				{
					$product_activity_date = strtotime( $objProductInfo->activity_info->activity_date .' '. $objProductInfo->activity_info->end_time . ':00' );
					$bActivityDate = (  $product_activity_date - time() ) <= 0 ? FALSE : TRUE;
				}
				else
				{
					$bActivityDate = strtotime( $objProductInfo->activity_info->end_time ) - time()   <= 0 ? FALSE : TRUE;
				}

				if ( ! $bActivityDate )
				{
					$arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['product'][$CartList->id]->enable		 	= 0;
					$arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['product'][$CartList->id]->activity_tip 	= '该商品活动已结束';
				}
				else
				{
					$AllWeight += $objProductInfo->weight;
					if( $objProductInfo->postage_type == 0 )
					{
						$AllWeightNoPost  += $objProductInfo->weight;
					}
				}
			}

			if ( $arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['product'][$CartList->id]->sku_link_id )
			{
				$arrCart[$CartList->shop_id]['info'][$CartList->activity_id]['product'][$CartList->id]->sku_info			= $objProductInfo->sku_info;
			}
		}

		return $arrCart;
	}
}
?>