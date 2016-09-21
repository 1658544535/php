<?php
define('HN1', true);
require_once('./global.php');


/*----------------------------------------------------------------------------------------------------
	-- 判断用户登录
-----------------------------------------------------------------------------------------------------*/
if ( ! $bLogin )
{
	IS_USER_LOGIN();
}


/*----------------------------------------------------------------------------------------------------
	-- 配置
-----------------------------------------------------------------------------------------------------*/
$act 		  		= CheckDatas( 'act', '' );
$return_url   		= CheckDatas( 'return_url', '/index' );
$ProductModel 		= D('Product');
$UserCartModel 		= D('UserCart');
$ProductSkuLinkModel =M('product_sku_link');

switch($act)
{

	/*----------------------------------------------------------------------------------------------------
		-- 功能：添加购物车

		-- 返回值：
		 *  1、产品ID或userid为空
		 *  2、产品信息为空
		 *  3、产品已在购物车中
		 *  4、添加成功
	-----------------------------------------------------------------------------------------------------*/
	case 'add':
		
		$ActivityTimeModel   = M('activity_time');
		$UserShopModel 		 = M('user_shop');
		$bSuccess 			 = FALSE;
		$code 				 = -1;
		$product_id 		 = intval(CheckDatas( 'id', 0 ));
		
		$skuId 				 = intval(CheckDatas( 'sku_id', 0 ));

// 		$type 				 = intval(CheckDatas( 'type', 3 ));

		do
		{
			if( $product_id == '' )		// 判断输入值是否为空
			{
				$msg  = "没有选中商品";
				break;
			}

			// 获取指定产品的信息
			$obj_product 	= $ProductModel->getProductInfo( $product_id, $skuId, 0, $type );
			$obj_sku        = $ProductSkuLinkModel->get(array('product_id'=>$product_id,'Id'=>$skuId));
			
			if ( $obj_product == null )
			{
				$msg  = '未找到该商品';
				break;
			}

			if ( $obj_product->status == 0 )
			{
				$msg = '该商品已下架';
				break;
			}

			if ( $obj_sku->stock_num < 1 )
			{
				$msg  = '该商品库存不足!';
				break;
			}

// 			$nActivityID = $obj_product->activity_id;
			$hasSku = $ProductModel->getProductHasSku( $obj_product->id );

			if ( $hasSku && $obj_product->sku_link_id == '' )
			{
				$msg  = '请选择商品的属性!';
				break;
			}

			// 查看购物车中是否包含该产品
			$arrWhere = array(
				'user_id'		=> $userid,
				'product_id'	=> $obj_product->id,
// 				'activity_id'	=> $nActivityID
			);

			if ( (int)$obj_product->sku_link_id > 0 )
			{
				$arrWhere['sku_link_id'] = $obj_product->sku_link_id;
			}

			// 查找购物车是否有指定商品
			$objCart = $UserCartModel->get( $arrWhere );
			$obj_sku = $ProductSkuLinkModel->get(array('product_id'=>$objCart->product_id,'Id'=>$skuId));

			
			
			if( $objCart != NULL )
			{
				// 如果存在该商品则更改数量
				$arrParam 	= array(
					'num'		=>	$objCart->num + 1,
				);
				
				$arrWhere = array(
					'id'		=> $objCart->id,
					'user_id'	=> intval($userid)
				);
				if($obj_sku->stock_num < $objCart->num + 1)
				{
					//判断添加的商品数量是否超过库存量
					$msg  = '该商品库存不足!';
					break;
				}
				$rs = $UserCartModel->modify( $arrParam, $arrWhere );
			}
			else
			{
				// 如果不存在该商品则添加记录
				$curTime = time();
				$ActivityInfo  		= $ActivityTimeModel->get( array('id'=>$nActivityID), array('title','type') );
				$shop 				= $UserShopModel->get( array('user_id'=>$obj_product->user_id), array('id','name','images','product_commt','deliver_commt','logistics_commt') );

				if ($obj_product->activity_type == 3 )
				{
					$activity_name = $obj_product->activity_title;
				}
				else
				{
					$activity_name = $obj_product->brand_name . '特惠';
				}

				$arrParam 	= array(
					'user_id' 			=>  intval($userid),
					'shop_id'			=>	intval($shop->id),
					'product_id'		=>  intval($obj_product->id),
					'product_name'		=>	$obj_product->product_name,
					'product_image'		=>	$obj_product->image,
					'stock_price'		=>	$obj_product->distribution_price,
					'num'				=>	1,
					'type'				=>  0,
					'channel'			=>	2,
					'create_by'			=>	intval($userid),
					'create_date'		=>	date('Y-m-d H:i:s', $curTime),
					'update_by'			=>	intval($userid),
					'update_date'		=>	date('Y-m-d H:i:s', $curTime),
					'postage_type'		=>	$obj_product->postage_type,
					'weight'			=>	$obj_product->weight,
					'sku_link_id'		=>	(int)$obj_product->sku_link_id,
					'activity_id' 		=>  0,
					'activity_name'		=>  ''
				);

				
				$rs = $UserCartModel->addCart( $arrParam );

				if ( $rs < 1 )
				{
					$msg  = "添加购物车失败！";
					break;
				}
			}

			$code = 1;
			$msg  = "添加购物车成功！";

		}while(0);

		echo get_json_data_public( $code, $msg );
		exit;
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 功能：删除购物车
	-----------------------------------------------------------------------------------------------------*/
	case 'del':
		$bSuccess 	= FALSE;
		$code 		= -1;
		$cartid 	= CheckDatas( 'id', 0 );

		do
		{
			if ( ( (int) $cartid == 0 ) )
			{
				echo get_json_data_public( -1, '非法操作' );
				break;
			}

			$rs = $UserCartModel->delete( array( 'id'=>$cartid, 'user_id'=>$userid ) );
			echo get_json_data_public( 1, '删除成功！' );

		}while(0);

	break;

	/*----------------------------------------------------------------------------------------------------
		-- 功能：修改购物车数量
	-----------------------------------------------------------------------------------------------------*/
	case 'change_num':
		$cartid 	= CheckDatas( 'cid', 0 );
		$type 		= CheckDatas( 'type', 'plus' );
		$bSuccess 	= TRUE;

		do
		{
			if ( $cartid == '' )
			{
				$bSuccess 	= FALSE;
				$rs = get_json_data_public( -1, '缺少所需参数' );
				break;
			}


			$cart_info = $UserCartModel->get( array( 'id'=>$cartid, 'user_id'=>$userid ) );

			if ( $cart_info == null )
			{
				$bSuccess 	= FALSE;
				$rs = get_json_data_public( -1, '找不到该记录' );
				break;
			}

			$price 		= $cart_info->stock_price;
			$now_num 	= $cart_info->num;

			$sku = null;
			if(!empty($cart_info->sku_link_id))
			{
				$sku = $ProductModel->getSkuById($cart_info->sku_link_id);
				
				$price = $sku->price;
			}

			// 如果是增加的就查看库存
			switch($type)
			{
				case 'set':  //直接设置购买数量
					$buyNum 	= CheckDatas( 'n', 1 );
			
					if(!empty($sku) && ($sku->stock < $buyNum))
					{
						$bSuccess 	= FALSE;
						$rs = get_json_data_public( -1, '该商品的库存不足' );
						break;
					}

					$product_num = $buyNum;
				break;

				case 'plus':

					if(!empty($sku) && ($sku->stock < $cart_info->num + 1))
					{
						$bSuccess 	= FALSE;
						$rs = get_json_data_public( -1, '该商品的库存不足' );
						break;
					}

					$product_num = $now_num + 1;
				break;

				default:
					$product_num = $now_num - 1;
					if ( $product_num < 1 )
					{
						$product_num = 1;
					}
					break;
			}

			if ( $bSuccess )
			{
				// 更新数量
				$UserCartModel->modify( array( 'num'=>$product_num, 'stock_price'=>$price ), array('id'=>$cartid));
				$data = array(
					'num' 	=> $product_num,
					'price' => $price,
				);

				$rs = get_json_data_public( 1, '成功更新该商品的数量', $data );
			}
		}while(0);


		echo $rs;
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 功能：提交购物车品到订单
	-----------------------------------------------------------------------------------------------------*/
	case 'comfire':
		$arrCartIds = CheckDatas( 'cid', '' );
		
		if( empty( $arrCartIds ) )
		{
			$_SESSION['cart_info']['cart_id'] = NULL;
			redirect("cart.php","请选中要提交的商品");
			return;
		}

		$arrCartIds = implode( ',', $arrCartIds);
		// 获取指定购物车ID的列表
 		$UserCartList = $UserCartModel->getCartInfoFromCartId( $userid, $arrCartIds );

		if( $UserCartList == NULL )
		{
			$_SESSION['cart_info']['cart_id'] = NULL;
			redirect("cart.php","请勾选对应记录");
			return;
		}
		$_SESSION['cart_info']['cart_id'] = implode( ",", $UserCartList['cartid'] );

		redirect( "orders?act=add" );
		return;
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 功能：购物车列表
	-----------------------------------------------------------------------------------------------------*/
	default:

		// 获取购物车中的全部商品列表
		$_SESSION['cart_info'] 	= NULL;
		$ShopCartList 				= $UserCartModel->getUserCartList();

		include "tpl/cart_web.php";
}


?>
