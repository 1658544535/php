<?php
define('HN1', true);
require_once('../global.php');

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
	foreach ($ObjGrouponList['result'] as $gro)
	{
			$seckillTimeDiff[] = strtotime($gro['endTime']) - strtotime($gro['nowTime']);
	}
		 	   
		 	   $Data =array(
	 				'data'=>$ObjGrouponList['result'],
	 				'TimeDiff'=>$seckillTimeDiff,
		 		);

		 	   
		 	   $arr = array(
		 	   		'code' => 1,
		 	   		'msg' => '成功',
		 	   		'data' => array(
		 	   				'proData' => array(
		 	   						'pageNow' => $page,
		 	   						'ifLoad' => empty($ObjGrouponList['result']) ? 0 : 1,
		 	   						'listData' => $Data,
		 	   				),
		 	   		),
		 	   );
		 	   echo json_encode($arr);
}


?>