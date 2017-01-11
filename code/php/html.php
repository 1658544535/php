<?php
/**
 * 生成html
 */
define('HN1', true);
error_reporting(0);
header("content-type: text/html; charset=utf-8");
session_start();
date_default_timezone_set('Asia/Shanghai'); 							// 设置默认时区

define('SYS_ROOT', dirname(__FILE__).'/');
define('APP_INC', dirname(__FILE__) . '/includes/inc/');
define('LIB_ROOT', dirname(__FILE__) . '/includes/lib/');
define('LOG_INC', dirname(__FILE__) . '/logs/');

define('API_URL', 'http://app.pindegood.com/v3.6');
//define('API_URL', 'http://pin.taozhuma.com/v3.6');

$siteUrl = 'http://weixin.pindegood.com/';
//$siteUrl = 'http://pinwx.taozhuma.com/';

include_once(APP_INC.'config.php');
include_once(APP_INC.'functions.php');

$saveDir = SYS_ROOT;//.'html/';
//!file_exists($saveDir) && mkdir($saveDir, 0777, true);
$file = $saveDir.'index.html';

$url = $siteUrl.'index.php?neibu_qy=1';

echo '开始获取页面信息<br />';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, 'MicroMessenger');
$html = curl_exec($ch);
curl_close($ch);

echo '信息获取完毕<br />';
file_put_contents($file, $html);
echo '静态文件生成完成';
?>