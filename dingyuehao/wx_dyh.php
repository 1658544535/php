<?php
/**
 * 此文件用于订阅号
 */
define('HN1', true);
error_reporting(0);
header("content-type: text/html; charset=utf-8");
session_start();
date_default_timezone_set('Asia/Shanghai'); 							// 设置默认时区

define('DING_YUE_HAO', dirname(__FILE__).'/');
define('SYS_ROOT', DING_YUE_HAO.'../');
define('APP_INC', SYS_ROOT.'includes/inc/');
define('LIB_ROOT', SYS_ROOT.'includes/lib/');
define('LOG_INC', SYS_ROOT.'logs/');

include_once(APP_INC.'config.php');
include_once(APP_INC.'functions.php');

//微信相关配置信息(用于微信类)
$wxOption = array(
    'appid' => '',// 'wxf22334936bd11aa7',//更新到正式时启用此appid
    'appsecret' => '264db318e2af00dfc7d20503f18e4117',
    'token' => 'pindehaowx',
    'encodingaeskey' => 'ZhZsBgwdt4sFjhkgfxJmnGDOo8DbdFAiAOjXAiPUE2m',
);

include_once(LIB_ROOT.'/Weixin.class.php');
include_once(LIB_ROOT.'/weixin/errCode.php');
$objWX = new Weixin($wxOption);

$objWX->valid();
$wxReqType = $objWX->getRev()->getRevType();

switch($wxReqType){
	case Wechat::MSGTYPE_TEXT://文本
		$content = $objWX->getRevContent();
		break;
	case Wechat::MSGTYPE_EVENT://事件
		$eventType = $objWX->getRevEvent();
		switch($eventType['key']){
			case 'vcode':
				$text = getInviteCode($objWX->getRevFrom());
				$objWX->text($text)->reply();
				break;
			case 'contact':
				$text = "活动咨询，反馈建议以及投诉等问题，您可以直接微信上联系我们。\r\n——开放时间：8:30~17:30（其他时间段直接留言，看到后会立马回复）";
				$objWX->text($text)->reply();
				break;
		}
		break;
	default:
		$objWX->transfer_customer_service()->reply();
		break;
}

/**
 * 获取邀请码
 *
 * @param string $openid
 * @return string
 */
function getInviteCode($openid){
	$result = '';
	$have = false;
	$unbindList = array();
	$result = '本批次邀请码已发送完毕，请及时联系客服！';
	$dataFile = DING_YUE_HAO.'data/dingyuehao_invite_code.php';
	$vcodes = include_once($dataFile);
	foreach($vcodes as $_code => $val){
		if($val['openid'] == $openid){
			$have = true;
			$result = '亲，这是您的邀请码：'.$val['vcode'];
			break;
		}
		if(empty($val['openid'])){
			$unbindList[$_code] = $val;
		}
	}

	if(!$have && !empty($unbindList)){
		$vcodeInfo = array_shift($unbindList);
		$result = '亲，这是您的邀请码：'.$vcodeInfo['vcode'];
		$vcodes[$vcodeInfo['vcode']]['openid'] = $openid;
	}
	file_put_contents($dataFile, "<?php\r\nreturn ".var_export($vcodes, true).";\r\n?>", LOCK_EX);
	return $result;
}
?>