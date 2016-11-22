<?php
/**
 * Created by PhpStorm.
 * User: Jasper
 * Date: 2016/11/9 0009
 * Time: 11:13
 */
include_once('global.php');

$OptionWX = array(
    'appid' => $app_info['appid'],
    'appsecret' => $app_info['secret'],
    'token' => isset($app_info['token']) ? $app_info['token'] : 'weixin',
    'encodingaeskey' => isset($app_info['encodingaeskey']) ? $app_info['encodingaeskey'] : '',
);

$localMenu_file  = DATA_DIR . 'LocalMenu.json'; //本地尚未同步至微信的json数组
//$wxOption_file   = DATA_DIR . 'wxOption.json';  //微信配置

switch ($act)
{
    case '':
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

    case 'login':
        include_once 'tpl/menu_login.php';
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
            for ($i=0; $i<3; $i++) {
                $j = $i+1;
                if (isset($_POST['Pbutton_name_' . $j]) && !empty($_POST['Pbutton_name_' . $j])) {
                    if ($_POST['Pbutton_type_' . $j] == 'sub') {
                        $sub_button = array();
                        foreach ($_POST['Cbutton_names_'. $j] as $k => $Cbutton_name) {
                            $sub_button[] = array(
                                'name'  => $Cbutton_name,
                                'type'  => $_POST['Cbutton_types_'. $j][$k],
                                'url'   => $_POST['Cbutton_urls_' . $j][$k],
                                'key'   => $_POST['Cbutton_keys_' . $j][$k],
                            );
                        }
                        $button_arr[$i]['name']       = $_POST['Pbutton_name_'. $j];
                        $button_arr[$i]['sub_button'] = $sub_button;
                    } else {
                        $button_arr[$i]['name'] = $_POST['Pbutton_name_'. $j];
                        $button_arr[$i]['type'] = $_POST['Pbutton_type_'. $j];
                        $button_arr[$i]['url']  = $_POST['Pbutton_url_' . $j];
                        $button_arr[$i]['key']  = $_POST['Pbutton_key_' . $j];
                    }
                }
            }
            $CreateNewMenu = array('button' => $button_arr);

            $local_menu_JSON    = json_encode_custom($button_arr);
            $CreateNewMenu_JSON = json_encode_custom($CreateNewMenu); //将生成php数组转为json数组
            if (file_put_contents($localMenu_file, $CreateNewMenu_JSON)){
                ajaxReturn(1,'写入成功');
            }
        }

        break;

    case 'pushToWechat':
        $token = (isset($_GET['token'])) ? $_GET['token'] : '';
        //验证
        if ($token !== USER_TOKEN) {
            ajaxReturn(0,'验证失败');
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

