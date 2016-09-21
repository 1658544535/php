<?php
/**
 * “我的朋友圈”游戏
 */
$isTest = false;
define('HN1', true);
define('MODULE_ROOT', dirname(__FILE__).'/');
$proRoot = realpath(MODULE_ROOT.'/../../').'/';
define('PROJECT_ROOT', $proRoot);
define('SCRIPT_ROOT',  $proRoot);
define('LOG_INC', PROJECT_ROOT.'logs/');
define('INC_DIR', PROJECT_ROOT.'includes/inc/');
define('FUNC_DIR', PROJECT_ROOT.'includes/func/');
define('APP_INC', INC_DIR);
define('LOGIC_ROOT', PROJECT_ROOT.'logic/');

include_once(APP_INC . 'ez_sql_core.php');
include_once(APP_INC . 'ez_sql_mysql.php');
include_once(INC_DIR . 'wxjssdk.php');
include_once(INC_DIR.'config.php');
include_once(FUNC_DIR.'cls_weixin.php');
include_once(LOGIC_ROOT.'comBean.php');

$db = new ezSQL_mysql($dbUser, $dbPass, $dbName, $dbHost);
$db->query('SET character_set_connection=' . $dbCharset . ', character_set_results=' . $dbCharset . ', character_set_client=binary');
$objCom = new comBean($db, 'wx_user');

$token = 'weixin';//'mytest';//;
$encodingaeskey = 'XstjRTMLoHPM8ZffmPnugItMJgkzxtrjFheycUd7sGo';
$wxOpt = array(
    'token' => $token,
    'appid' => $app_info['appid'],
    'appsecret' => $app_info['secret'],
    'encodingaeskey' => $encodingaeskey,
);
$objWX = new Weixin($wxOpt);

if(isset($_GET['uid']) && trim($_GET['uid'])){//由他人分享链接进来
    $openid = trim($_GET['uid']);
    $wxUser = $objCom->get(array('openid'=>$openid), '*', ARRAY_A);// $objWX->getUserInfo($openid);
}elseif(isset($_GET['self']) && intval($_GET['self'])) {//自己玩(授权)
    header('location:'.$objWX->getOauthRedirect($site.'game/friend', 'tzmgf123'));
    exit();
}elseif(isset($_GET['state'])){//自己玩(信息)
    $oauthAccessToken = $objWX->getOauthAccessToken();
    $wxUser = $objCom->get(array('openid'=>$oauthAccessToken['openid']), '*', ARRAY_A);
    if(empty($wxUser)){
        $wxUser = $objWX->getOauthUserinfo($oauthAccessToken['access_token'], $oauthAccessToken['openid']);
        $wxUser['privilege'] = json_encode($wxUser['privilege']);
        unset($wxUser['language']);
        $objCom->create($wxUser);
    }
}

include('./tpl/index.php');
?>