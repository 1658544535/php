<?php
/**
 * 微信支付后台通知
 */
define('HN1', true);
require_once('../global.php');
define('CUR_DIR_PATH', dirname(__FILE__));

$time = time();

require_once "lib/WxPay.Api.php";
require_once 'lib/WxPay.Notify.php';
require_once 'log.php';
require_once MODEL_DIR.'/OrderModel.class.php';
require_once MODEL_DIR.'/UserCouponModel.class.php';

$logDir = LOG_DIR.'/wx/';
!file_exists($logDir) && mkdir($logDir, 0777, true);
$logFile = $logDir.'pay_notify_'.date('Y-m-d', $time).'.log';

//初始化日志
$logHandler= new CLogFileHandler($logFile);
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
    //查询订单
    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        Log::DEBUG("query:" . json_encode($result));
        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            return true;
        }
        return false;
    }

    //重写回调处理函数
    public function NotifyProcess($data, &$msg)
    {
        global $db;

        Log::DEBUG("call back:" . json_encode($data));
        $notfiyOutput = array();

        if(!array_key_exists("transaction_id", $data)){
            Log::DEBUG('输入参数不正确');
            $msg = '输入参数不正确';
            return false;
        }
        //查询订单，判断订单真实性
        if(!$this->Queryorder($data["transaction_id"])){
            Log::DEBUG('微信订单查询失败');
            $msg = '订单查询失败';
            return false;
        }

        $Order = new OrderModel($db, 'orders');
        //处理本系统订单
        $order = $Order->get(array('order_number'=>$data['out_trade_no']));

        if(empty($order)){
            Log::DEBUG('没有相关订单：'.$data['out_trade_no']);
            $msg = '没有相关订单';
            return false;
        }

        if( ($data['total_fee']*100) != ($order->pay_online - $order->discount_price))
        {
            Log::DEBUG('订单支付金额不一致：订单应付金额为'.$order->pay_online.'，支付金额为'.($data['out_trade_no']/100));
            $msg = '订单支付金额不一致';
            return false;
        }

        if($order->order_status_id == 0){
            $Order->startTrans();

            //更改订单状态
            $success = $Order->modify(array('order_status_id'=>1,'paid_price'=>$data['total_fee']/100), array('order_id'=>$order->order_id)) ? true : false;
            !$success && Log::DEBUG('更改订单状态失败');

/*
            // 更改优惠券状态
            if( $data['attach'] != '' )
            {
            	$arrParam = array(
					'is_used' 	=> 1,
					'use_time'	=> time()
            	);

            	$arrWhere = array( 'coupon_num'=>$data['attach'] );

            	$success = $Order->modify( $arrParam, $arrWhere ) ? true : false;
            	!$success && Log::DEBUG('更改优惠券状态失败');
            }
*/

            //记录支付信息
            if($success){
                $WXPayInfo = new Model($db, 'wx_pay_info');
                $payInfo = array(
                    'transaction_id' => $data['transaction_id'],
                    'out_trade_no' => $data['out_trade_no'],
                    'time_end' => $data['time_end'],
                    'openid' => $data['openid'],
                    'trade_type' => $data['trade_type'],
                    'bank_type' => $data['bank_type'],
                    'total_fee' => $data['total_fee'],
                    'fee_type' => $data['fee_type'],
                    'cash_fee' => $data['cash_fee'],
                    'cash_fee_type' => $data['cash_fee_type'],
                    'time' => time(),
                );
                $success = $WXPayInfo->add($payInfo, '', true) ? true : false;
                !$success && Log::DEBUG("添加微信支付记录信息失败\r\n支付信息内容：".var_export($payInfo, true));
            }

            if(!$success){
                $Order->rollback();
                Log::DEBUG('订单处理失败');
                $msg = '订单处理失败';
                return false;
            }

            $Order->commit();
        }
        Log::DEBUG('订单处理成功');
        return true;
    }
}

Log::DEBUG("\r\nbegin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);

