<?php
define('HN1', true);
require_once('../global.php');

$GrouponActivityModel = M('groupon_activity');
$GrouponUserRecordModel = M('groupon_user_record');

$act  = CheckDatas( 'act', 'info' );
$productId   	= CheckDatas( 'pid', '' );
$uId   	        = CheckDatas( 'uid', '' );
$gId   	        = CheckDatas( 'gid', '' );
$Prize   	    = CheckDatas( 'prize', '' );
$Price          = CheckDatas( 'price', '' );
$as             = CheckDatas( 'activity_status', '' );
switch($act)
{
    
	
    case 'more':
    	//获取更多用户参与信息数据
    	$UserList = $GrouponUserRecordModel->gets(array('activity_type'=>3,'activity_id'=>$gId,'prize'=>$Prize),'',array('attend_time'=>'DESC'),$page,20);
    	
    break;
    default:
    
    	
	    //猜价格活动列表
	    $ObjGrouponList = $GrouponActivityModel->query("SELECT g.price_min, g.price_max, g.begin_time, g.end_time, g.status, g.activity_status, g.type, g.banner, g.num, p.id, p.product_name, p.image FROM `groupon_activity` AS g LEFT JOIN product AS p on p.`id` = g.`product_id` WHERE 1=1 AND g.status =1 AND g.type =3 AND g.activity_status !=0 ORDER BY g.sorting DESC,g.create_date DESC ",false,true,$page);
	    
	    if($ObjGrouponList['DataSet'] !='')
		{
			echo	get_json_data_public( 1,'获取成功',$ObjGrouponList ); 
		}
		else
		{
			echo	get_json_data_public( -1,'获取失败' );
		}
		
		        //显示活动倒计时
		 		foreach ($ObjGrouponList['DataSet'] as $gro){
		
		 			if($gro !=''){
		 			$date 	= DataTip( $gro->end_time, '-' );
		 			}
		 			$dateTip  			= $date['date_tip'];
		 			$seckillTimeDiff 	= $date['date_time'];
		 		}



}


?>