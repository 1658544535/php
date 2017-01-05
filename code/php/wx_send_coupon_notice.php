<?php
/**
 * 发送优惠券通知(0.1中奖特定场景)
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

define('URL_BASE', 'wx_send_coupon_notice.php');
define('DATA_FILE_DIR', DATA_ROOT.'wx/msgtpl/coupon/');
define('DATA_FILE_NAME', 'namelist.php');
!file_exists(DATA_FILE_DIR) && mkdir(DATA_FILE_DIR, 0777, true);

$time = time();

//测试版本
$isDemo =  in_array($_SERVER['SERVER_NAME'], array('weixin.pindegood.com')) ? false : true;
$tplId = $isDemo ? 'GOkZqfwhyVqTBgN7qmz59UBB0RcvhhK5CxoFygXc9E4' : 'dnWDGB0xKlv8wPosfcgQjsb9qhmjo8FTILKxwkdDYjA';

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
			$csvColOpenidIndex = intval($_POST['col_openid'])-1;
			$csvColCpnNoIndex = intval($_POST['col_cpnno'])-1;
			$csvColCpnNameIndex = intval($_POST['col_cpnname'])-1;
			$csvColProductNameIndex = intval($_POST['col_proname'])-1;
			$csvColValidStartIndex = intval($_POST['col_validstart'])-1;
			$csvColValidEndIndex = intval($_POST['col_validend'])-1;

			$data = array();
			$csvFile = fopen($filepath, 'r');
			$i = 0;
			while($row = fgetcsv($csvFile)){
				if($i >= $csvRowStartIndex){
					$data[] = array(
						'openid' => $row[$csvColOpenidIndex],
						'cpn_no' => $row[$csvColCpnNoIndex],
						'cpn_name' => iconv('gbk', 'utf8', $row[$csvColCpnNameIndex]),
						'product_name' => iconv('gbk', 'utf8', $row[$csvColProductNameIndex]),
						'valid_start' => $row[$csvColValidStartIndex],
						'valid_end' => $row[$csvColValidEndIndex],
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

		$_logDir = LOG_INC.'msgtpl/coupon/';
		!file_exists($_logDir) && mkdir($_logDir, 0777, true);
		$_logFile = $_logDir.'coupon_'.date('Y-m-d', $time).'.txt';
		
		$newData = array_chunk($data, $persize);
		$sendData = $newData[$page-1];
		$tpl = array(
			'template_id' => $tplId,
			'url' => $site.'user_info.php?act=coupon',
			'topcolor' => '#000000',
			'data' => array(
				'first' => array(
					'color' => '#000000',
				),
				'keyword1' => array(
					'color' => '#000000',
				),
				'keyword2' => array(
					'color' => '#000000',
				),
				'keyword3' => array(
					'value' => 1,
					'color' => '#000000',
				),
				'keyword4' => array(
					'color' => '#000000',
				),
				'keyword5' => array(
					'value' => '全平台',
					'color' => '#000000',
				),
				'remark' => array(
					'value' => '年货礼包券后价低至15元，马上带回家 >>>',
					'color' => '#ff0000',
				),
			),
		);
		foreach($sendData as $v){
			$tpl['touser'] = $v['openid'];
			$tpl['data']['first']['value'] = '亲，您的新年礼券【'.$v['cpn_name'].'】已送达！';
			$tpl['data']['keyword1']['value'] = '优惠券号'.$v['cpn_no'];
			$tpl['data']['keyword2']['value'] = empty($v['product_name']) ? '全品类商品' : $v['product_name'];
			$tpl['data']['keyword4']['value'] = $v['valid_start'].'至'.$v['valid_end'];
			$sendResult = $objWX->sendTemplateMessage($tpl);
			if($sendResult === false){
				$_logInfo = "【".date('Y-m-d H:i:s', $time)."】优惠券通知发送失败，openid：{$v['openid']}，优惠券：{$v['cpn_name']} [{$v['cpn_no']}]，有效期：{$tpl['data']['keyword4']['value']}，兑换商品：{$tpl['data']['keyword2']['value']}，失败信息：".$objWX->errMsg."【".$objWX->errCode."】\r\n";
			}else{
				$_logInfo = "【".date('Y-m-d H:i:s', $time)."】优惠券通知发送成功，openid：{$v['openid']}，优惠券：{$v['cpn_name']} [{$v['cpn_no']}]，有效期：{$tpl['data']['keyword4']['value']}，兑换商品：{$tpl['data']['keyword2']['value']}\r\n";
			}
			file_put_contents($_logFile, $_logInfo, FILE_APPEND);
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
					openid所在列序号：<input type="text" name="col_openid" value="2" />
				</div>
				<div>
					优惠券编号所在列序号：<input type="text" name="col_cpnno" value="4" />
				</div>
				<div>
					优惠券名称所在列序号：<input type="text" name="col_cpnname" value="5" />
				</div>
				<div>
					有效开始所在列序号：<input type="text" name="col_validstart" value="6" />
				</div>
				<div>
					有效结束所在列序号：<input type="text" name="col_validend" value="7" />
				</div>
				<div>
					兑换产品名所在列序号：<input type="text" name="col_proname" value="3" />
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