<?php

define('HN1', true);
require_once('./global.php');

/*----------------------------------------------------------------------------------------------------
	-- 判断登录
-----------------------------------------------------------------------------------------------------*/
if ( ! $bLogin )
{
	IS_USER_LOGIN();
}


/*----------------------------------------------------------------------------------------------------
	-- 配置
-----------------------------------------------------------------------------------------------------*/
$act 				= CheckDatas( 'act', '' );
$status 			= intval(CheckDatas( 'sid', 0 ));
$UserCartModel 		= D('UserCart');
$UserCouponModel 	= D('UserCoupon');
$UserAddressModel 	= D('UserAddress');
$UserOrderModel 	= D('UserOrder');
$ProductModel 		= D('Product');
$return_url 		= (!isset($_GET['return_url']) || ($_GET['return_url'] == '')) ? '/index' : $_GET['return_url'];



switch( $act )
{
	/*----------------------------------------------------------------------------------------------------
		-- 提交选取地址返回操作
	-----------------------------------------------------------------------------------------------------*/
	case 'address_add':
//		$_SESSION['order']['addressId']	= CheckDatas('aids', '');
		$address_choose = $_GET['address_choose'];
		$addr = $_COOKIE['orderaddr'];
		$addr = json_decode(urldecode($addr), true);
		$_SESSION['order']['addressId'] = $addr['id'];
		$_SESSION['order']['address'] = $addr;
		unset($_COOKIE['orderaddr'
			]);
		switch($_SESSION['order']['type']){
			case 'free':
				$_url = 'order_free.php?id='.$_SESSION['order']['grouponId'].'&pid='.$_SESSION['order']['productId'];
				break;
			case 'groupon':
				$_url = 'order_groupon.php?id='.$_SESSION['order']['grouponId'].'&pid='.$_SESSION['order']['productId'];
				break;
			case 'join':
				$_url = 'order_join.php?id='.$_SESSION['order']['grouponId'].'&pid='.$_SESSION['order']['productId'].'&aid='.$_SESSION['order']['attendId'];
				break;
			case 'alone':
				$_url = 'order_alone.php?id='.$_SESSION['order']['grouponId'].'&pid='.$_SESSION['order']['productId'];
				break;
			case 'guess':
				$_url = 'order_guess.php?id='.$_SESSION['order']['grouponId'].'&pid='.$_SESSION['order']['productId'];
				break;
			case 'seckill':
				$_url = 'order_seckill.php?id='.$_SESSION['order']['grouponId'].'&pid='.$_SESSION['order']['productId'];
				break;
			case 'raffle01':
				$_url = 'order_raffle01.php?id='.$_SESSION['order']['grouponId'].'&pid='.$_SESSION['order']['productId'];
				break;
			case 'raffle':
				$_url = 'order_raffle.php?id='.$_SESSION['order']['grouponId'].'&pid='.$_SESSION['order']['productId'];
				break;
			case 'pdk':
				$_url = 'order_pdk.php?id='.$_SESSION['order']['grouponId'].'&pid='.$_SESSION['order']['productId'];
				break;
		}
		redirect($_url.'&address_choose='.$address_choose);
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 提交选取优惠券返回操作
	-----------------------------------------------------------------------------------------------------*/
	case 'coupon_add':
		$_SESSION['cart_info']['coupon_id']		= 	CheckDatas( 'cid', '' );
		redirect( '/orders?act=add' );
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 确认订单页面
	-----------------------------------------------------------------------------------------------------*/
	case 'add':
		$strCartID 		= isset($_SESSION['cart_info']['cart_id'])    ? $_SESSION['cart_info']['cart_id']    : '';		// 购物车ID
		$addressID		= isset($_SESSION['cart_info']['address_id']) ? $_SESSION['cart_info']['address_id'] : '';		// 地址ID
		$couponID		= isset($_SESSION['cart_info']['coupon_id'])  ? $_SESSION['cart_info']['coupon_id'] : '';		// 优惠券ID
		$payType		= $_SESSION['cart_info']['pay_type']	= 2;
		$espress_price 	= 0;																							//运费

		if( empty( $strCartID ) || $strCartID == 0 )
		{
			$log->put( '/orders/' . date('YmdH'), "用户：{$userid}, 订单生成失败，原因:购物车ID为空" );
			redirect("cart.php","非法操作！");
			return;
		}



		// 获取指定购物车ID的列表
		$UserCartList = $UserCartModel->getCartInfoFromCartId( $userid, $strCartID );
	
		// 获取运费
		if( $addressID != '' )
		{
			$UserAddressInfo = $UserAddressModel->getUserAddressInfo( $userid,$addressID );

			if ( $UserAddressInfo != NULL )
			{
				// 如果是偏远地区，则算全部商品的总重
				$espress_price = get_espress_price( $UserAddressInfo->province, $UserCartList['AllWeight'] );
			}
		}



		if( $UserCartList == NULL )
		{
			$log->put( '/orders/' . date('YmdH'), "用户：{$userid}, 订单生成失败，原因:未选中提交商品" );
			redirect("cart.php","非法操作！");
			return;
		}

		// 是否可用钱包
		$isCanUseWallet 		= $UserCartList['isWallet'];

		if( $isCanUseWallet )
		{
			$UserWalletModel 		= M('user_wallet');
			$objUserWalletInfo 		= $UserWalletModel->get( array( 'user_id'=>$userid ) );
		}


		// 获取选定商品列表
		$UserCartProductList 	= $UserCartList['list'];

		// 订单总价格
		$AllPrice				= $UserCartList['AllPrice'];

		// 获取可用优惠券的列表
		if ( $couponID != '' )
		{
			$UserCouponInfo = $UserCouponModel->getCouponInfo( $couponID );

			$CouponPriceTip = '减免 ' . $UserCouponInfo->coupon_info->m . ' 元';

			if ( $AllPrice >= $UserCouponInfo->coupon_info->om  )
			{
				$AllPrice = $AllPrice - $UserCouponInfo->coupon_info->m;
			}
		}
		else
		{
			$CouponPriceTip = '';
		}

		//计入商品总价
		$fOrderAllPrice = $_SESSION['cart_info']['all_price'] = $AllPrice;

		// 获取用户地址
		if ( $addressID == NULL )
		{
			// 如果没有选择用户地址，则选取默认的地址
			$UserAddressInfo = $UserAddressModel->getUserAddressOne( $userid );
			if ( $UserAddressInfo != NULL )
			{
				$_SESSION['cart_info']['address_id'] = $UserAddressInfo->id;
			}
		}
		else
		{
			$UserAddressInfo = $UserAddressModel->getUserAddressInfo( $userid,$addressID );
		}

		include_once( 'tpl/orders_confirm_web.php' );
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 确认订单操作
		-- 1、判断付款方式
		-- 2、判断购物车ID
		-- 3、判断购物车商品信息是否都有效
		-- 4、判断地址ID
		-- 5、判断地址信息
		-- 6、判断活动是否正在进行
		-- 7、判断是否达到了活动优惠的条件
		-- 8、判断是否使用优惠券
	-----------------------------------------------------------------------------------------------------*/
	case 'add_save':
		$strCartID 			= isset($_SESSION['cart_info']['cart_id']) 		? $_SESSION['cart_info']['cart_id'] 	: '';
		$nPayMethod 		= isset($_SESSION['cart_info']['pay_type']) 	? intval($_SESSION['cart_info']['pay_type']) 	: '';
		$nAddressID 		= isset($_SESSION['cart_info']['address_id']) 	? intval($_SESSION['cart_info']['address_id']) 	: '';
		$nCouponID 			= isset($_SESSION['cart_info']['coupon_id']) 	? intval($_SESSION['cart_info']['coupon_id']) 	: '';
		$bIsWallet 			= isset($_SESSION['cart_info']['is_wallet']) 	? intval($_SESSION['cart_info']['is_wallet']) 	: '';
		$SysLoginModel 		= M('sys_login');
		$SpecialModel 		= D('Special');
		$SysAreaModel 		= D('SysArea');
		$message			= CheckDatas( 'message', '' );

		$arrAllOrder		= 	array();		// 获取全部订单信息
	
		$fAllOrderPrice 	=	0;				// 获取全部订单的总金额
		$fMaxOrderPrice		= 	0;				// 获取全部订单中订单的最高额
		$nMaxOrderPriceID 	=	0;				// 获取全部订单中总金额最高的订单ID

//
//		$strCartID  = '28182';
//		$nAddressID = 68;
//		$nPayMethod = 1;
//		$nCouponID  = '145033619247027';


		do
		{
			
			if( empty( $nPayMethod ) || $nPayMethod == 0 )
			{
				// get_json_data_public( -1, '您的付款方式为空！' );
				$log->put( '/orders/' . date('YmdH'), "用户：{$userid}, 订单生成失败，原因:您的付款方式为空!" );
				break;
			}

			if( empty( $strCartID ) || $strCartID == 0 )
			{
				// echo get_json_data_public( -1, '您的商品信息为空' );
				$log->put( '/orders/' . date('YmdH'), "用户：{$userid}, 订单生成失败，原因:您的商品信息为空!" );
				break;
			}

	
			// 获取指定购物车ID的列表
			$UserCartList = $UserCartModel->getCartInfoFromCartId( $userid, $strCartID );
			
			if( $UserCartList['list'] == NULL )
			{
				//echo get_json_data_public( -1, '您的商品信息有误' );
				$log->put( '/orders/' . date('YmdH'), "用户：{$userid}, 订单生成失败，原因:您的商品信息有误!" );
				break;
			}
		
			// 获取选定商品列表
			$UserProductCartList 	 = $UserCartList['list'];
			 
			// 获取用户地址
			if( empty( $nAddressID ) || $nAddressID == 0 )
			{
				//echo get_json_data_public( -1, '您的地址信息为空' );
				$log->put( '/orders/' . date('YmdH'), "用户：{$userid}, 订单生成失败，原因:您的地址信息为空!" );
				break;
			}
			
			// 获取指定的用户地址信息
			$UserAddressInfo = $UserAddressModel->getUserAddressInfo( $userid,$nAddressID );
			if( $UserAddressInfo == NULL )
			{
				// echo get_json_data_public( -1, '您的地址信息为有误' );
				$log->put( '/orders/' . date('YmdH'), "用户：{$userid}, 订单生成失败，原因:您的地址信息为有误!" );
				break;
			}
		
			// 获取完整地址信息
			$objUserAddressInfo = $UserAddressInfo->desc;

			// 判断传入的活动是否有正在进行中
			$bEnableActivity 	= FALSE;
			
			/*------------------- S_开始订单处理  ---------------------------------------------------------------------*/
			foreach( $UserProductCartList as $key=>$ProductList )
			{
			
			
				foreach($ProductList['info'] as $ProductInfo )
				{
					
					/*-----------------------------------  根据活动ID获取活动对应的信息  ------------------------------------*/
// 					$SpecialShowInfo = $SpecialModel->getSpecialInfo( '',$ActivityInfo['activity_id'] );
// 					var_dump($SpecialShowInfo);
					/*-----------------------------------   判断活动 状态/是否过期     --------------------------------------*/
// 					if( $SpecialShowInfo == NULL )
// 					{
						
// 						//echo get_json_data_public( -1, "找不到指定的专场！" );
// 						$log->put( '/orders/' . date('YmdH'), "用户：{$userid}, 订单生成失败，原因:找不到指定的专场!" );
// 						break;
// 					}

					
// 					if( $SpecialShowInfo->date_info['type'] == 0 )
// 					{
// 						//echo get_json_data_public( -1, "活动【{$ActivityInfo['activity_id']}】 $SpecialShowInfo->date_info['tip']！" );
// 						$log->put( '/orders/' . date('YmdH'), "用户：{$userid}, 订单生成失败，原因:活动【{$ActivityInfo['activity_id']}】 $SpecialShowInfo->date_info['tip']！" );
// 						break;
// 					}

					$all_price 		 = 0;
					$espress_price 	 = 0;
					$all_weight 	 = 0;
					$ProductNum		 = 0;

					
					foreach( $ProductInfo['product'] as $Product )
					{
						
						
						$type = array_search( $Product->type , $getProductActivityType);
						$objProductInfo = $ProductModel->getProductInfo( $Product->product_id, $Product->sku_link_id, $Product->activity_id, $type );
		              
// 						if ( $objProductInfo->enable == 0 )
// 						{
// 							//echo get_json_data_public( -1, "商品【 {$objProductInfo->product_name} 】失效，原因：{$objProductInfo->msg_tip}！" );
// 							$log->put( '/orders/' . date('YmdH'), "用户：{$userid}, 订单生成失败，原因:商品【 {$objProductInfo->product_name} 】失效，原因：{$objProductInfo->msg_tip}！" );
// 							break;
// 						}
					
						if (  $objProductInfo->stock_num  < $Product->num  )
						{ 
							//echo get_json_data_public( -1, "商品【 {$objProductInfo->product_name} 】的库存不足！" );
							$log->put( '/orders/' . date('YmdH'), "用户：{$userid}, 订单生成失败，原因:商品【 {$objProductInfo->product_name} 】的库存不足！" );
							break;
						}
					
						
						$bEnableActivity = TRUE;
						$all_price 	+= $Product->stock_price * $Product->num;
						$ProductNum += $Product->num;

					
					
						if ( ($UserAddressInfo->province == 6 || $UserAddressInfo->province == 27 || $UserAddressInfo->province == 29 || $UserAddressInfo->province == 30 || $UserAddressInfo->province == 31 || $UserAddressInfo->province == 32) || $ProductInfo->postage_type == 0 )
						{
							// 如果是偏远地区或商品不包邮则计算重量
							$all_weight += $Product->weight;
						}
					}
					
					/*--------------------------------------   判断活动是否过期     ---------------------------------------*/
					if( $bEnableActivity )
					{
						if ( $SpecialShowInfo->discount_type == 1 )
						{
							//如果是满减
							if (  $all_price >= $SpecialShowInfo->discount_info['om'] );
							{
								$all_price = $all_price -  $SpecialShowInfo->discount_info['m'];
							}
						}

						if ( $SpecialShowInfo->discount_type == 2 )
						{
							//如果是满折
							if (  $ProductNum >= $SpecialShowInfo->discount_info['om'] );
							{
								$all_price = $all_price * ($SpecialShowInfo->discount_info['m']/10);
							}
						}

						if ( $all_weight > 0 )
						{
							// 运费
							$espress_price = get_espress_price( $UserAddressInfo->province, $all_weight );
						}


						$OutTradeNo 			= set_out_trade_no();			// 获取对外订单号

						$arrParam = array(
							'user_id' 			=> $userid,
							'all_price' 		=> $all_price,
							'fact_price' 		=> $all_price + $espress_price,
							'out_trade_no' 		=> $OutTradeNo,
							'espress_price' 	=> $espress_price,
							'order_status' 		=> 1,
							'province' 			=> $UserAddressInfo->province,
							'city' 				=> $UserAddressInfo->city,
							'area'	 			=> $UserAddressInfo->area,
							'user_address_id' 	=> $nAddressID,
							'order_no' 			=> microtime_float() . rand(100000, 999999),
							'consignee' 		=> $UserAddressInfo->consignee,
							'consignee_phone' 	=> $UserAddressInfo->consignee_phone,
							'consignee_address' => $objUserAddressInfo,
							'consignee_type' 	=> 1,
							'buyer_message' 	=> $message[$aid],
// 							'activity_id' 		=> $ActivityInfo['activity_id'],
// 							'activity_name' 	=> $ActivityInfo['activity_name'],
							'create_by' 		=> $userid,
							'create_date' 		=> date('Y-m-d H:i'),
							'update_by' 		=> $userid,
							'update_date' 		=> date('Y-m-d H:i'),
							'channel' 			=> 2
						);

						
// 						if ( $SpecialShowInfo->user_id != NULL )
// 						{
// 							$arrParam['suser_id'] = $SpecialShowInfo->user_id;
// 						}

						/*-----------------------------------------   添加订单     ------------------------------------------*/

						$nOrderID = $UserOrderModel->addUserOrderOperation( $arrParam, $ProductInfo['product'], $user );
			
						if ( $nOrderID === FALSE )
						{
							break;
						}

						// 判断全部订单的总信息
						$arrAllOrder[]		  = $nOrderID;
						$fAllOrderPrice 	 += $all_price;

						if ( $fMaxOrderPrice < $all_price )
						{
							$fMaxOrderPrice   = $all_price;
							$nMaxOrderPriceID = $nOrderID;
						}
					}
				}
			}

			/*-----------------------------------  如果活动都为钱包活动  ------------------------------------*/
			if ( $UserCartList['isWallet'] === TRUE )
			{
				$fUseWallet 		= CheckDatas( 'use_wallet', FALSE );

				// 如果有选中使用钱包支付
				if ( $fUseWallet )
				{
					do
					{
						$UserWalletModel 		= M('user_wallet');
						$objUserWalletInfo 		= $UserWalletModel->get( array('user_id'=>$userid), array('balance') );
						$fUserWalletBalance		= $objUserWalletInfo->balance;					// 用户可用的钱包金额

						// 1、获取需要支付的钱包金额
						if ( $fUserWalletBalance > $fAllOrderPrice )
						{
							$WalletBalance 			= $fAllOrderPrice;							// 用户需使用的钱包金额数
							$NerUserWalletBalance 	= $fUserWalletBalance - $fAllOrderPrice;	// 用户最新的钱包金额数
						}
						else
						{
							$WalletBalance 			= $fUserWalletBalance;						// 用户需使用的钱包金额数
							$NerUserWalletBalance 	= 0;										// 用户最新的钱包金额数
						}

						$UserWalletModel->startTrans();

						// 2、修改user_order中的wallet_price信息
						$rs = $UserWalletModel->modify( array('wallet_price'=>$WalletBalance), array('id' => $nOrderID),'user_order');
						if ( $rs < 0 )
						{
							$UserWalletModel->rollback();
							break;
						}

						// 3、更新钱包金额
						$rs = $UserWalletModel->modify( array('balance'=>$NerUserWalletBalance), array('user_id' => $userid),'user_wallet');
						if ( $rs < 0 )
						{
							$UserWalletModel->rollback();
							break;
						}

						// 4、计入钱包记录
						$arrParam = array(
							'user_id' 		=> $userid,
							'cur_bal'		=> $fUserWalletBalance,
							'type'			=> 1,
							'trade_amt'		=> $WalletBalance,
							'source'		=> $userid,
							'order_id'		=> $OutTradeNo,
							'create_by'		=> $userid,
							'create_date' 	=> date( 'Y-m-d H:i:s' ),
							'remarks'		=> '支付了订单'
						);
						$rs = $UserWalletModel->add( $arrParam, 'user_wallet_log');
						if ( $rs < 0 )
						{
							$UserWalletModel->rollback();
							break;
						}

						$UserWalletModel->commit();
					}while(0);
				}
			}

			/*-----------------------------------  如果使用了优惠券，则进行优惠券验证  ------------------------------------*/
			if ( $nCouponID != '' )
			{
				// 获取可用的优惠券列表
				$UserCouponModel	= D('UserCoupon');
				$objUserCouponList  = $UserCouponModel->getUserCouponList( $userid, TRUE );

				/*-----------  如果优惠券有效则进行优惠券记录  ------------------------------------*/
				if ( isset($objUserCouponList[$nCouponID]) )
				{
					do
					{
						// 可用的优惠券信息
						$useCouponInfo = $objUserCouponList[$nCouponID];

						if ( $fMaxOrderPrice >= $useCouponInfo->coupon_info->m )
						{
							$UserCouponModel->startTrans();

							// 1、修改user_coupon的状态
							$rs = $UserCouponModel->modify( array('used'=>1,'use_time'=>time()), array('coupon_no' => $nCouponID));
							if ( $rs < 0 )
							{
								$UserCouponModel->rollback();
								break;
							}

							// 2、将相关订单与优惠券添加到coupon_order中
							foreach( $arrAllOrder as $nOrderID )
							{
								$arrParam = array( 'order_id'=>$nOrderID, 'coupon_no'=>$nCouponID, 'rel_time'=>time() );

								if ( $nOrderID == $nMaxOrderPriceID )
								{
									$arrParam['used_price'] = $useCouponInfo->coupon_info->m;
									$arrParam['status'] 	= 1;
								}

								$rs = $UserCouponModel->add( $arrParam, 'coupon_order' );
								if ( $rs < 0 )
								{
									$UserCouponModel->rollback();
									break;
								}
							}

							// 3、更新最高价订单的相关信息
							$arrWhere 		= array( 'id'=>$nMaxOrderPriceID );
							$MaxOrderInfo 	= $UserCouponModel->get( $arrWhere, 'fact_price', 'OBJECT', 'user_order');
							$fact_price		= $MaxOrderInfo->fact_price-$useCouponInfo->coupon_info->m;
							$arrParam = array( 'discount_type'=>$useCouponInfo->type, 'discount_context'=>$useCouponInfo->name, 'fact_price'=>$fact_price, 'discount_price'=>$useCouponInfo->coupon_info->m );
							$rs = $UserCouponModel->modify( $arrParam, $arrWhere, 'user_order');
							if ( $rs < 0 )
							{
								$UserCouponModel->rollback();
								break;
							}

							$UserCouponModel->commit();

						}
					}while(0);
				}
			}

			/*-------------  订单提交成功，临时数据为空  -------------------------*/
			$_SESSION['cart_info'] = NULL;

			if ( count($arrAllOrder) == 0 )					// 判断是否有有效订单
			{
				
				$log->put( '/orders/' . date('YmdH'), "用户：{$userid}, 订单生成失败，原因:无有效的订单！" );
				
				redirect( '/orders','您提交的订单信息无效！' );
			}

			/*-------------  通过得到的订单号来获取对外订单号，并触发提交付款操作  -------------------------*/
			$strOrderID	 	= implode( ',', $arrAllOrder );

			//接收订单号返回对外订单号
			$outTradeNo 	= $UserOrderModel->getOutTradeNoFromOrderID( $nOrderID, $userid);

			$rs = json_decode($outTradeNo, TRUE);

			if ( $rs['code'] > 0 )
			{
				$log->put( '/orders/' . date('YmdH'), "用户：{$userid}, 订单生成成功，进入微信支付阶段！" );
				redirect( '/wxpay/wxpay_call.php?id=' . $rs['data'] );
			}

			$log->put( '/orders/' . date('YmdH'), "用户：{$userid}, 订单生成失败，原因:更新对外订单号时有误！" );
			
			redirect( '/orders','付款过程有误，请到订单列表中重试！' );

		}while(0);

	break;

	/*----------------------------------------------------------------------------------------------------
		-- 取消订单操作
	-----------------------------------------------------------------------------------------------------*/
		case 'cancel':
			$nOrderID = intval(CheckDatas( 'oid', '' ));

			if ( $nOrderID < 1 )
			{
				echo get_json_data_public( -1, '订单ID不正确' );
				return;
			}

			$rs = $UserOrderModel->modify( array( 'is_cancel_order'=>1 ) , array( 'id'=>$nOrderID, 'user_id'=>$userid ));

			if ( $rs < 0 )
			{
				echo get_json_data_public( -1, '取消订单有误' );
				return;
			}

			echo get_json_data_public( 1, '取消订单成功' );
		break;

	/*----------------------------------------------------------------------------------------------------
		-- 关闭订单操作
	-----------------------------------------------------------------------------------------------------*/
	case 'del':

		$nOrderID = intval(CheckDatas( 'oid', '' ));

		if ( $nOrderID < 1 )
		{
			echo get_json_data_public( -1, '订单ID不正确' );
			return;
		}

		$rs = $UserOrderModel->modify( array( 'is_delete_order'=>1 ) , array( 'id'=>$nOrderID, 'user_id'=>$userid ));

		if ( $rs < 0 )
		{
			echo get_json_data_public( -1, '删除订单有误' );
			return;
		}

		echo get_json_data_public( 1, '订单删除成功' );

	break;

	/*----------------------------------------------------------------------------------------------------
		-- 付款成功后显示页面
	-----------------------------------------------------------------------------------------------------*/
	case 'success':
		//非支付后进入的，跳转到订单列表，防止点击“返回”按钮
		if(!isset($_SESSION['order_pay_flag']) || !$_SESSION['order_pay_flag']){
			redirect('/orders');
			exit();
		}else{
			unset($_SESSION['order_pay_flag']);
		}

		$HistoryModel  = M('history');
		$objhistory  =   $HistoryModel->query("select h.user_id as uid,h.type as type,h.business_id as business_id,p.product_name as pname, p.image as image,ag.active_price as active_price,ag.sell_price as sell_price from  history as h  left join product as p on p.id = h.business_id left join activity_goods as ag on p.id = ag.product_id where 1=1 and h.type=1 and h.user_id = '".$userid."' and ag.status =1 order by h.create_date desc limit 0,4",false,false);
		
		include "tpl/success_pay_web.php";
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 提交付款操作
	-----------------------------------------------------------------------------------------------------*/
	case 'paid':
		$nOrderID = intval(CheckDatas( 'oid', '' ));

		//接收订单号返回对外订单号
		$outTradeNo 	= $UserOrderModel->getOutTradeNoFromOrderID( $nOrderID, $userid );
		$rs = json_decode($outTradeNo, TRUE);

		if ( $rs['code'] > 0 )
		{
			redirect( '/wxpay/wxpay_call.php?id=' . $rs['data'] );
		}

		redirect( '/orders',$rs['msg'] );
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 订单评论列表
	-----------------------------------------------------------------------------------------------------*/
	case "comment":
		$nOrderID = intval(CheckDatas( 'oid', '' ));

		if ( (int)$nOrderID == 0 )
		{
			redirect( '/orders','非法操作！' );
		}

		$rs = $UserOrderModel->getOrderList( 4, $nOrderID );

		if ( $rs == NULL )
		{
			redirect( '/orders','找不到该订单' );
		}

		if ( $rs[$nOrderID]['order_status'] != 4 )
		{
			redirect( '/orders','您的订单状态不可评论！' );
		}

		if ( $rs[$nOrderID]['available_productnum'] == 0 )
		{
			redirect( '/orders','该订单处于退货退款阶段无法参与评价' );
		}

		$orderDetailList = $rs[$nOrderID]['info'];

		include "tpl/order_comment_web.php";
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 订单评论添加操作
	-----------------------------------------------------------------------------------------------------*/
	case "comment_add":
		$nOrderID 			= intval(CheckDatas( 'oid', '' ));

		if ( (int)$nOrderID == 0 )
		{
			redirect( '/orders','非法操作！' );
		}

		$arrProductScore 	= CheckDatas( 'ProductScore', '' );
		$arrComment 		= CheckDatas( 'comment', '' );
		$nServiceScore 		= intval(CheckDatas( 'ServiceScore', '' ));
		$nEspeedScore 		= intval(CheckDatas( 'EspeedScore', '' ));
		$bSuccess			= TRUE;

		// 用户订单详情
		$rs = $UserOrderModel->getOrderList( 4, $nOrderID );
		if ( $rs == NULL )
		{
			redirect( '/orders','找不到该订单' );
		}

		if ( $rs[$nOrderID]['order_status'] != 4 )
		{
			redirect( '/orders','您的订单状态不可评论！' );
		}

		$OrderInfo = $rs[$nOrderID];

		do
		{
			// 1、添加user_comment记录
			$UserOrderModel->startTrans();
			foreach( $OrderInfo['info'] as $ProductID=>$ProductInfo )
			{
				$nProductScore = $arrProductScore[$ProductID];
				if ( $nProductScore <=1 )
				{
					$nScoure = 1;
				}
				else if ( $nProductScore >=2 and $nProductScore <=3 )
				{
					$nScoure = 2;
				}
				else
				{
					$nScoure = 3;
				}

				$arrParam = array(
					'order_id'		=>	$OrderInfo['id'],
					'order_no'		=>  $OrderInfo['order_no'],
					'create_by'		=>	$user->id,
					'create_date'	=>	date('Y-m-d H:i:s'),
					'product_id'	=>	$ProductID,
					'score'			=>	$nScoure,
					'user_id'		=>	$user->id,
					'user_name'		=>	$user->name,
					'comment'		=>	$arrComment[$ProductID],
					'score_product'	=>	$arrProductScore[$ProductID],
					'score_service'	=>	$nServiceScore,
					'score_sspeed'	=>	$nEspeedScore,
					'status'		=>	1,
					'sku_link_id'	=>  $OrderInfo['info'][$ProductID]['sku_link_id']
				);

				$rs = $UserOrderModel->addOrderComment( $arrParam );
				if ( $rs === FALSE )
				{
					$bSuccess = FALSE;
					$UserOrderModel->rollback();
					break;
				}
			}

			// 2、修改订单状态
			$arrWhere = array( 'id'=>$OrderInfo['id'], 'order_status'=>4, 'user_id'=>$userid );
			$arrParam = array( 'order_status'=>5  );
			$rs 	  = $UserOrderModel->modify( $arrParam, $arrWhere);
			if ( $rs === FALSE )
			{
				$bSuccess = FALSE;
				$UserOrderModel->rollback();
				break;
			}

			$UserOrderModel->commit();

		}while(0);

		$msg = ( $bSuccess ) ? '评论成功！' : '评论失败！';
		redirect( '/orders', $msg );

	break;


	/*----------------------------------------------------------------------------------------------------
		-- 退货管理
	-----------------------------------------------------------------------------------------------------*/
	case 'return':
		$UserOrderRefundModel = D('UserOrderRefund');
		$ordersList 	= $UserOrderRefundModel->getUserOrderRefundList( $userid );
		include "tpl/orders_refund_web.php";
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 订单详情
	-----------------------------------------------------------------------------------------------------*/
	case 'info':
		$nOrderID 		= intval(CheckDatas( 'oid', '' ));

		if ( $nOrderID == NULL )
		{
			redirect( '/orders', '非法操作！' );
		}

		// 获取订单信息
		$objOrderInfo	 = $UserOrderModel->getOrderList( '', $nOrderID );

		if ( $objOrderInfo == NULL || !isset($objOrderInfo[$nOrderID]) )
		{
			redirect( '/orders', '非法操作！' );
		}
		$objOrderInfo    = $objOrderInfo[$nOrderID];

		// 获取地址信息
		$UserAddressModel = D('UserAddress');
		$UserAddressInfo = $UserAddressModel->getUserAddressInfo( $userid,$objOrderInfo['user_address_id']);

		// 获取订单优惠券信息
		$OrderCouponInfo = $UserOrderModel->get( array('order_id'=>$objOrderInfo['id']), array('coupon_no','used_price','status'), 'OBJECT', 'coupon_order' );

		if ( $OrderCouponInfo == NULL || $OrderCouponInfo->status == 0 )
		{
			$useOrderCoupon = FALSE;
		}
		else
		{
			$useOrderCoupon	= TRUE;
			$OrderCouponNo 	= $OrderCouponInfo->coupon_no;
		}

		include "tpl/orders_info_web.php";
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 快递查询
	-----------------------------------------------------------------------------------------------------*/
	case 'express':
		require_once LIB_ROOT . 'logistic/express.php';
		$nOrderID 		= intval(CheckDatas( 'oid', '' ));
		$url 			= CheckDatas( 'return', '' );

		// 获取订单对应的物流信息
		$UserOrderShipModel = M('user_order_ship');
		$ship_info 			= $UserOrderShipModel->get( array( 'order_id'=>$nOrderID, 'user_id'=>$userid  ) );

		if ( $ship_info == NULL )
		{
			redirect( $url, '该订单的物流信息不存在！' );
		}
		$express_type		= $ship_info->logistics_name;						// 快递名称
		$express_number		= $ship_info->logistics_no; 						// 快递单号

		// 获取订单对应的商品图片
		$UserOrderDetailModel 	= M('user_order_detail');
		$ProductInfo		  	= $UserOrderDetailModel->get( array('order_id'=>$nOrderID),'product_image');
		$product_image 			= $ProductInfo->product_image;


		// 获取快递信息
		$express = Express::LogisticsFactory( 'kuaidi' );			//设置物流接口
		$express->setCodeId('481ea0389df9f6b101f7fd8af272fbef');	//设置物流身份授权id
		header('Content-type: text/html; charset=utf-8');
		$result = $express->getExpress($express_type,$express_number);

		if( $result['success'] === FALSE )
		{
			redirect( $url, $result['reason'] );
		}

		$ship_status_info 	= $result['data'];		// 获取快递状态
		$ship_status		= $express->getStatusDesc( $result['status'] );

		include "tpl/check_express_web.php";
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 确认收货
	-----------------------------------------------------------------------------------------------------*/
	case 'confirm':
		$nOrderID = intval(CheckDatas( 'oid', '' ));

		if ( $nOrderID < 1 )
		{
			echo get_json_data_public( -1, '订单ID不正确' );
			return;
		}


		$arrParam = array(
			'update_date'	=> date('Y-m-d H:i:s'),
			'order_status'	=> 4
		);

		$arrWhere = array(
			'id'			=> $nOrderID,
			'user_id'		=> $userid,
			'order_status'		=> 3
		);

		$rs = $UserOrderModel->modify( $arrParam, $arrWhere );

		if ( $rs < 0 )
		{
			echo get_json_data_public( -1, '确认订单有误' );
			return;
		}

		echo get_json_data_public( 1, '确认订单成功' );

	break;


	/*----------------------------------------------------------------------------------------------------
		-- 退货页面
	-----------------------------------------------------------------------------------------------------*/
	case "refund":
		$UserOrderDetailModel = M('user_order_detail');
		$nOrderDetailID = intval(CheckDatas( 'odid', '' ));

		$ProductInfo = $UserOrderDetailModel->get( array( 'id'=>$nOrderDetailID, 'user_id'=>$userid  ) );

		if ( $ProductInfo == NULL )
		{
			redirect( '/orders.php' . $nOrderDetailID, '非法操作！' );
			return;
		}

		if ( $ProductInfo->re_status > 0 )
		{
			redirect( '/orders.php', '售后申请中，请勿重复操作！' );
			return;
		}

		include "tpl/returnapply_web.php";
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 退货申请页面
		流程：
		1、通过user_order_detail.id 获取退货的商品信息
		2、根据order_id 到 coupon_order 查找是否有 相应的信息且use_price有值
		3、如果有值，则通过购买总价，来获得总退款额  （优惠券金额*商品单价*退货数量）/ 总金额
	-----------------------------------------------------------------------------------------------------*/
	case "refund_save":
		$UserOrderDetailModel = M('user_order_detail');
		$nOrderDetailID = intval(CheckDatas( 'odid', '' ));

		if ( $nOrderDetailID < 1 )
		{
			redirect( '/orders.php?act=refund&odid=' . $nOrderDetailID, '订单ID不正确' );
			return;
		}

		$ProductInfo = $UserOrderDetailModel->get( array( 'id'=>$nOrderDetailID, 'user_id'=>$userid, 'status'=>1, 're_status'=>0  ) );

		if ( $ProductInfo == NULL )
		{
			redirect( '/orders.php' . $nOrderDetailID, '非法操作！' );
			return;
		}

		$nRefundType 			= intval(CheckDatas( 'refund_type', '' ));
		$nNum 					= intval(CheckDatas( 'num', 0 ));
		$Reason 				= CheckDatas( 'reason', '' );
		$UserOrderRefundModel 	= M('user_order_refund');
		$CouponOrderModel 		= M('coupon_order');
		$CouponPrice 			= 0;					// 订单优惠券中的金额
		$coupon_price  			= 0;					// 优惠券计算后的优惠金额

		if ( $nNum == 0 || $nRefundType == '' )
		{
			redirect( '/orders.php?act=refund&odid=' . $nOrderDetailID, '参入参数有误！' );
		}

		if ( $nNum > $ProductInfo->num )
		{
			$nNum = $ProductInfo->num;
		}

		$CouponInfo = $CouponOrderModel->get( array( 'order_id'=>$ProductInfo->order_id  ) );

		if ( $CouponInfo != NULL && $CouponInfo->used_price > 0 )
		{
			$CouponPrice = $CouponInfo->used_price;
		}

		if ( $CouponPrice > 0 )
		{
			$coupon_price = ($CouponPrice * $ProductInfo->stock_price * $nNum) /  ( $ProductInfo->stock_price * $ProductInfo->num );
		}

		do
		{
			$UserOrderRefundModel->startTrans();
			$arrParam = array(
				'refund_num'	=> $nNum,
				'detail_id'		=> $nOrderDetailID,
				'status'		=> 1,
				'order_id' 		=> $ProductInfo->order_id,
				'user_id'		=> $ProductInfo->user_id,
				'shop_id'		=> $ProductInfo->shop_id,
				'product_id'	=> $ProductInfo->product_id,
				'product_name'	=> $ProductInfo->product_name,
				'type'			=> 1,
				'stock_price'	=> $ProductInfo->stock_price,
				'refund_Type'	=> $nRefundType,
				'refund_reason'	=> $Reason,
				'create_date'	=> date('Y-m-d H:i:s'),
				'coupon_price'	=> $coupon_price
			);

			if ( $ProductInfo->sku_link_id != NULL )
			{
				$arrParam['sku_link_id']	= $ProductInfo->sku_link_id;
			}

			// 添加 user_order_refund表
			$rs = $UserOrderRefundModel->add( $arrParam );
			if ( $rs <= 0 )
			{
				$UserOrderRefundModel->rollback();
				break;
			}

			// 更新 user_order_detail表
			$arrParam = array( 'status'=>0, 're_status'=>1 );
			$arrWhere = array( 'id'=>$nOrderDetailID, 'user_id'=>$userid );
			$rs = $UserOrderRefundModel->modify( $arrParam, $arrWhere, 'user_order_detail' );
			if ( $rs <= 0 )
			{
				$UserOrderRefundModel->rollback();
				break;
			}

			$UserOrderRefundModel->commit();

		}while(0);

		redirect("orders","申请成功");

	break;


	/*----------------------------------------------------------------------------------------------------
		-- 退货详情
	-----------------------------------------------------------------------------------------------------*/
	case "refund_info":
		$UserOrderRefundModel = D('UserOrderRefund');
		$nID = intval(CheckDatas( 'id', '' ));

		if ( $nID == '' )
		{
			redirect( '/orders?act=return' , '非法操作！' );
			return;
		}

		$UserOrderRefundInfo = $UserOrderRefundModel->getUserOrderRefundInfo( $userid, $nID );

		if ( $UserOrderRefundInfo == NULL )
		{
			redirect( '/orders?act=return', '非法操作！' );
			return;
		}

		switch( $UserOrderRefundInfo->status  )
		{
			case 1:
				$title = "申请审核中";
			break;

			case 2:
				$title = "提交退货";
			break;

			case 3:
				$title = "退货中";
			break;

			case 4:
				$title = "退款成功";
			break;

			case 5:
				$title = "退款失败";
			break;

			case 6:
				$title = "申请失败";
			break;
		}

		$HistoryModel = D('History');
		$ProductList = $HistoryModel->getHistoryList( $userid, 4 );



		$ProductList = $HistoryModel->getHistoryList( $userid, 4 );

		$arrProductList = array();

		if ( is_array( $ProductList ) )
		{
			foreach( $ProductList as $key=>$product )
			{
				$ProductInfo = $ProductModel->getProductInfo( $product->business_id, '', $product->activity_id );

				if( $ProductInfo != NULL )
				{
					$arrProductList[$key]['product_id'] 			= $ProductInfo->id;
					$arrProductList[$key]['product_name'] 			= $ProductInfo->product_name;
					$arrProductList[$key]['image'] 					= $ProductInfo->image;
					$arrProductList[$key]['distribution_price'] 	= $ProductInfo->active_price;
					$arrProductList[$key]['status'] 				= $ProductInfo->status;
					$arrProductList[$key]['type'] 					= $ProductInfo->activity_type;
					$arrProductList[$key]['enable'] 				= $ProductInfo->enable;
					$arrProductList[$key]['msg_tip'] 				= $ProductInfo->msg_tip;
				}
			}
		}

		include "tpl/returnapply_result_web.php";
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 默认订单列表
	-----------------------------------------------------------------------------------------------------*/
	default:
		$sid 			= intval(CheckDatas( 'sid', '' ));
  		$ordersList = $UserOrderModel->getOrderList($sid);

		include "tpl/orders_web.php";
}



function microtime_float()
{
	list ($usec, $sec) = explode(" ", microtime());
	return ((float) $usec + ((float) $sec * 10000));
}

?>
