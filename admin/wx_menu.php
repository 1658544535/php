<?php
/**
 * Created by PhpStorm.
 * User: Jasper
 * Date: 2016/11/9 0009
 * Time: 11:13
 */
define('LIB_ROOT', '../includes/lib/');
define('DATA_DIR', '../data/wx/'); //数据保存的位置
define('USER_TOKEN', 'HAHAHA'); //自定义认证token

include_once('functions.php');
include_once(LIB_ROOT.'Weixin.class.php');
include_once(LIB_ROOT.'weixin/errCode.php');

$localMenu_file  = DATA_DIR . 'LocalMenu.json'; //本地尚未同步至微信的json数组

$OptionWX = array(
    'token'=>'weixin', //填写你设定的key
    'encodingaeskey'=> '', //填写加密用的EncodingAESKey
    'appid'=>'wx3eea553d8ab21caa', //填写高级调用功能的app id
    'appsecret'=>'8a8eaaeda77febffb186e26e42572df6' //填写高级调用功能的密钥
);

//判断是否存在本地配置缓存文件
if (!file_exists($localMenu_file)) {
    $WechatMenuJSON = getWechatMenuData($OptionWX, true);
    file_put_contents($localMenu_file, $WechatMenuJSON); //创建缓存文件并写入
} else {
    //$objWechat = new Wechat($OptionWX);
    $WechatMenuJSON = file_get_contents($localMenu_file); //获取本地的菜单数组
}

$local_Menu_Arr  = json_decode($WechatMenuJSON, true); //转换为php数组

if (!$local_Menu_Arr) { //判断当前本地的数组是否为空
    $WechatMenuJSON = getWechatMenuData($OptionWX, true);
    file_put_contents($localMenu_file, $WechatMenuJSON);//保存至本地文件
} else {
    $WechatMenuArr = $local_Menu_Arr;
}

