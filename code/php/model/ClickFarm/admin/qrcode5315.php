<?php
/**
 * 5315临时获取订单二维码
 */
define('HN1', true);
require_once('../global.php');
require_once( LOGIC_ROOT . 'UserOrderBean.php');
//error_reporting(E_ALL);

class Temp5315 extends Db{
    /*
	 * 功能：获取对外订单号
	 * */
    private function set_out_trade_no()
    {
        $time = explode(" ", microtime());
        return date('Ymd') . $time[1] . rand(100,999);
    }

    /*
	 * 功能： 获取订单号
	 * */
    private function set_order_num()
    {
        $time = explode(" ", microtime());
        $rand = rand(100000, 999999);
        return $time[1] * 1000 . $rand;
    }
    
    public function _genTempOrder(){
        global $db;

        $time = time();
        $date = date('Y-m-d H:i:s', $time);

        $sql = 'SELECT * FROM `user_order` WHERE `order_type`=1 AND `order_status`=1 AND `pay_status`=0 ORDER BY rand() LIMIT 1';
        $order = $db->get_row($sql);

        $arrParam = array(
            'user_id' 				=>	$order->user_id,
            'suser_id'				=>	$order->suser_id,
            'all_price' 			=>	3000,
            'fact_price'			=>	3000,
            'out_trade_no' 			=>	$this->set_out_trade_no(),
            'espress_price'			=>	0,
            'consignee'				=>	$order->consignee,
            'consignee_address'		=>	$order->consignee_address,
            'consignee_phone'		=>	$order->consignee_phone,
            'consignee_type'		=>	1,
            'order_status'			=>  1,
            'create_by'				=> -1,
            'create_date'			=> $date,
            'update_by'				=> -1,
            'update_date'			=> $date,
            'channel' 				=> 1,
            'province' 				=> '',
            'city' 					=> '',
            'area' 					=> '',
            'order_type'			=> 1,
            'order_no'				=> $this->set_order_num(),
            'pay_method'			=> 2,
            'pay_status'			=> 0
        );

        $order_id = $db->create('user_order', $arrParam);
        return $order_id;
    }
}

//$objTemp = new Temp5315($db, 'user_order');
//echo $objTemp->_genTempOrder();
//die;

$curSiteHost = 'http://weixinm2c.taozhuma.com';
//$sql = 'SELECT `id` FROM `user_order` WHERE `order_type`=1 AND `order_status`=1 AND `pay_status`=0 ORDER BY rand() LIMIT 1';
//$sql = 'SELECT `id` FROM `user_order` WHERE `order_type`=1 AND `order_status`=1 AND `pay_status`=0 ORDER BY rand() LIMIT 1';
//$order = $db->get_row($sql);
$orderId = 227887;

updateTradeNo($db, $orderId);
echo "<img src='{$curSiteHost}/model/ClickFarm/qrcode_img/wxpay/{$orderId}.png?_".rand()."'>";

/**
 * 功能：更新对外订单号，并更新支付二维码
 */
function updateTradeNo( $db, $order_id )
{
    // 修改对外订单id
    $UserOrderBean 				= new UserOrderBean( $db,  'user_order' );
    $dataParam['out_trade_no'] 	= set_out_trade_no();
    $dataWhere['id']			= $order_id;

    $rs = $UserOrderBean->update( $dataParam, $dataWhere);

    if ($rs == 0)
    {
        return false;
    }

    $rs = $UserOrderBean->getOne($dataWhere);								// 获取用户订单表

    $WxpayOrderInfoBean = M( 'wxpay_order_info', $db );
    $arrParam = array(
        'out_trade_no'	=>	$rs->out_trade_no,
        'total_fee'		=>	$rs->fact_price,
        'trade_status'	=>	'WAIT_BUYER_PAY',
        'create_date'	=>	date('Y-m-d H:i:s'),
        'update_date'	=>	date('Y-m-d H:i:s')
    );

    $WxpayOrderInfoBean->create($arrParam);									// 新增wxpay_order_info记录

    $fPrice = $rs->fact_price * 100;

    $rs = getQrCode( $fPrice, $rs->out_trade_no, $order_id );

    return $rs;
}

function _testPS($data, $exit=true){
    echo '<pre>'.print_r($data, true).'</pre>';
    if($exit) exit();
}

