<?php

define('HN1', true);
require_once('./global.php');

require_once  LOGIC_ROOT.'user_orderBean.php';
require_once  LOGIC_ROOT.'sys_loginBean.php';
require_once  LOGIC_ROOT.'user_order_detailBean.php';
require_once  LOGIC_ROOT.'user_order_refundBean.php';
require_once  LOGIC_ROOT.'sys_dictBean.php';

$user_order_refund 	= new user_order_refundBean();
$user_order			= new user_orderBean();
$sys_login			= new sys_loginBean();
$user_order_detail	= new user_order_detailBean();
$sdb 				= new sys_dictBean();

if($openid == null)
{
	redirect("login.php?dir=index");
	return;
}

$order_detail_id = ! isset($_REQUEST['id'])  ? 0  : intval($_REQUEST['id']);
$act 			 = ! isset($_REQUEST['act']) ? "" : $_REQUEST['act'];

switch($act)
{
	/*========================================== 退货申请状态 ==========================================*/
	case 'post':
		/*
		 * 	功能： 退货申请状态
		 *
		 *  流程：
		 *  1、获取申请数据
		 *  2、获取退货商品的信息
		 *  3、修改user_order_detail相关的数据 re_status=1
		 *  4、添加user_order_refund的记录
		 *  5、判断该订单的有效值，（查看该订单的商品是否都申请退货，如果是则关闭订单）
		 * */

		// 1、获取申请数据
		$type 			= $_POST['type'];				// 退货类型
		$refund_Type 	= $_POST['refund_type'];		// 退货原因
		$refund_num  	= $_POST['num'];				// 退货数量
		$refund_reason 	= $_POST['reason'];				// 退货说明
		$oid 			= $_POST['order_id'];			// user_order_detail.id

		// 2、获取退货商品的信息
		$order_detail_info = $user_order_detail->detail($db, $oid);

		$db->query("BEGIN");
		// 4、修改user_order_detail相关的数据 re_status=1
		$rs = $user_order_detail->refund( $db, $oid, $userid);

		if ( !$rs )
		{
			$db->query("ROLLBACK");
		}

		// 5、添加user_order_refund的记录
		$rs = $user_order_refund->create($oid,$order_detail_info->order_id,$order_detail_info->user_id,$order_detail_info->loginname,$order_detail_info->shop_id,$order_detail_info->product_id,$order_detail_info->product_name,$order_detail_info->stock_price,$refund_num,$refund_reason,$refund_Type,$type,$order_detail_info->product_image,$order_detail_info->sku_link_id,$db);

		if (  ! $rs )
		{
			$db->query("ROLLBACK");
		}

		// 6、判断该订单的有效值
		//$user_order_detail->set_order_product_valid( $db, $order_detail_info->order_id, $userid );

		$db->query("COMMIT");
		redirect( "/returnapply?id=" . $oid );
	break;


	/*========================================== 提交退货信息 ==========================================*/
	case 'submit':
		// 获取退货物流信息
		$detail_id 	= $_POST['order_id'];
		$userid    	= $userid;
		$logistics 	= $_POST['logistics'];
		$logType	= $_POST['logType'];
		$address   	= $_POST['address'];
		//$address   	= "";

		$db->query("BEGIN");

		// 1、更新user_order_refund 退货信息，并更新状态
		$rs = $user_order_refund->returncomfire( $db, $detail_id, $userid, $logistics, $logType );

		if ( !$rs )
		{
			$db->query("ROLLBACK");
		}
		else
		{
			// 2、更新user_order_detail 更新状态
			$rs = $user_order_detail->refund2($db,$detail_id,$userid);

			if ( !$rs )
			{
				$db->query("ROLLBACK");
			}
		}

		$db->query("COMMIT");
		redirect( "/orders?act=return" );
	break;


	/*========================================== 默认页面 ==========================================*/
	default:

		//查询order_refund
		$obj = $user_order_detail->get_user_order_detail($db,$order_detail_id,$userid);			// 获取订单详情中指定商品的信息

		// 如果记录为空，则为非法操作
		if ( ! is_object($obj) )
		{
			echo "非法操作";
			exit;
			redirect('/');
		}

		$get_order_info    = $user_order->get_order_info($db, $obj->order_id, $userid);			// 获取订单详情中对应的订单信息
		$logisticsList = $sdb->get_logistics($db);												// 获取快递列表

		$user_order_refund = $user_order_refund->detail($db,$order_detail_id,$userid); 			// 获取user_order_refund的记录

		if ( $obj->re_status == 0 )																// 如果该订单还未申请，则显示提交申请界面
		{
			include "tpl/returnapply_web.php";
		}
		else if ( $obj->re_status == 1 || $obj->re_status == 3 || $obj->re_status == 4   )		// 如果已经申请退款，则显示审核界面
		{
			$re_status = $obj->re_status;
			$return_type_desc = refund_Type($user_order_refund->refund_Type);
			include "tpl/returnapply_result.php";
		}
		else if ( $obj->re_status == 2 )														// 如果审核成功，让用户填写快递号
		{
			if ( $user_order_refund == null )
			{
				redirect("/user","非法操作");
				return;
			}

			//获取用户的收货地址
			$order_info = $user_order->get_order_info( $db,$user_order_refund->order_id,$userid );
			include "tpl/returnapply_submit.php";
		}
		else
		{
			redirect( "/orders" );

			echo "非法操作";
			exit;
		}


}


// 根据退货ID返回相应的描述
function refund_Type($type)
{
	switch( $type )
	{
		case 1:
			$str = "不喜欢";
		break;

		case 2:
			$str = "质量不好";
		break;

		case 3:
			$str = "尺寸不对";
		break;

		case 4:
			$str = "颜色不对";
		break;

		default:
			$str = "其他";
	}

	return $str;
}




?>
