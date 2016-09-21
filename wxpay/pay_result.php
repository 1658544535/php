<?php
define('HN1', true);
require_once ('../global.php');
require_once "WxPayPubHelper.php";
require_once FUNC_ROOT  . 'cls_payment.php';
require_once './log_.php';

$urlSuccess = '/orders?act=success';
$urlFailure = '/orders?sid=1';

$log_name	=	"../logs/wxpay/notify_url_".date('Y-m-d').".log";//log文件路径
$func_pay 	= new Payment($db);
$log_ 		= new Log_();

$out_trade_no = trim($_REQUEST["out_trade_no"]);

//使用订单查询接口
$orderQuery = new OrderQuery_pub();
$orderQuery->setParameter("out_trade_no","$out_trade_no");//商户订单号

//获取订单查询结果
$orderQueryResult = $orderQuery->getResult();
//商户根据实际情况设置相应的处理流程,此处仅作举例

if ($orderQueryResult["return_code"] == "FAIL") {
    redirect($urlFailure);
}else if($orderQueryResult["result_code"] == "FAIL"){
    redirect($urlFailure);
}else{
    if($orderQueryResult['trade_state']=='SUCCESS') {
        //判断订单是否已支付过
        $paied = true;
        $sql = "SELECT * FROM `user_order` WHERE `out_trade_no`='".$out_trade_no."'";
        $orders = $db->get_results($sql);
        foreach($orders as $v){
            if($v->pay_status == 0){
                $paied = false;
                break;
            }
        }
		$_SESSION['order_pay_flag'] = true;
        if($paied){
            redirect($urlSuccess);
            exit();
        }

        $arrParam = array(
            'transaction_id' 	=> $orderQueryResult["transaction_id"],
            'fee_type' 			=> $orderQueryResult["fee_type"],
            'bank_type'			=> $orderQueryResult["bank_type"],
            'time_end'			=> $orderQueryResult["time_end"],
            'date'				=> date("Y-m-d H:i:s", time()),
            'out_trade_no'		=> $orderQueryResult["out_trade_no"],
            'total_fee'			=> $orderQueryResult["total_fee"],
        );

        $func_pay->u_order_info( $arrParam, $log_ );
        redirect($urlSuccess);
    }else {
        redirect($urlFailure);
    }
}