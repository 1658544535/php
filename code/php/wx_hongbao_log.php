<?php
define('HN1', true);
require_once('./global.php');
error_reporting(0);

$time = time();

//虚拟数量
$num = 200;

//时间范围开始
$timeStart = 3600 * 4;
$timeRange = range($time-$timeStart, $time);

//金额选项
$moneys = array('1.0', '1.6', '2.0', '5.0', '99');

//手机范围
$mRange = array();
$mPreRange = array();
$mPre = array(131, 135, 138, 136, 137, 151, 152, 157, 159, 158, 186, 188);
foreach($mPre as $v){
	for($i=0; $i<10; $i++){
		$mPreRange[] = $v.$i;
	}
}
$mExtRange = range(0, 999);

shuffle($timeRange);
shuffle($mRange);
shuffle($mExtRange);
$timeRangeShow = array_slice($timeRange, 0, $num);
$mRangeShow = array_slice($mRange, 0, $num);
$mExtRangeShow = array_slice($mExtRange, 0, $num);

$mdlLog = M('wxhb_receive_log');
$realNum = $mdlLog->getCount();
$showNum = $realNum+$num;

$list = array();
foreach($timeRangeShow as $k => $v){
	$_mIndex = array_rand($moneys);
	$_mbpIndex = array_rand($mPreRange);
	$_mbe = $mExtRangeShow[$k];
	if($_mbe < 10){
		$_mbe = '00'.$_mbe;
	}elseif($_mbe < 100){
		$_mbe = '0'.$_mbe;
	}
	$list[$v] = array(
		'time' => $v,
		'timestr' => date('m-d H:i', $v),
		'name' => $mPreRange[$_mbpIndex].'****'.$_mbe,
		'money' => $moneys[$_mIndex],
	);
}
asort($list);
PD($list);

include "tpl/wx_hongbao_log_web.php";
?>