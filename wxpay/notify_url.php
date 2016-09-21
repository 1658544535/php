<?php
/**
 * 通用通知接口demo
 * ====================================================
 * 支付完成后，微信会把相关支付和用户信息发送到商户设定的通知URL，
 * 商户接收回调信息后，根据需要设定相应的处理流程。
 *
 * 这里举例使用log文件形式记录回调信息。
*/
//	$testLog = dirname(__FILE__) . '/../logs/wxpay/test_'.date('Y-m-d', time()).'.log';
//	$fp = fopen($testLog,"a");
//	flock($fp, LOCK_EX) ;
//	fwrite($fp,"执行日期：".date("Y-m-d H：i：s",time())."\n支付回调通知开头\n");
//	flock($fp, LOCK_UN);
//	fclose($fp);

	define('HN1', true);
	require_once ('../global.php');

//	$testLog = LOG_INC.'wxpay/test_'.date('Y-m-d', time()).'.log';
//	$fp = fopen($testLog,"a");
//	flock($fp, LOCK_EX) ;
//	fwrite($fp,"执行日期：".date("Y-m-d H：i：s",time())."\n支付回调通知进入\n");
//	flock($fp, LOCK_UN);
//	fclose($fp);

	require_once "WxPayPubHelper.php";
	require_once FUNC_ROOT  . 'cls_payment.php';
	require_once './log_.php';

	$log_name	=	"../logs/wxpay/notify_url_".date('Y-m-d').".log";//log文件路径
	$func_pay 	= new Payment($db);
	$log_ 		= new Log_();


//	$log_->log_result($testLog, "支付回调通知开始\n");

    //使用通用通知接口
	$notify 	= new Notify_pub();

	//存储微信的回调
	$xml 		= $GLOBALS['HTTP_RAW_POST_DATA'];
	$notify->saveData($xml);

	//验证签名，并回应微信。
	//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
	//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
	//尽可能提高通知的成功率，但微信不保证通知最终能成功。
	if($notify->checkSign() == FALSE)
	{
		$notify->setReturnParameter("return_code","FAIL");//返回状态码
		$notify->setReturnParameter("return_msg","签名失败");//返回信息
//		$log_->log_result($testLog, "支付回调通知签名失败\n");
	}
	else
	{
		$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
	}

	$returnXml = $notify->returnXml();


	//以log文件形式记录回调信息

	if($notify->checkSign() == TRUE)
	{
		if ($notify->data["return_code"] == "FAIL")
		{
			//此处应该更新一下订单状态，商户自行增删操作
			$log_->log_result($log_name,"【通信出错】:\n".$xml."\n");
//			$log_->log_result($testLog, "支付回调通知通信出错\n");
		}
		elseif($notify->data["result_code"] == "FAIL")
		{
			//此处应该更新一下订单状态，商户自行增删操作
			$log_->log_result($log_name,"【业务出错】:\n".$xml."\n");
//			$log_->log_result($testLog, "支付回调通知业务出错\n");
		}
		else
		{
			//此处应该更新一下订单状态，商户自行增删操作
			$log_->log_result($log_name,"【微信端支付成功】:\n".$xml."\n");
//			$log_->log_result($testLog, '【'.$notify->data["out_trade_no"]."】支付回调通知微信端支付成功\n");

			//判断订单是否已支付过
			$paied = true;
			$sql = "SELECT * FROM `user_order` WHERE `out_trade_no`='".$notify->data["out_trade_no"]."'";
			$orders = $db->get_results($sql);
			foreach($orders as $v){
				if($v->pay_status == 0){
					$paied = false;
					break;
				}
			}
			if($paied){
				echo 'success';
				exit();
			}

			$arrParam = array(
				'transaction_id' 	=> $notify->data["transaction_id"],
				'fee_type' 			=> $notify->data["fee_type"],
				'bank_type'			=> $notify->data["bank_type"],
				'time_end'			=> $notify->data["time_end"],
				'date'				=> date("Y-m-d H:i:s"),
				'out_trade_no'		=> $notify->data["out_trade_no"],
				'total_fee'			=> $notify->data["total_fee"]
			);

			$opSuccess = $func_pay->u_order_info( $arrParam, $log_ ) ? 'success' : 'faliure';

			$testLogMsg = ($opSuccess == 'success') ? '订单更改成功' : '订单更改失败';
//			$log_->log_result($testLog, '【'.$notify->data["out_trade_no"]."】{$testLogMsg}\n");

			echo $opSuccess;
		}
	}
?>