<?php
define('HN1', true);
require_once('../global.php');

$GrouponActivityModel         = M('groupon_activity');
$GrouponActivityRecordModel   = M('groupon_activity_record');
$GrouponUserRecordModel       = M('groupon_user_record');
$FocusSettingModel            = M('focus_setting');
$UserInfoModel 				  = M('user_info');
$ProductFocusImagesModel      = M('product_focus_images');



$act  = CheckDatas( 'act', 'info' );
$productId   	= CheckDatas( 'pid', '' );
$uId   	        = CheckDatas( 'uid', '' );
$gId   	        = CheckDatas( 'gid', '' );
$Prize   	    = CheckDatas( 'type', '' );
$Price          = CheckDatas( 'price', '' );
$as             = CheckDatas( 'activity_status', '' );
$page           = max(1, intval($_POST['page']));







switch($act)
{
    
	
    case 'user':
   
    	//获取更多用户参与信息数据


        $ObjUserList    = apiData('userJoinInfoApi.do', array('activityId'=>$gId,'pageNo'=>$page,'pageSize'=>20));

        if($ObjUserList !='')
        {
        	echo	ajaxJson( 1,'获取成功',$ObjUserList['result']['joinUserList'],$page);
        }
        else
        {
        	echo	ajaxJson( 0,'获取失败');
        
        }
    	
    break;
    
    
    
    case 'prize':
    	 
    	//获取更多中奖用户信息数据
    
    
    	$ObjPrizeList    = apiData('winListApi.do', array('activityId'=>$gId,'pageNo'=>$page,'prize'=>$Prize));
  
    	
        if($ObjPrizeList !='')
        {
        	echo	ajaxJson( 1,'获取成功',$ObjPrizeList['result']['prizeList'],$page);
        }
        else
        {
        	echo	ajaxJson( 0,'获取失败');
        
        }
    	 
    	break;
    
    
    
    
    
    default:
    	
    	
	    //猜价格活动列表

	    $ObjGrouponList = apiData('guessActivityApi.do', array('pageNo'=>$page));
	   
	     
	    
 		        //显示活动倒计时
		 		foreach ($ObjGrouponList['result'] as $gro){
		 		
		 			$seckillTimeDiff[] = strtotime($gro['endTime']) - strtotime($gro['nowTime']);
		 		
		 			
// 		 			if($gro !='' )
// 		 			{
// 		 				$date 	= DataTip( $gro['endTime'], '-' );
// 		 			}
// 		 			$dateTip[]  			= $date['date_tip'];
// 		 			$seckillTimeDiff[] 	    = $date['date_time'];
		 			 
		 		}
		 	   
		 	   $Data =array(
	 				'data'=>$ObjGrouponList['result'],
	 				'TimeDiff'=>$seckillTimeDiff,
		 		);

			if($ObjGrouponList['success']){
				if(empty($ObjGrouponList['result'])){
					ajaxJson(1,'获取失败', array('data'=>array()), 1);
				}else{
					ajaxJson(1,'获取成功', empty($Data['data']) ? array() : $Data, $page);
				}
			}else{
				ajaxJson(1,'获取失败', array('data'=>array()), 1);
			}		 	
}


?>