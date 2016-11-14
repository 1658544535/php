<?php
/**
 * Created by PhpStorm.
 * User: Jasper
 * Date: 2016/11/11 0011
 * Time: 11:53
 */
define('USER_TOKEN', 'HAHAHA'); //自定义认证token
include_once('wx_option.php');

$token = (isset($_GET['token'])) ? $_GET['token'] : '';

//验证
if ($token !== USER_TOKEN) {
    echo json_encode(array('status'=>0,'info'=>'验证失败'));
    exit;
} else {
    $CreateNewMenu_JSON = file_get_contents($localMenu_file);
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