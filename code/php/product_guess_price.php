<?php
define('HN1', true);
require_once('./global.php');

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
$page           = max(1, intval($_POST['page']));
$as             = CheckDatas( 'activity_status', '' );
$Price   	    = CheckDatas( 'price', '' );



switch($act)
{
    case 'detail':
    	//获取活动商品信息
    	$ObjGrouponInfo = apiData('readyJoinApi.do', array('activityId'=>$gId,'userId'=>$userid));
    	$ObjUser = apiData('myInfoApi.do', array('userId'=>$userid));


        $isPrize = ($ObjGrouponInfo["result"][isPublic] == 1) ? true : false; //猜价格是否开奖

        //获取分享内容
    	$fx = apiData('getShareContentApi.do', array('id'=>$gId, 'type'=>11));
    	$fx = $fx['result'];
    	
    	//获取轮播图

    	$ProductImage = apiData('productFocusImagsApi.do', array('productId'=>$ObjGrouponInfo['result']['productId']));
    	
    	//显示活动倒计时
//     	$date 	= DataTip( $ObjGrouponInfo['result']['endTime'], '-' );

//     	$dateTip  			= $date['date_tip'];
//     	$seckillTimeDiff 	= $date['date_time'];

    	$seckillTimeDiff        = strtotime($ObjGrouponInfo['result']['endTime']) - strtotime($ObjGrouponInfo['result']['nowTime']);
    	               	
    	//获取产品详情
    	$content = apiData('getProductInfoView.do', array('id'=>$productId));
    
    	//获取产品详情图
    	$ProductImagesModel = M('product_images');
    	$imageList 	= $ProductImagesModel->getAll( array('product_id'=>$productId, 'status'=>1), 'images', '`Sorting` ASC');

        //获取参与人信息(进行中)
	    $ObjUserList    = apiData('userJoinInfoApi.do', array('activityId'=>$gId,'pageNo'=>$page,'pageSize'=>5));
	 	    
		//统计得奖人数
	    $ObjPrizeList = apiData('guessWinListApi.do', array('activityId'=>$gId));

		//sku
		$skus = array();
		if(($ObjGrouponInfo['result']['isJoin'] == 1) && ($ObjGrouponInfo['result']['isPublic'] == 1) && ($ObjGrouponInfo['result']['isWin'] == 1) && ($ObjGrouponInfo['result']['isStart'] == 2) && ($ObjGrouponInfo['result']['prize'] == 1) && ($ObjGrouponInfo['result']['isRecCoupon'] == 0)){
			$skus = apiData('getProductSkus.do', array('pid'=>$ObjGrouponInfo['result']['productId']));
			$skus = $skus['success'] ? $skus['result'] : array();
		}
	
		include "tpl/product_guess_price_detail_web.php";
	break;
	
	case 'detail_save':
	  
	    

		
	//提交猜价价格
		$ObjPrice = apiData('guessPriceApi.do', array('activityId'=>$gId,'price'=>$Price,'userId'=>$userid));

		if($ObjPrice !=null)
		{
		   echo	ajaxJson('1','提交成功',$ObjPrice);
		}
		else
		{
		   echo ajaxJson('0','提交失败');
		}
		
	
    break;
	
    case 'user':
    	//获取更多用户参与信息数据

     	$num            = apiData('userJoinInfoApi.do', array('activityId'=>$gId,'pageNo'=>$page,'pageSize'=>20));
     	$footerNavActive = 'guess';
    	include "tpl/product_guess_price_user_web.php";
    break;
    
    
    
    
    case 'prize':
    	//获取更多中奖用户信息数据
    	
    	
    	$num            = apiData('readyJoinApi.do', array('activityId'=>$gId,'userId'=>$userid));

    	$footerNavActive = 'guess';
    	include "tpl/product_guess_price_prize_web.php";
    	break;
      
    case 'popup':
        //获奖弹窗
        $popup            = apiData('callGuessCouponAlertApi.do', array('activityId'=>$gId,'userId'=>$userid));

        break;  
    
    
    
    
//     case 'user_price':
//     	//获取个人参加猜价活动数据
//     	$UserPriceList = $GrouponUserRecordModel->query("SELECT gu.user_id, gu.status, gu.prize, gu.attend_time, gu.price, g.product_id, g.activity_status, p.product_name, p.image FROM `groupon_user_record` AS gu LEFT JOIN `groupon_activity` AS g on gu.`activity_id` = g.`id` LEFT JOIN `product` AS p on g.`product_id` = p.`id` WHERE 1=1 AND gu.activity_type =3   AND gu.id = '".$uId."' AND gu.prize = '".$Prize."' AND g.activity_status = '".$as."' ORDER BY gu.create_date DESC ",false,true,$page);
    
    	
    	
//     	include "tpl/product_guess_price_user.php";
//     	break;
    
    
    
    
	default:
      
        //获取活动banner图
		$ObjBanner = apiData('guessBannerApi.do');
		$ObjGrouponList = apiData('guessActivityApi.do', array('pageNo'=>1));
		
		//获取分享内容
		$fx = apiData('getShareContentApi.do', array('id'=>10, 'type'=>10));
		$fx = $fx['result'];
		$footerNavActive = 'guess';
		include "tpl/product_guess_price_list_web.php";
}


?>