<?php
define('HN1', true);
require_once('./global.php');

require_once LOGIC_ROOT.'user_orderBean.php';
require_once LOGIC_ROOT.'sys_loginBean.php';
require_once LOGIC_ROOT.'user_order_detailBean.php';
require_once LOGIC_ROOT.'productBean.php';
require_once LOGIC_ROOT.'user_addressBean.php';
require_once LOGIC_ROOT.'couponBean.php';

$order_id = $_GET['order_id'] == null ? -1 : $_GET['order_id'];


$user_order 		= new user_orderBean();
$sys_login 			= new sys_loginBean();
$user_order_detail 	= new user_order_detailBean();
$user_address		= new user_addressBean();
$objCpn				= new couponBean();
$objCpn->db = $db;

$user = $_SESSION['userinfo'];

if($openid != null)
{
	$userid = $user->id;
}
else
{
	redirect("login?dir=orders");
	return;
}

/*
 * 功能：获取订单的相关信息，并计算
 * 1、遍历订单传入值获取订单的信息
 * 2、根据订单的id 获取该订单相关的商品记录
 * 3、分流订单中有效商品和下架商品
 * 4、记录并累加有效商品的价格、重量和数量
 * 5、根据值获取相关订单的物流费用
 * */

$obj_order = $user_order->get_order_info_all( $db, $order_id, $userid );								// 获取所有的订单信息

$totalFaceAmount = 0;//订单实收总额
foreach($obj_order as $_order){
	$totalFaceAmount += $_order->fact_price;
}

$order_all_price  = 0;		// 订单总价值
$order_all_weight = 0;		// 订单总重量
$order_all_num 	  = 0;		// 订单总数量
$totalAmount = 0;//订单总额

foreach( $obj_order as $okey=>$order )
{
	$orderList[$okey]['info'] 	= (array)$order;														// 获取订单信息
	$productList 	= $user_order_detail->get_order_product_list( $db, $order->id, $userid );			// 获取订单对应的商品信息

	$order_price  	= 0;																				// 订单价值初始化
	$order_weight 	= 0;																				// 商品重量初始化
	$order_num 	  	= 0;																				// 商品数量初始化
	$orderList[$okey]['productList_yes'] = array();
	$orderList[$okey]['productList_no']  = array();
	$user_province  = $user_address->get_user_province($db,$order->user_address_id,$userid);			// 获取用户的地址省份

	if(!empty($productList)) {
		foreach ($productList as $key => $products) {
			if ($products->product_status == 1) {
				$orderList[$okey]['productList_yes'][$key] = (array)$products;
//				$product_price = get_price($products->ladder_price, $products->num);                        // 获取商品单价
				$product_price = $products->stock_price;
				$orderList[$okey]['productList_yes'][$key]['price'] = $product_price;
				$order_price += $product_price * $products->num;                                            // 累计有效订单价值(单价 * 购买数量)
				if ($products->postage_type == 0 && $order->consignee_type == 1)                            // 如果订单不是包邮且不是自提
				{
					$order_weight += $products->weight * $products->num;                                    // 累计有效商品重量(单件 * 购买数量)
				}
				$order_num += $products->num;                                                            // 累计有效商品数量
			} else {
				$orderList[$okey]['productList_no'][$key] = (array)$products;
				$orderList[$okey]['productList_no'][$key]['price'] = get_price($products->ladder_price, $products->num);
			}
		}
	}

	$order_espress_price 						= ( $order_price == 0 || $order->consignee_type == 2 ||  $order_weight == 0 ) ? 0 : get_espress_price($db, $user_province, $order_weight);  			// 计算该订单的运费（如订单总额为0 或 订单重量为0 或 为自提 则运费为0）
	$orderList[$okey]['order_price']  			= $order_price;
	$orderList[$okey]['order_weight']  			= $order_weight;
	$orderList[$okey]['order_num']  			= $order_num;
	$orderList[$okey]['order_espress_price']  	= $order_espress_price;
	$orderList[$okey]['order_amount_price']  	= $order_espress_price + $order_price;					// 订单总价（商品+物流）

	//优惠券
	$coupons = $objCpn->get_by_order($order->id, 1);
	if(!empty($coupons)){
		$_disMoney = 0;
		foreach($coupons as $_cpn){
			$_content = json_decode($_cpn->content);
			if($_content){
				switch($_cpn->type){
					case 1://满m减n
						($totalFaceAmount >= $_content->om) && $_disMoney += $_content->m;
						break;
					case 2://直减金额
						$_disMoney += $_content->m;
						break;
				}
			}
		}
		$orderList[$okey]['order_amount_price'] -= $_disMoney;
		$orderList[$okey]['info']['fact_price'] -= $_disMoney;
		($orderList[$okey]['info']['fact_price'] < 0) && $orderList[$okey]['info']['fact_price'] = 0;
	}
	$orderList[$okey]['fact_amount'] = $orderList[$okey]['info']['fact_price'];
	$totalAmount += $orderList[$okey]['fact_amount'];
	$orderList[$okey]['coupons'] = $coupons;
}

include "tpl/orders_confirm_web.php";
?>
