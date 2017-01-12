<?php
  /**
   * 发送邀请码通知(0.1抽奖)
  */
  define('HN1', true);
  error_reporting(0);
  header("content-type: text/html; charset=utf-8");
  session_start();
  date_default_timezone_set('Asia/Shanghai');// 设置默认时区
  
  define('SYS_ROOT', dirname(__FILE__).'/');
  define('APP_INC', dirname(__FILE__) . '/includes/inc/');
  define('LIB_ROOT', dirname(__FILE__) . '/includes/lib/');
  define('LOG_INC', dirname(__FILE__) . '/logs/');
  define('DATA_ROOT', dirname(__FILE__).'/data/');
  
  include_once(APP_INC.'config.php');
  include_once(APP_INC.'functions.php');
  
  //微信相关配置信息(用于微信类)
  $wxOption = array(
  		'appid' => $app_info['appid'],
  		'appsecret' => $app_info['secret'],
  		'token' => $app_info['token'] ? $app_info['token'] : 'weixin',
  		'encodingaeskey' => $app_info['encodingaeskey'] ? $app_info['encodingaeskey'] : '',
  );

  include_once(LIB_ROOT.'/Weixin.class.php');
  include_once(LIB_ROOT.'/weixin/errCode.php');
  $objWX = new Weixin($wxOption);
  
  define('URL_BASE', 'wx_msg.php');
  define('DATA_FILE_DIR', DATA_ROOT.'wx/msgtpl/invCode/');
  define('DATA_FILE_NAME', 'namelist.php');
  !file_exists(DATA_FILE_DIR) && mkdir(DATA_FILE_DIR, 0777, true);
  
  $time = time();
  
  
  $act = trim($_GET['act']);
  switch($act){
  	case 'import'://导入名单
  		if($_SERVER['REQUEST_METHOD'] == 'POST'){
  			$file = $_FILES['file'];
  			!$file['size'] && redirect(URL_BASE, '上传失败');
  				
  			$ext = strtolower(substr($file['name'], strrpos($file['name'], '.')+1));
  			($ext != 'csv') && redirect(URL_BASE, '请上传csv文件');
  
  			$fileName = date('Y-m-d_H-i-s', $time).'.csv';
  			$filepath = DATA_FILE_DIR.$fileName;
  			(move_uploaded_file($file['tmp_name'], $filepath) !== true) && redirect(URL_BASE, '上传失败');
  			
  			$csvRowStartIndex = intval($_POST['row_start'])-1;
  			$csvColOpenidIndex = intval($_POST['openid'])-1;
  			$csvColCpnNoIndex  = intval($_POST['invcode'])-1;
  			
  			$data = array();
  			$csvFile = fopen($filepath, 'r');
  			$i = 0;
  			while($row = fgetcsv($csvFile)){
  				if($i >= $csvRowStartIndex){
  					$data[] = array(
  							'openid' => $row[$csvColOpenidIndex],
  							'invcode' => strval($row[$csvColCpnNoIndex]),
  					);
  				}
  				$i++;
  			}
  			fclose($csvFile);
  
  			$dataFile = DATA_FILE_DIR.DATA_FILE_NAME;
  			
  			if(file_put_contents($dataFile, "<?php\r\nreturn ".var_export($data, true).";\r\n?>") === false){
  				echo '上传失败，<a href="'.URL_BASE.'">重新上传</a>';
  			}else{
  				redirect(URL_BASE.'?act=send', '上传成功，现在开始发送');
  			}
  		}else{
  			echo '提交方式有误，<a href="'.URL_BASE.'">重新上传</a>';
  		}
  		break;
  	case 'send'://发送
  		$persize = 50;
  		$page = intval($_GET['p']);
  		$page = max(1, $page);
  
  		$dataFile = DATA_FILE_DIR.DATA_FILE_NAME;
  		if(!file_exists($dataFile)){
  			echo '数据有误，请<a href="'.URL_BASE.'">重新上传</a>';
  			exit();
  		}
  		$data = include($dataFile);
  
  		$_logDir = LOG_INC.'msgtpl/invCode/';
  		!file_exists($_logDir) && mkdir($_logDir, 0777, true);
  		$_logFile = $_logDir.'invCode_'.date('Y-m-d', $time).'.txt';
  
  		$newData = array_chunk($data, $persize);
  	
  		$sendData = $newData[$page-1];
 		
  		foreach ($sendData as $msg){
  				$data = array('touser'=>$msg['openid']);
  				$data['msgtype'] = 'text';
  				$data['text'] = array('content'=>'恭喜您！获得新年红包开团特权，您的开团码为:'.$msg['invcode'].'，<a href="'.$site.'groupon.php?id=8760">点击进行开团吧</a>');
  				$objWX->writeLog('text');
  				$wxmsg = $objWX->sendCustomMessage($data);
  			
  				if($wxmsg === false){
  					$_logInfo = "【".date('Y-m-d H:i:s', $time)."】邀请码通知发送失败，openid:{$msg['openid']}，邀请码:{$msg['invcode']}，失败信息：".$objWX->errMsg."【".$objWX->errCode."】\r\n";
  					file_put_contents($_logFile, $_logInfo, FILE_APPEND);
  				}else{
  					$_logInfo = "【".date('Y-m-d H:i:s', $time)."】邀请码通知发送成功，openid:{$msg['openid']}，邀请码:{$msg['invcode']}\r\n";
  					file_put_contents($_logFile, $_logInfo, FILE_APPEND);
  				}
  			  file_put_contents($_logFile, "\r\n", FILE_APPEND);
  		
  		}
  		
  		echo '<div>共'.count($data).'条数据</div>';
  		if($page == count($newData)){
  			echo '<div>已发送：'.count($data).'</div>';
  			echo '发送完成';
  			@unlink($dataFile);
  		}else{
  			echo '<div>已发送：'.($page*$persize).'</div>';
  			echo '<script>location.href="/'.URL_BASE.'?act=send&p='.($page+1).'"</script>';
  		}
  
  		break;
  	default://上传界面
  		$curUrl = URL_BASE;
  		echo <<<EOF
		<form action="{$curUrl}?act=import" method="post" enctype="multipart/form-data">
			<fieldset>
				<legend>上传数据文件(csv文件)</legend>
				<div>
					<input type="file" name="file" />
				</div>
				<div>
					开始的行数：<input type="text" name="row_start" value="2" />
				</div>
				<div>
					openid所在列序号：<input type="text" name="openid" value="1" />
				</div>
				<div>
					邀请码所在列序号：<input type="text" name="invcode" value="2" />
				</div>
				<div>
					<input type="submit" name="btn" value="上传" />
				</div>
			</fieldset>
		</form>
EOF;
  		break;
  }
  
  
?>