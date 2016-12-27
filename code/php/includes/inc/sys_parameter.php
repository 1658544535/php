<?php

	/*============================== 极客验证帐号信息  =============================================*/
	define("GEETEST_CAPTCHA_ID", "2e59d827cc99a7272e352a816a875792");
	define("GEETEST_PRIVATE_KEY", "385b1d51aaf1bc3c3d44fd30f9cb5495");

	/*============================== 全局定义数据表  =============================================*/
	switch($_SERVER['SERVER_NAME']){
		case 'weixin.pindegood.com':
			define('SITE_IMG',"http://app.pindegood.com/upfiles/");					// 获取图片地址
			define('APIURL' ,"http://app.pindegood.com/v3.5/"); 							//api接口的地址
			break;
		case 'wxpdh.choupinhui.net':
			define('SITE_IMG',"http://pdh.choupinhui.net/upfiles/");					// 获取图片地址
			define('APIURL' ,"http://pdh.choupinhui.net/v3.5/"); 							//api接口的地址
			break;
		default:
			define('SITE_IMG',"http://pin.taozhuma.com/upfiles/");					// 获取图片地址
			define('APIURL' ,"http://pin.taozhuma.com/v3.6/"); 							//api接口的地址
			break;
	}
	define('AD_TABLE',"ad");
	define('FEEDBACK_TABLE',"feedback");
	define('HELP_TABLE',"help");
	define('INFO_TABLE',"info");
	define('USER_CONNECTION_TABLE',"user_connection");
	define('USER_CART_TABLE',"user_cart");
	define('USER_COMMENT_TABLE',"user_comment");
	define('USER_COLLECT_TABLE',"user_collect");
	define('REFUND_TABLE',"user_order_refund");
	define('USER_ORDER_DETAIL_TABLE',"user_order_detail");
	define('USER_INFO_TABLE',"user_info");
	define('CONSUMER_TABLE',"user_consumer");
	define('USER_CONSUMER_TABLE',"user_consumer");
	define('USER_CONSUMER_COLLECT_TABLE',"user_consumer_collect");
	define('USER_SHOP_TABLE',"user_shop");
	define('USER_SHOP_COLLECT_TABLE',"user_shop_collect");
	define('USER_SHIP_ADDRESS_TABLE',"user_ship_address");
	define('USER_PRIVILEGES_TABLE',"user_privileges");
	define('USER_PAY_TABLE',"user_pay");
	define('USER_ORDER_TABLE',"user_order");
	define('SYS_AREA_TABLE',"sys_area");
	define('SYS_LOGIN_TABLE',"sys_login");
	define('USER_ADDRESS_TABLE',"user_address");
	define('ATTEST_TABLE',"user_attestation");
	define('PAY_RECORDS_TABLE',"pay_records");
	define('PRODUCT_IMAGES_TABLE',"product_images");
	define('PRODUCT_STOCK_TABLE',"product_stock");
	define('PRODUCT_TYPE_TABLE',"product_type");
	define('PRODUCT_TABLE',"product");
	define('HISTORY_TABLE',"history");
	define('SYS_DICT_TABLE',"sys_dict");
	define('SYNTHETICAL_DICT_TABLE',"synthetical_dict");
	define('PRODUCT_ACTIVITY_TABLE',"product_activity");

	/*============================== 物流类型  =============================================*/
	$ExpressType = array(
		'shunfeng' => '顺丰快递',
		'shentong' => '申通快递',
		'zhongtong' => '中通快递',
		'yuantong' => '圆通快递',
		'huitong' => '汇通快递',
		'tiantian' => '天天快递',
		'yunda' => '韵达快递',
		'dhl' => 'DHL快递',
		'zhaijisong' => '宅急送',
		'debang' => '德邦物流',
		'ems' => 'EMS国内',
		'eyoubao' => 'E邮宝',
		'guotong' => '国通快递',
		'longbang' => '龙邦速递',
		'lianbang' => '联邦快递',
		'tnt' => 'TNT快递',
		'xinbang' => '新邦物流',
		'zhongtie' => '中铁快运',
		'zhongyou' => '中邮物流',
	);

	/*============================== Activity_time.tyep与 User_Cart.type对应关系  =============================================*/
	$getProductActivityType = array(
		// 下标（活动）：   0-秒杀  1-专题(钱包)  2-场景  3-专场' .
		// 购物车： 0-普通商品  1-活动商品  2-秒杀  3-专题  4-场景  5-专场' .
		0 => 2,
		1 => 3,
		2 => 4,
		3 => 5
	);

	/*============================== 活动类型  =============================================*/
	$ActivityType = array(
		0 => '限量购',
		1 => '钱包活动',
		2 => '场景活动',
		3 => '专场活动',
	);

	/*============================== 订单状态  =============================================*/
	$OrderStatusDesc = array(
		1=>'等待买家付款',
		2=>'买家已付款',
		3=>'卖家已发货',
		4=>'交易成功',
		5=>'交易成功'
	);

	/*============================== 退货状态  =============================================*/
	$ReOrderStatusDesc = array(
		1=>'售后申请审核中',
		2=>'售后申请处理中',
		4=>'退货成功',
		5=>'售后申请失败',
		6=>'售后申请不成功'
	);

	/*============================== 退款原因  =============================================*/
	$RefundType = array(
		1=>'不喜欢',
		2=>'质量不好',
		3=>'尺码不对',
		4=>'颜色不对',
		5=>'其他'
	);
?>