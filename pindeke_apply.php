<?php
define('HN1', true);
require_once('./global.php');

$act = CheckDatas('act', '');
$Name 		            = CheckDatas( 'name', '' );
$Phone		            = CheckDatas( 'phone', '' );
$cardNo 		        = CheckDatas( 'cardNo', '' );
$Content 		        = CheckDatas( 'content', '' );
$minfo                  = CheckDatas( 'minfo', '' );
//判断是否登录
IS_USER_LOGIN();

$backUrl = getPrevUrl();

define('IMAGE_UPLOAD_DIR', SCRIPT_ROOT.'upfiles/userpindeke/');
define('IMAGE_UPLOAD_URL', 'upfiles/userpindeke/');

switch($act){
	case 'apply'://申请
		if(IS_POST()){
			$minfo  = CheckDatas( 'minfo', '' );
			set_time_limit(0);
			$apiParam = array();
			$upImgs = $_POST['img'];
			$i = 1;
			foreach($upImgs as $v){
				$apiParam['image'.$i] = '@'.IMAGE_UPLOAD_DIR.$v;
				$i++;
			}
			
// 			$apiParam['cardNo']     = $cardNo;
			$apiParam['extChannel'] = $Content;
			$apiParam['name']       = $Name;
			$apiParam['userId']     = $userid;
			$apiParam['phone']      = $Phone;
			$apiParam['code']       = $minfo;
			
			$result  = apiData('pdkApplyApi.do',$apiParam,'post');
			
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
				redirect('pindeke.php?act=pdkInfo&uid='.$userid, '提交成功');
			}else{
				redirect($backUrl, $result['error_msg']);
			}

		}

		break;
		
		
		case 'edit'://修改
			$Uid = intval($_GET['uid']);
			$minfo = CheckDatas( 'minfo', '' );
			$infoEdit = apiData('pdkApplyInfoApi.do',array('userId'=>$Uid));
			$infoEdit = $infoEdit['result'];
			include_once('tpl/pdk_apply_edit_web.php');
			break;
		
		case 'edit_save'://修改
        
	     $Uid = intval($_GET['uid']);
	     $Id  = intval($_GET['id']);
	     $minfo = CheckDatas( 'minfo', '' );
	  
			if(IS_POST()){
					set_time_limit(0);
					$apiParam = array();
					$upImgs = $_POST['img'];
					$i = 1;
					foreach($upImgs as $v){
						$apiParam['imgName'.$i] = $v;
						$i++;
					}
					
// 					$apiParam['cardNo']     = $cardNo;
					$apiParam['extChannel'] = $Content;
					$apiParam['name']       = $Name;
					$apiParam['userId']     = $userid;
					$apiParam['id']         = $Id;
					$apiParam['phone']      = $Phone;
					$apiParam['code']       = $minfo;
					$result = apiData('pdkUpdateApi.do',$apiParam,'post');

			
			if(empty($_SESSION['backurl_aftersale'])){
				$prevUrl = '/';
			}else{
				$prevUrl = $_SESSION['backurl_aftersale'];
				unset($_SESSION['backurl_aftersale']);
			}
			if($result['success']){
				redirect('pindeke.php?act=pdkInfo&uid='.$userid, '提交成功');
			}else{
				redirect($backUrl, $result['error_msg']);
			}

		}
			break;
			
			
			
			
			
			case 'uploadimg_edit'://信息修改上传图片
				    $upfile = $_FILES['files'];
				    ($upfile['size'][0] <= 0) && ajaxResponse(false, '请选择图片');
					$allowTypes = array('image/jpg','image/jpeg','image/png','image/pjpeg','image/gif','image/bmp','image/x-png');
					!in_array($upfile['type'][0], $allowTypes) && ajaxResponse(false, '只能上传图片');
					$fileInfo = pathinfo($upfile['name'][0]);
					$userId = intval($_GET['uid']);
					!file_exists(IMAGE_UPLOAD_DIR) && mkdir(IMAGE_UPLOAD_DIR, 0777, true);
					$destFile = $userId.'_'.time().'.'.$fileInfo['extension'];
					$result = apiData('upUserpindekeImage.do',array('file'=>'@'.$upfile['tmp_name'][0]),'post');
					if($result['result'] !=''){
						ajaxResponse(true, $result['result']);
					}else{
						ajaxResponse(false, $result['error_msg']);
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
					if(move_uploaded_file($upfile['tmp_name'][0],IMAGE_UPLOAD_DIR.$destFile)){
						ajaxResponse(true, $destFile, array('url'=>IMAGE_UPLOAD_URL.$destFile));
					}else{
						ajaxResponse(false, '上传失败');
					}
			break;
			
			case 'binding'://绑定拼得客
				$minfo  = CheckDatas( 'minfo', '' );
				$bindinginfo = apiData('registerPdkByInvitCode.do',array('code'=>$minfo,'userId'=>$userid));
				if($bindinginfo['result']['status'] !=0){
					redirect('pindeke_apply.php?minfo='.$minfo, $bindinginfo['error_msg']);
				}else{
					redirect('index.php', $bindinginfo['error_msg']);
				}
				
				break;
			
			default:
					$info = apiData('pdkApplyInfoApi.do',array('userId'=>$userid));
					   if(!empty($info['result']))
					   {
							if($info['result']['status'] ==1)
							{
								redirect('pindeke.php?act=mission');
							}
							elseif($info['result']['status'] ==0 || $info['result']['status'] ==3 || $info['result']['status'] ==2)
							{
								redirect('pindeke.php?act=pdkInfo&uid='.$userid.'&minfo='.$minfo);
							}
							
					   } 
						include_once('tpl/pdk_apply_web.php');
				   break;
}





?>