//根据操作名称进行相应操作
$act = CheckDatas('act','');
switch ($act)
{
    default:
        foreach ($WechatMenuArr as $menus) {
            $buttons_arr = $menus;
        }
        $button_type_arr = array( //按钮种类数组
            'click'  => '点击',
            'view'   => '链接',
            //'3'  => 'scancode_push',
            //'4'  => 'scancode_waitmsg',
            //'5'  => 'pic_sysphoto',
            //'6'  => 'pic_photo_or_album',
            //'7'  => 'pic_weixin',
            //'8'  => 'location_select',
            //'9'  => 'media_id',
            //'10' => 'view_limited',
        );

        include_once('tpl/menu_web.php');
        break;

    case 'update':

        if (isset($_POST) && !empty($_POST)){
            $hasError = '';
            //循环判断接收的数据
            for ($i=1;$i<3;$i++) {

                $Pbutton_name = isset($_POST['Pbutton_name_'. $i]) ? $_POST['Pbutton_name_'. $i] : '';
                $Pbutton_type = isset($_POST['Pbutton_type_'. $i]) ? $_POST['Pbutton_type_'. $i] : '';
                $Pbutton_key  = isset($_POST['Pbutton_key_'. $i])  ? $_POST['Pbutton_key_'. $i]  : '';
                $Pbutton_url  = isset($_POST['Pbutton_url_'. $i])  ? $_POST['Pbutton_url_'. $i]  : '';

                if ($Pbutton_name || $Pbutton_type) {
                    if ($Pbutton_name == '') {
                        ajaxReturn(0,'第'.$i.'个父级按钮名称为空');
                    }
                    if ($Pbutton_type == '') {
                        ajaxReturn(0,'第'.$i.'个父级按钮种类为空');
                    }
                }

                if ($Pbutton_type == 'click' && empty($Pbutton_key)) {
                    ajaxReturn(0,'第'.$i.'个父级按钮键值为空');
                }
                if ($Pbutton_type == 'view' && empty($Pbutton_url)) {
                    ajaxReturn(0,'第'.$i.'个父级按钮链接为空');
                }

                if ($Pbutton_type == 'sub') {
                    foreach ($_POST['Cbutton_names_' . $i] as  $key => $Cbutton_name) {
                        if (!$Cbutton_name) {
                            $j = $key +1;
                            ajaxReturn(0,'第'.$i.'父级按钮里,第'. $j .'个按钮名称为空');
                        }
                        if (!$_POST['Cbutton_types_'. $i][$key]) {
                            $j = $key +1;
                            ajaxReturn(0,'第'.$i.'父级按钮里,第'. $j .'个按钮种类为空');
                        }
                        if (!$_POST['Cbutton_urls_'. $i][$key] && $_POST['Cbutton_types_'. $i][$key] == 'view') {
                            $j = $key + 1;
                            ajaxReturn(0,'第' . $i . '父级按钮里,第' . $j . '个链接名称为空');
                        }
                        if (!$_POST['Cbutton_keys_'. $i][$key] && $_POST['Cbutton_types_'. $i][$key] == 'click') {
                            $j = $key + 1;
                            ajaxReturn(0,'第' . $i . '父级按钮里,第' . $j . '个键值名称为空');
                        }
                    }
                }
            }

            $button_arr = array();
            if (isset($_POST['Pbutton_name_1']) && !empty($_POST['Pbutton_name_1'])) {
                if ($_POST['Pbutton_type_1'] == 'sub') {
                    $sub_button_1 = array();
                    foreach ($_POST['Cbutton_names_'.'1'] as $k1 => $Cbutton_name_1) {
                        $sub_button_1[] = array(
                            'name' => $Cbutton_name_1,
                            'type'  => $_POST['Cbutton_types_'.'1'][$k1],
                            'url'   => $_POST['Cbutton_urls_'.'1'][$k1],
                            'key'   => $_POST['Cbutton_keys_'.'1'][$k1],
                        );
                    }
                    $button_arr[0]['name']       = $_POST['Pbutton_name_1'];
                    $button_arr[0]['sub_button'] = $sub_button_1;
                } else {
                    $button_arr[0]['name']       = $_POST['Pbutton_name_1'];
                    $button_arr[0]['type']       = $_POST['Pbutton_type_1'];
                    $button_arr[0]['url']       = $_POST['Pbutton_url_1'];
                    $button_arr[0]['key']       = $_POST['Pbutton_key_1'];
                }
            }

            if (isset($_POST['Pbutton_name_2']) && !empty($_POST['Pbutton_name_2'])) {
                if ($_POST['Pbutton_type_2'] == 'sub') {
                    $sub_button_2 = array();
                    foreach ($_POST['Cbutton_names_'.'2'] as $k2 => $Cbutton_name_2) {
                        $sub_button_2[] = array(
                            'name' => $Cbutton_name_2,
                            'type'  => $_POST['Cbutton_types_'.'2'][$k2],
                            'url'   => $_POST['Cbutton_urls_'.'2'][$k2],
                            'key'   => $_POST['Cbutton_keys_'.'2'][$k2],
                        );
                    }
                    $button_arr[1]['name']       = $_POST['Pbutton_name_2'];
                    $button_arr[1]['sub_button'] = $sub_button_2;
                } else {
                    $button_arr[1]['name']       = $_POST['Pbutton_name_2'];
                    $button_arr[1]['type']       = $_POST['Pbutton_type_2'];
                    $button_arr[1]['url']       = $_POST['Pbutton_url_2'];
                    $button_arr[1]['key']       = $_POST['Pbutton_key_2'];
                }
            }

            if (isset($_POST['Pbutton_name_3'])  && !empty($_POST['Pbutton_name_3'])) {
                if ($_POST['Pbutton_type_3'] == 'sub') {
                    $sub_button_3 = array();
                    foreach ($_POST['Cbutton_names_'.'3'] as $k3 => $Cbutton_name_3) {
                        $sub_button_3[] = array(
                            'name ' => $Cbutton_name_3,
                            'type'  => $_POST['Cbutton_types_'.'3'][$k3],
                            'url'   => $_POST['Cbutton_urls_'.'3'][$k3],
                            'key'   => $_POST['Cbutton_keys_'.'3'][$k3],
                        );
                    }
                    $button_arr[2]['name']       = $_POST['Pbutton_name_3'];
                    $button_arr[2]['sub_button'] = $sub_button_3;
                } else {
                    $button_arr[2]['name']       = $_POST['Pbutton_name_3'];
                    $button_arr[2]['type']       = $_POST['Pbutton_type_3'];
                    $button_arr[2]['url']       = $_POST['Pbutton_url_3'];
                    $button_arr[2]['key']       = $_POST['Pbutton_key_3'];
                }
            }

            $CreateNewMenu = array('button' => $button_arr);

            if ($hasError) {
                $buttons_arr = $button_arr;
            } else {
                $local_menu_JSON    = json_encode($button_arr, JSON_UNESCAPED_UNICODE);
                $CreateNewMenu_JSON = json_encode($CreateNewMenu, JSON_UNESCAPED_UNICODE); //将生成php数组转为json数组
                if (file_put_contents($localMenu_file, $CreateNewMenu_JSON)){
                    ajaxReturn(1,'写入成功');
                }
            }

        }

        break;

    case 'pushToWechat':
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
        break;
}


