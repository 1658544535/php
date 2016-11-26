<?php
define('HN1', true);
require_once('./global.php');

$act            = CheckDatas( 'act', 'info' );
$pId   	        = CheckDatas( 'pid', '' );
$aId   	        = CheckDatas( 'aid', '' );
$uId   	        = CheckDatas( 'uid', '' );
$Type  	        = CheckDatas( 'type', 1 );
$attId  	    = CheckDatas( 'attId', '' );
$Content 		= CheckDatas( 'content', '' );
// $page           = max(1, intval($_POST['page']));

$backUrl = getPrevUrl();

define('IMAGE_UPLOAD_DIR', SCRIPT_ROOT.'upfiles/activityProductComment/');
define('IMAGE_UPLOAD_URL', 'upfiles/activityProductComment/');

//获取分享信息
$fx = apiData('getShareContentApi.do', array('id'=>18, 'type'=>18));
$fx = $fx["result"];


switch($act)
{
	case 'detail':
		//获取猜你喜欢数据
		$LikeList = apiData('guessYourLikeApi.do', array('activityId'=>$aId,'userId'=>$userid));
		$LikeList = $LikeList['result'];
		include_once('tpl/lottery_detail_web.php');
	    break;
    
    case 'comment_list':
    	//获取用户评论列表数据
    	$LotteryCommentList = apiData('getDrawCommentDetailsApi.do', array('activityId'=>$aId,'pageNo'=>$page));
    	$LotteryCommentList = $LotteryCommentList['result'];
    	include_once('tpl/lottery_comment_list_web.php');
    	break;
    
    case 'comment':
     	//提交评论页面
   	    $proImage   	    = CheckDatas( 'proimage', '' );
   	    $proName   	        = CheckDatas( 'proname', '' );
   	    
   	    include_once('tpl/lottery_comment_web.php');
    	break;
    case 'comment_save':
    	//提交评论操作
    	$attId  	    = CheckDatas( 'attId', '' );
    	$aId   	        = CheckDatas( 'aid', '' );
    	
    	if(IS_POST()){
			set_time_limit(0);
			$apiParam = array();
			$upImgs = $_POST['img'];
			
			$i = 1;
			foreach($upImgs as $v){
				$apiParam['img'.$i] = '@'.IMAGE_UPLOAD_DIR.$v;
				$i++;
			}

			$apiParam['attendId']     = $attId;
			$apiParam['content']      = $Content;
			$apiParam['userId']       = $userid;
			
			$result = apiData('actProductComment.do',$apiParam,'post');
			
			if(empty($_SESSION['backurl_aftersale'])){
				$prevUrl = '/';
			}else{
				$prevUrl = $_SESSION['backurl_aftersale'];
				unset($_SESSION['backurl_aftersale']);
			}
			if($result['success']){
				foreach($upImgs as $v){
					file_exists(IMAGE_UPLOAD_DIR.$v) && unlink(IMAGE_UPLOAD_DIR.$v);
				}
				redirect('lottery_new.php?act=complete&aid='.$aId.'&uid='.$userid, '提交成功');
			}else{
				redirect($backUrl, $result['error_msg']);
			}

		}

		break;
	
		case 'uploadimg'://上传图片
			$upfile = $_FILES['files'];
			($upfile['size'][0] <= 0) && ajaxResponse(false, '请选择图片');
			$allowTypes = array('image/jpg','image/jpeg','image/png','image/pjpeg','image/gif','image/bmp','image/x-png');
			!in_array($upfile['type'][0], $allowTypes) && ajaxResponse(false, '只能上传图片');
			$fileInfo = pathinfo($upfile['name'][0]);
			$userId = intval($_GET['uid']);
			!file_exists(IMAGE_UPLOAD_DIR) && mkdir(IMAGE_UPLOAD_DIR, 0777, true);
			$destFile = $userId.'_'.time().'.'.$fileInfo['extension'];
			if(move_uploaded_file($upfile['tmp_name'][0], IMAGE_UPLOAD_DIR.$destFile)){
				ajaxResponse(true, $destFile, array('url'=>IMAGE_UPLOAD_URL.$destFile));
			}else{
				ajaxResponse(false, '上传失败');
			}
			break;
	
	
	
	
	case 'complete':
		//提交成功后页面
		$aId   	        = CheckDatas( 'aid', '' );
		$LikeList = apiData('guessYourLikeApi.do', array('activityId'=>$aId,'userId'=>$uId));
		$LikeList = $LikeList['result'];
		include_once('tpl/lottery_complete_web.php');
		break;
		
		
    case 'winning':
    	//获取中奖数据
    	$aId 	        = CheckDatas( 'aid', '' );
    	$attId  	    = CheckDatas( 'attId', '' );
    	$Type 	        = CheckDatas( 'type', '' );
    	$winInfo = apiData('prizeDetail.do', array('activityId'=>$aId,'attendId'=>$attId,'activityType'=>$Type));
    	$winInfo = $winInfo['result'];
    	include_once('tpl/lottery_win_web.php');
    	break;

    
    	default:
    		//获取顶部图片数据
    		
    		$Banner = apiData('prizeBannerApi.do');
    		$Banner = $Banner['result'];
    		// $LotteryList = apiData('lotteryListApi.do', array('type'=>$Type));

			$tpl = 'lottery_list_web.php';
    		include_once('tpl/'.$tpl);
   
}



?>