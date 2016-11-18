<?php 
define('HN1', true);
require_once('./global.php');
$act  = CheckDatas( 'act', 'info' );


switch($act)
{
	case 'plan1':
		//方案一 定时访问
		if(!$_GET['timed']) exit();
		set_time_limit(0);//无限请求超时时间
		while (true){
			sleep(3);
// 			usleep(500000);//0.5秒
			$msg = apiData('getGrouponPushApi.do', array('num'=>10,'pageSize'=>1));
			//若得到数据则马上返回数据给客服端，并结束本次请求
			if($msg['success'] ==1){
				$msg = $msg['result'];
				echo json_encode($msg);
				exit();
			}else{
				sleep(13);
				exit();
			}
		
			
		}
		break;
		case 'plan2':
			
			$msg = apiData('getGrouponPushApi.do', array('num'=>3600,'pageSize'=>10));
			$msg = $msg['result'];
			if(empty($msg['success'])){
			  echo	ajaxJson( 1,'获取成功',$msg);
			}else{
			  echo	ajaxJson( 0,'',$msg['error_msg']);
			}
			break;
}
			include_once('tpl/header_web.php');
?>




























