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
        $json = json_encode_custom($result);
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

/**
 * 对变量进行 JSON 编码
 * @param mixed value 待编码的 value ，除了resource 类型之外，可以为任何数据类型，该函数只能接受 UTF-8 编码的数据
 * @return string 返回 value 值的 JSON 形式
 */
function json_encode_custom($value)
{
    if (version_compare(PHP_VERSION,'5.4.0','<'))
    {
        $str = json_encode($value);
        $str = preg_replace_callback(
            "#\\\u([0-9a-f]{4})#i",
            function($matchs)
            {
                return iconv('UCS-2BE', 'UTF-8', pack('H4', $matchs[1]));
            },
            $str
        );
        return $str;
    }
    else
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
