<?php
define('HN1', true);
require_once('./global.php');

$act = CheckDatas('act', '');
$Name 		            = CheckDatas( 'name', '' );
$Phone		            = CheckDatas( 'phone', '' );
$cardNo 		        = CheckDatas( 'cardNo', '' );
$Number 		        = CheckDatas( 'number', '' );
$Content 		        = CheckDatas( 'content', '' );
$Type 		            = CheckDatas( 'type', '' );
$page                   = max(1, intval($_POST['page']));
$startTime 		        = CheckDatas( 'startTime', '' );
$endTime 		        = CheckDatas( 'endTime', '' );




switch($act)
{
	//拼得客信息
	case 'pdkInfo':
		
		$Objinfo = apiData('pdkApplyInfoApi.do',array('userId'=>$userid));
		
		
		include_once('tpl/pdk_info_web.php');
	break;
    
	//拼得客信息修改
	case 'pdkInfo_edit':
		include_once('tpl/pdk_edit_web.php');
	break;
		
    case 'pdkInfo_save':
    	$Objpdk = apiData('pdkUpdateApi.do',array('cardNo'=>$cardNo,'channel'=>$Content,'image1'=>3,'image2'=>4,'image3'=>5,'image4'=>6,'image5'=>7,'name'=>$Name,'phone'=>$Phone,'userId'=>$userid));
    	if($Objpdk !=null)
    	{
    		echo	ajaxJson('1','',$Objpdk);
    	}
    	else
    	{
    		echo    ajaxJson('0','');
    	}
    break;


    //获取钱包信息
    case 'wallet':
    	$Objwallet = apiData('pdkApplyInfoApi.do',array('userId'=>$userid));
    	
    	include_once('tpl/pdk_wallet_web.php');
    break;

    //获取收入列表数据
    case 'incomes':
    	  $Objincomes = apiData('pdkTranRecListApi.do',array('beginTime'=>$startTime,'endTime'=>$endTime,'pageNo'=>$page,'type'=>1,'userId'=>$userid));
    	  include_once('tpl/pdk_incomes_web.php');
    break;
    
    //获取收入详情数据
    case 'income':
    	include_once('tpl/pdk_income_web.php');
    break;

    //提现操作
    case 'withdrawals':
    	$Uid 		   = CheckDatas( 'uid', '' );
    	$Oldprice 		   = CheckDatas( 'price', '' );
    	include_once('tpl/wd_apply_web.php');
    break;
   
    case 'withdrawals_save':
    	$Price 		            = CheckDatas( 'price', '' );
    	$Objwd = apiData('wdApplyApi.do',array('account'=>$Number,'name'=>$Name,'price'=>$Price,'taType'=>$Type,'userId'=>$userid));
    	
    	if($Objwd !=null)
    	{
    		echo	ajaxJson('1','',$Objwd);
    	}
    	else
    	{
    		echo    ajaxJson('0','');
    	}
    break;

    //获取提现记录列表数据
    case 'withdrawals_records':
    	include_once('tpl/pdk_withdrawals_records_web.php');
    break;
    
    //获取提现记录详情数据
    case 'withdrawals_record':
    	include_once('tpl/pdk_withdrawals_record_web.php');
    break;

    //团免二维码
    case 'QRcode':
    	
    	$info = apiData('pdkApplyInfoApi.do',array('userId'=>$userid));
  
  
  if($info['result']['status'] ==1){
    	$minfo = apiData('myInfoApi.do',array('userId'=>$userid));
    	if(!empty($minfo['result']['invitationCode']))
    	{
    		$imgPath = AGENT_QRCODE_DIR."{$userid}.png";
    		if(!file_exists(SCRIPT_ROOT."upfiles/pdkcode/{$userid}.png"))
    		{
    			global $site;
    			$data = $site . 'pdk_code_action.php?minfo=' . $minfo['result']['invitationCode'];
    			get_qrcode($data, SCRIPT_ROOT."upfiles/pdkcode/", $userid . '.png');
    		}
    	
    	}
    	else
    	{
    		$imgPath = '';
    	}
  }
    	include_once('tpl/pdk_QR_web.php');
    break;


}
?>