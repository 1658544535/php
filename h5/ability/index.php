<?php
define('HN1', true);
define('DEBUG_TEST', false);
define('CURRENT_ROOT', dirname(__FILE__).'/');
require_once(CURRENT_ROOT.'../h5_global.php');

//本地开发配置
$__devCfg = CURRENT_ROOT.'local_dev_config.php';
file_exists($__devCfg) && include_once($__devCfg);

define('CURRENT_TPL_DIR', CURRENT_ROOT.'tpl/');

define('__CURRENT_ROOT_URL__', $site.'h5/ability');
define('__CURRENT_TPL_URL__', $site.'h5/ability/tpl');

define('SESS_K_USER', 'h5User');
define('SESS_K_STEP', 'step');
define('SESS_K_PARTIN', 'partinInfo');
define('SESS_K_JOIN', 'join');

//微信相关配置信息(用于微信类)
$wxOption = array(
	'appid' => $app_info['appid'],
	'appsecret' => $app_info['secret'],
	'token' => isset($app_info['token']) ? $app_info['token'] : 'weixin',
	'encodingaeskey' => isset($app_info['encodingaeskey']) ? $app_info['encodingaeskey'] : '',
);

//微信对象
include_once(SYSTEM_LIB.'/Weixin.class.php');
include_once(SYSTEM_LIB.'/weixin/errCode.php');
$gObjWX = new Weixin($wxOption);

require_once(CURRENT_ROOT.'wxlogin.php');

$gOptions = include_once(CURRENT_ROOT.'option.php');

$gCurTime = time();

$act = trim($_GET['act']);

switch($act){
	case 're'://重测
		$act = '1';
		$objStatus = M('h5_ability_opstatus');
		$opstatus = $objStatus->get(array('user_id'=>$_SESSION[SESS_K_USER]['id']));
		if(empty($opstatus)){
			$objStatus->add(array('user_id'=>$_SESSION[SESS_K_USER]['id'], 'restart'=>1));
		}else {
			$objStatus->modify(array('restart' => 1), array('user_id' => $_SESSION[SESS_K_USER]['id']));
		}
		unset($_SESSION[SESS_K_STEP], $_SESSION[SESS_K_PARTIN]);
		break;
	case 'goods'://点击浏览商品
		include_once(CURRENT_ROOT.'goods.php');
		exit();
		break;
	default:
		//判断是否重测
		$objStatus = M('h5_ability_opstatus');
		$restatus = $objStatus->get(array('user_id'=>$_SESSION[SESS_K_USER]['id']), '*', ARRAY_A);
		if($restatus['restart'] && (!isset($_SESSION[SESS_K_JOIN]) || !$_SESSION[SESS_K_JOIN])){
			$act = 1;
		}else{
			if(isset($_SESSION[SESS_K_JOIN]) && $_SESSION[SESS_K_JOIN]){
				$partin = array();
			}else{//进入判断是否有测试过
				$objPartin = M('h5_ability_partin');
				$partin = $objPartin->get(array('user_id' => $_SESSION[SESS_K_USER]['id']));
			}
			if(empty($partin)){
				$acts = array('1', '2', '3');
				!in_array($act, $acts) && $act = '1';
			}else{
				$act = '3';
			}
		}
		break;
}

switch($act){
	case '2'://步骤2
		include_once(CURRENT_ROOT.'step2.php');
		break;
	case '3'://步骤3
		include_once(CURRENT_ROOT.'step3.php');
		break;
	default://步骤1
		include_once(CURRENT_ROOT.'step1.php');
		break;
}