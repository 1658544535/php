<?php
define('HN1', true);
require_once('./global.php');

$act = CheckDatas('act', '');
$Name 		            = CheckDatas( 'name', '' );
$Phone		            = CheckDatas( 'phone', '' );
// $cardNo 		        = CheckDatas( 'cardNo', '' );
$Number 		        = CheckDatas( 'number', '' );
$Content 		        = CheckDatas( 'content', '' );
$Type 		            = CheckDatas( 'type', '' );
$page                   = max(1, intval($_POST['page']));
$startTime 		        = CheckDatas( 'startTime', '' );
$endTime 		        = CheckDatas( 'endTime', '' );
$status 		        = CheckDatas( 'status', '' );


switch($act)
{
	//拼得客信息
	case 'pdkInfo':
		IS_USER_LOGIN();
		$Objinfo = apiData('pdkApplyInfoApi.do',array('userId'=>$userid));
		$Objinfo = $Objinfo['result'];
		include_once('tpl/pdk_info_web.php');
	break;
    
	//拼得客任务清单
	case 'mission':
		//获取拼得客信息
 		$pdkInfo = apiData('pindekeUserInfo.do',array('userId'=>$userid));
		if($pdkInfo['success'] ==''){
			redirect('index.php',您无法访问该页面！);
		}
		//分类筛选
		$classOne = apiData('productCategoryApi.do');
		$classOne = $classOne['result'];
		
		include_once('tpl/pdk_mission_list_web.php');
	break;

    
    //获取钱包信息
    case 'wallet':
    	IS_USER_LOGIN();
    	$pdkInfo = apiData('pindekeUserInfo.do',array('userId'=>$userid));
    	if($pdkInfo['success'] ==''){
    		redirect('index.php',您无法访问该页面！);
    	}
    	$Objwallet = apiData('pindekeUserInfo.do',array('userId'=>$userid));
    	include_once('tpl/pdk_wallet_web.php');
    break;

    //获取收入列表数据
    case 'incomes':
    	$pdkInfo = apiData('pindekeUserInfo.do',array('userId'=>$userid));
    	if($pdkInfo['success'] ==''){
    		redirect('index.php',您无法访问该页面！);
    	}
    	 $page       = max(1, intval($_POST['page']));
    	 $Objincomes = apiData('pdkTranRecListApi.do',array('beginTime'=>$startTime,'endTime'=>$endTime,'pageNo'=>$page,'type'=>1,'userId'=>$userid));
    	 include_once('tpl/pdk_incomes_web.php');
    break;
    
    //获取收入详情数据
    case 'income':
    	$pdkInfo = apiData('pindekeUserInfo.do',array('userId'=>$userid));
    	if($pdkInfo['success'] ==''){
    		redirect('index.php',您无法访问该页面！);
    	}
    	$Id 	   = CheckDatas( 'id', '' );
    	$Objincome = apiData('tranDetailApi.do',array('id'=>$Id));
    	include_once('tpl/pdk_income_web.php');
    break;

    //提现操作
    case 'withdrawals':
    	$pdkInfo = apiData('pindekeUserInfo.do',array('userId'=>$userid));
    	if($pdkInfo['success'] ==''){
    		redirect('index.php',您无法访问该页面！);
    	}
    	$Uid 		   = CheckDatas( 'uid', '' );
    	$Objinfo = apiData('pdkApplyInfoApi.do',array('userId'=>$Uid));
    	include_once('tpl/wd_apply_web.php');
    break;
   
    case 'withdrawals_save':
    	$Price 		            = CheckDatas( 'price', '' );
    	$Type 		            = CheckDatas( 'type', '' );
    	$Objwd = apiData('wdApplyApi.do',array('account'=>$Number,'name'=>$Name,'price'=>$Price,'taType'=>$Type,'userId'=>$userid),'post');
    	if(!empty($Objwd['success'])){
    	    redirect('pindeke.php?act=wallet&uid='.$userid,申请成功！);
    	}else{
    		redirect('pindeke.php?act=wallet&uid='.$userid,您已有一笔提现记录正在审核中，请耐心等待管理员审核);
    	}
    break;

    //获取提现记录列表数据
    case 'withdrawals_records':
    	$pdkInfo = apiData('pindekeUserInfo.do',array('userId'=>$userid));
    	if($pdkInfo['success'] ==''){
    		redirect('index.php',您无法访问该页面！);
    	}
    	$page      = max(1, intval($_POST['page']));
    	$Oldprice  = CheckDatas( 'price', '' );
    	$Objrecord = apiData('pdkTranRecListApi.do',array('type'=>2,'userId'=>$userid));
    	include_once('tpl/pdk_withdrawals_records_web.php');
    break;
    
    //获取提现记录详情数据
    case 'withdrawals_record':
    	$pdkInfo = apiData('pindekeUserInfo.do',array('userId'=>$userid));
    	if($pdkInfo['success'] ==''){
    		redirect('index.php',您无法访问该页面！);
    	}
    	$Id 		        = CheckDatas( 'id', '' );
    	$Objwithdrawals = apiData('tranDetailApi.do',array('id'=>$Id));
    	$Objwithdrawals = $Objwithdrawals['result'];
    	include_once('tpl/pdk_withdrawals_record_web.php');
    break;

    //团免二维码
    case 'QRcode':
    	IS_USER_LOGIN();
    	
    	$userid= CheckDatas( 'uid', '' );
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
    	include_once('tpl/pdk_QR_web.php');
    	break;
    	
    //拼得客排行榜
    case 'ranking':
    	IS_USER_LOGIN();
    		 
        $pdkInfo = apiData('pindekeUserInfo.do',array('userId'=>$userid));
    	if($pdkInfo['success'] ==''){
    		redirect('index.php',您无法访问该页面！);
    	}
    	
    	
    	
    	include_once('tpl/pdk_ranking_web.php');
    	break;
    	
    	
    	
    //拼得客邀请二维码
    case 'QRcodeNew':
    	IS_USER_LOGIN();
    		 
    	$minfo = apiData('myInfoApi.do',array('userId'=>$userid));
    		 
    	if(!empty($minfo['result']['invitationCode']))
    	{
    		$imgPath = AGENT_QRCODE_DIR."{$userid}.png";
    		if(!file_exists(SCRIPT_ROOT."upfiles/pdkcode/{$userid}.png"))
    		{
    			global $site;
    			$data = $site . 'pindeke_apply.php?act=binding&minfo=' . $minfo['result']['invitationCode'];
    			get_qrcode($data, SCRIPT_ROOT."upfiles/pdkcode/", $userid . '.png');
    		}
    	}
    	else
    	{
    		$imgPath = '';
    	}
    	include_once('tpl/pdk_QR_web.php');
    	break;
}


?>