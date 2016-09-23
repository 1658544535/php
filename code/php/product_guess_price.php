<?php
define('HN1', true);
require_once('./global.php');

$GrouponActivityModel         = M('groupon_activity');
$GrouponActivityRecordModel   = M('groupon_activity_record');
$GrouponUserRecordModel       = M('groupon_user_record');
$FocusSettingModel            = M('focus_setting');

$act  = CheckDatas( 'act', 'info' );
$productId   	= CheckDatas( 'pid', '' );
$uId   	        = CheckDatas( 'uid', '' );
$gId   	        = CheckDatas( 'gid', '' );
$Prize   	    = CheckDatas( 'prize', '' );
$Price          = CheckDatas( 'price', '' );
$as             = CheckDatas( 'activity_status', '' );
switch($act)
{
    case 'detail':
    	
    	//获取活动商品信息
    	$ObjGrouponInfo = $GrouponActivityModel->query("SELECT g.price_min, g.price_max, g.begin_time, g.end_time, g.status, g.activity_status, g.type, g.banner, g.num, p.id, p.product_name, p.image, p.content FROM `groupon_activity` AS g LEFT JOIN product AS p on p.`id` = g.`product_id` WHERE 1=1 AND g.status =1 AND g.type =3  AND g.id ='".$gId."' AND g.product_id = '".$productId."' ORDER BY g.sorting DESC,g.create_date DESC ",false,false);
    	  	
    	//显示活动倒计时
    	$date 	= DataTip( $ObjGrouponInfo->end_time, '-' );

    	$dateTip  			= $date['date_tip'];
    	$seckillTimeDiff 	= $date['date_time'];
    	
    	
    
    	
    	//获取个人参与信息(进行中)
    	$ObjUserInfo    = $GrouponActivityRecordModel ->query("SELECT gu.user_id, gu.status, gu.prize, gu.attend_time, s.name, s.image FROM `groupon_user_record` AS gu LEFT JOIN `sys_login` AS s on gu.`user_id` = s.`id` LEFT JOIN `groupon_activity` AS g on gu.`activity_id` = g.`id` WHERE 1=1 AND gu.activity_type =3  AND g.id ='".$gId."' AND gu.activity_id = '".$gId."' AND s.id = '".$uId."' ",false,false);
    
    
        //获取参与人信息(进行中)
	   	
	    $ObjUserList    = $GrouponUserRecordModel->query("SELECT gu.user_id, gu.status, gu.prize, gu.attend_time, s.name, s.image FROM `groupon_user_record` AS gu LEFT JOIN `sys_login` AS s on gu.`user_id` = s.`id` LEFT JOIN `groupon_activity` AS g on gu.`activity_id` = g.`id` WHERE 1=1 AND gu.activity_type =3  AND g.id ='".$gId."' AND gu.activity_id = '".$gId."'  ORDER BY gu.create_date DESC limit 0,10 ",false,true,$page);
	    	    	
    include "tpl/product_guess_price_detail_web.php";
	break;
	
	case 'detail_save':
	 //提交猜价价格
		$ObjPrice = $GrouponUserRecordModel->modify(array('user_id'=>$uId,'activity_type'=>3,'activity_id'=>$gId,'price'=>$Price,'attend_time'=>now()),array('activity_id'=>$gId));
		if($ObjPrice !=null)
		{
			redirect('/product_guess_price.php?act=detail&gid='.$gId,'提交成功！');
		}
		else
		{
			redirect('/product_guess_price.php?act=detail&gid='.$gId,'提交失败！');
		}
	
    break;
	
//     case 'more':
//     	//获取更多用户参与信息数据
//     	$UserList = $GrouponUserRecordModel->gets(array('activity_type'=>3,'activity_id'=>$gId,'prize'=>$Prize),'',array('attend_time'=>'DESC'),$page,20);
//     	$data =  get_json_data_public( $UserList );
//     	include "tpl/product_guess_price_more_web.php";
//     break;
    
    
    case 'user_price':
    	//获取个人参加猜价活动数据
    	$UserPriceList = $GrouponUserRecordModel->query("SELECT gu.user_id, gu.status, gu.prize, gu.attend_time, gu.price, g.product_id, g.activity_status, p.product_name, p.image FROM `groupon_user_record` AS gu LEFT JOIN `groupon_activity` AS g on gu.`activity_id` = g.`id` LEFT JOIN `product` AS p on g.`product_id` = p.`id` WHERE 1=1 AND gu.activity_type =3   AND gu.id = '".$uId."' AND gu.prize = '".$Prize."' AND g.activity_status = '".$as."' ORDER BY gu.create_date DESC ",false,true,$page);
    
    	
    	
    	
    	
    	
    	
    	
    	include "tpl/product_guess_price_user_web.php";
    	break;
    
    
    
    
	default:
        //获取活动banner图
		$ObjBanner     =  $FocusSettingModel->get(array('type'=>2,'param_type'=>3,'status'=>1));
		
		//猜价格活动列表
 		$ObjGrouponList = $GrouponActivityModel->query("SELECT g.price_min, g.price_max, g.begin_time, g.end_time, g.status, g.activity_status, g.type, g.banner, g.num, p.id, p.product_name, p.image FROM `groupon_activity` AS g LEFT JOIN product AS p on p.`id` = g.`product_id` WHERE 1=1 AND g.status =1 AND g.type =3 AND g.activity_status !=0 ORDER BY g.sorting DESC,g.create_date DESC ",false,true,$page);
		
 		
        //显示活动倒计时
 		foreach ($ObjGrouponList['DataSet'] as $gro){
 			
 			if($gro !=''){
 			$date 	= DataTip( $gro->end_time, '-' );
 			}
 			$dateTip  			= $date['date_tip'];
 			$seckillTimeDiff 	= $date['date_time'];
 		}
 		
		
		include "tpl/product_guess_price_list_web.php";
}


?>