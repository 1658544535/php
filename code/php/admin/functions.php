<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/14 0014
 * Time: 15:54
 */

//获取微信端当前Menu的配置,默认返回array
function getWechatMenuData($OptionWX, $type = '') {
    $objWechat = new Wechat($OptionWX);
    $result = $objWechat->getMenu();
    foreach ($result as $menus) {
        $result = $menus;
    }
    if ($type) {
        $json = json_encode($result, JSON_UNESCAPED_UNICODE);
        return $json;
    }
    return $result;
}

/*
 * 获取传过来的数组的最后的键值
 */
function getLastArr($array){
    $val = end($array);
    $key = key($array);
    return array('key' => $key, 'val'=>$val);
}

/*
 * 创建创建查询条件部分sql语句  待完成
 * $array = array('要搜索的字段名' => '要搜索的字段的值');
 *
 */
function createConditionSql($array){
    if (!is_array($array)) {
        return false;
    }
    foreach ($array as $k => $v) {
        $sql_condition = ' WHERE ' . $k . '=' . '"' .  $v . '"';
    }
    return $sql_condition;
}

/**
 * 检测提交变量，并返回相应的值
 *
 * @param string $val_name 变量名
 * @param string $default_val 默认值
 * @param string $submit_type 提交方式 （POST|GET|REQUEST）
 */
function CheckDatas( $val_name, $default_val='', $submit_type= 'REQUEST' )
{
    if ( strtoupper($submit_type) == 'POST' )
    {
        $data = isset( $_POST[$val_name] ) ? $_POST[$val_name] : $default_val;
    }
    else if( strtoupper($submit_type) == 'GET' )
    {
        $data = isset( $_GET[$val_name] ) ? $_GET[$val_name] : $default_val;
    }
    else
    {
        $data = isset( $_REQUEST[$val_name] ) ? $_REQUEST[$val_name] : $default_val;
    }

    return $data;
}

/*
 * AJAX返回信息
 */
function ajaxReturn($status, $info, $data = array()){
    $haha = array('status'=>$status, 'info'=>$info, 'data'=>$data);
    echo json_encode($haha);
    exit();
}

