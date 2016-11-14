<?php
/**
 * Created by PhpStorm.
 * User: Jasper
 * Date: 2016/11/12 0012
 * Time: 9:49
 */
define('HN1', true);
define('LIB_ROOT', '../includes/lib/');
//define('DATA_DIR', dirname(__FILE__) . '/data/'); //数据保存的位置
define('DATA_DIR', '../data/wx/'); //数据保存的位置

include_once(LIB_ROOT.'Weixin.class.php');
include_once(LIB_ROOT.'weixin/errCode.php');

$OptionWX = array(
    'token'=>'weixin', //填写你设定的key
    'encodingaeskey'=> '', //填写加密用的EncodingAESKey
    'appid'=>'wx3eea553d8ab21caa', //填写高级调用功能的app id
    'appsecret'=>'8a8eaaeda77febffb186e26e42572df6' //填写高级调用功能的密钥
);

$createMenu_file = DATA_DIR . 'CreateMenu.json'; //保存的新建菜单JSON数组
$localMenu_file  = DATA_DIR . 'LocalMenu.json'; //本地尚未同步至微信的json数组
$saveMenu_file   = DATA_DIR . 'SaveMenu.json'; //保存已经创建的数组=> 通过getMenu()方法获取的数组
