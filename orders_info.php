<?php
define('HN1', true);
require_once('./global.php');

require_once LOGIC_ROOT.'user_orderBean.php';
require_once LOGIC_ROOT.'sys_loginBean.php';
require_once LOGIC_ROOT.'user_order_detailBean.php';
require_once LOGIC_ROOT.'productBean.php';
require_once APP_INC.'express.php';
require_once LOGIC_ROOT.'user_order_shipBean.php';
require_once LOGIC_ROOT.'user_shopBean.php';
require_once LOGIC_ROOT.'couponBean.php';

$order_id 	= $_GET['order_id'] == null ? -1 : intval($_GET['order_id']);

if ( $order_id == -1 )
{
	redirect("/");
}

$ib 		= new user_orderBean();
$ub 		= new sys_loginBean();
$c2b 		= new user_order_detailBean();
$pb 		= new productBean();
$user 		= $_SESSION['userinfo'];
$usb 		= new user_shopBean();
$objCpn		= new couponBean();
$objCpn->db = $db;
$return_url = (!isset($_GET['return_url']) || ($_GET['return_url'] == '')) ? '/index' : $_GET['return_url'];


if($openid != null)
{
	$userid = $user->id;
}else
{
	redirect("login?dir=orders");
	return;
}

$obj_order 	= $ib->detail($db,$order_id);
$obj_user 	= $ub->detail($db,$userid);
$carts 		= $c2b->get_results_order($db,$order_id);
$obj 		= $ib->get_row_all($db,$order_id);

if ( $obj->order_status >= 3 )
{
	header('Content-type: text/html; charset=utf-8');
	$user_order_ship	= new user_order_shipBean();
	$express 			= new Express();
	$ship_info 			= $user_order_ship->get_info($db, $obj->id, $userid);

	if( $ship_info != null )
	{
		$express_type		= $ExpressType[$ship_info->logistics_name];								// 快递名称
		$express_number		= $ship_info->logistics_no; 											// 快递单号
		$result 			= $express->getorder($ship_info->logistics_name,$express_number);		// 获取快递信息
		//$result 			= $express->getorder('zhongtong','762719985613');						// 获取快递信息(测试数据)
		$ship_status_info 	= $express->get_ship_info($result['state']);							// 获取快递状态
	}
}

//优惠券
if(!empty($obj_order)){
	$coupons = $objCpn->get_by_order($obj_order->id);
	$exCpnIndex = array();
	foreach($coupons as $_k => $_cpn){
		$_content = json_decode($_cpn->content);
		switch($_cpn->type){
			case 1://满m减n
				if($obj->fact_price >= $_content->om){
					$obj->fact_price -= $_content->m;
				}else{
					$exCpnIndex[] = $_k;
				}
				break;
			case 2://直减
				$obj->fact_price -= $_content->m;
				($obj->fact_price < 0) && $obj->fact_price = 0;
				break;
		}
	}
	if(!empty($exCpnIndex)){
		foreach($exCpnIndex as $_index){
			unset($coupons[$_index]);
		}
	}
}

include "tpl/orders_info_web.php";
?>
