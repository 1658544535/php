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
        	echo ajaxJson( 1,'获取成功',$ObjUserList['result']['joinUserList'],$page);
        }
        else
        {
        	echo ajaxJson( 0,'获取失败');

        }
    	break;

    case 'prize':
    	//获取更多中奖用户信息数据
    	$ObjPrizeList    = apiData('winListApi.do', array('activityId'=>$gId,'pageNo'=>$page,'prize'=>$Prize));

        if($ObjPrizeList !='')
        {
        	echo ajaxJson( 1,'获取成功',$ObjPrizeList['result']['prizeList'],$page);
        }
        else
        {
        	echo ajaxJson( 0,'获取失败');
        }
    	break;

    default:
	    //往期活动列表
	    $ObjGrouponList = apiData('guessBeforeActivityApi.do', array('pageNo'=>$page));
		$Data =array(
		    'data'=>$ObjGrouponList['result'],
        );

        if ($ObjGrouponList !='') {
            echo get_json_data_public( 1,'获取成功',$Data ,$page);
        } else {
            echo get_json_data_public( 0,'获取失败' );
        }

}


?>