<?php
define('HN1', true);
require_once('../global.php');

require_once "WxPayPubHelper.php";
require_once FUNC_ROOT.'cls_payment.php';

$outTradeNo     =  !isset( $_GET['id'] )  ? '' : $_GET['id'];
$code  			=  !isset($_GET['code']) ? '' : $_GET['code'];
$jsApi 			=  new JsApi_pub();

if ( $outTradeNo == '' )
{
	redirect('/orders?return_url=user','参数有误！');
	exit;
}

//防止支付成功后点击“返回”
$sql = "SELECT * FROM `user_order` WHERE `out_trade_no`='".$outTradeNo."'";
$order = $db->get_row($sql);
if(empty($order) || $order->pay_status != 0){
	redirect('/orders');
	exit;
}

/* ================== 步骤1：网页授权获取用户openid ============ */
	if ( $code == '' )					// 触发微信返回code码
	{
		$url   = $jsApi->createOauthUrlForCode(urlencode(WxPayConf_pub::JS_API_CALL_URL.'?id=' . $outTradeNo));
		Header("Location: $url");
		return;
	}


	$jsApi->setCode($code);
	$openid = $jsApi->getOpenId();			// 通过code获取openid

/* ================== 步骤2：获取支付所需的记录 ============ */
	$payment 			= new Payment($db);
	$total_fee 			= $payment->getOrderPayAmount($outTradeNo);
	$total_fee 			= $total_fee * 100;

/* ================== 步骤3：使用统一支付接口，获取prepay_id ============ */
	//使用统一支付接口
	$unifiedOrder = new UnifiedOrder_pub();

	$unifiedOrder->setParameter("openid","$openid");								//商品描述
	$unifiedOrder->setParameter("body","产品购买");									//商品描述
	$timeStamp 		= time();
	//$out_trade_no 	= WxPayConf_pub::APPID."$timeStamp";
	$unifiedOrder->setParameter("out_trade_no",$outTradeNo);						//商户订单号
	$unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);			//通知地址
	$unifiedOrder->setParameter("trade_type","JSAPI");								//交易类型
	$unifiedOrder->setParameter("total_fee",$total_fee);							//总金额

	$prepay_id 		= $unifiedOrder->getPrepayId();									// 1、把传入的参数组成xml文件 2、提交给统一支付接口 3、将获得返回 4、获取prepay_id

/* ================== 步骤3：使用jsapi调起支付 ============ */

	$jsApi->setPrepayId($prepay_id);												// 设置预支付ID参数
	$jsApiParameters = $jsApi->getParameters(); 									// 根据prepay_id生成jsapi支付参数,生成的json数据


/* ================== 步骤4：在微信浏览器中调试起js接口 ============ */
include "../tpl/paid_web.php";

?>

