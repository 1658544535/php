<?php
/**
 * Created by PhpStorm.
 * User: Jasper
 * Date: 2016/11/11 0011
 * Time: 11:53
 */

define('HN1', true);
define('LIB_ROOT', '../includes/lib/');
define('DATA_DIR', dirname(__FILE__) . '/data/'); //数据保存的位置
define('USER_TOKEN', 'HAHAHA'); //自定义认证token

include_once(LIB_ROOT.'Weixin.class.php');
include_once(LIB_ROOT.'weixin/errCode.php');

$createMenu_file = "CreateMenu.json"; //保存的新建菜单JSON数组
$localMenu_file  = "LocalMenu.json"; //本地尚未同步至微信的json数组
$saveMenu_file   = "SaveMenu.json"; //保存已经创建的数组=> 通过getMenu()方法获取的数组

$token = (isset($_GET['token'])) ? $_GET['token'] : '';

//验证
if ($token !== USER_TOKEN) {

    echo json_encode(array('status'=>0,'info'=>'验证失败'));
    exit;

} else {

    $OptionWX = array(
        'token'=>'weixin', //填写你设定的key
        'encodingaeskey'=> '', //填写加密用的EncodingAESKey
        'appid'=>'wx3eea553d8ab21caa', //填写高级调用功能的app id
        'appsecret'=>'8a8eaaeda77febffb186e26e42572df6' //填写高级调用功能的密钥
    );

    $CreateNewMenu_JSON = file_get_contents(DATA_DIR . $createMenu_file);
    $CreateNewMenu      = json_decode($CreateNewMenu_JSON, true);

    $objWechat = new Wechat($OptionWX);

    if ($objWechat->createMenu($CreateNewMenu)) {
        echo json_encode(array('status'=>1,'info'=>'修改成功'));
    } else {
        echo json_encode(array(
            'status'  => 0,
            'errCode' => $objWechat->errCode,
            'errMsg'  => $objWechat->errMsg,
        ));
    }

}

?>