<?php
/**
 * Created by PhpStorm.
 * User: Jasper
 * Date: 2016/11/9 0009
 * Time: 11:13
 */
include_once('wx_option.php');

//获取微信端当前Menu的配置,默认返回array
function getWechatMenuData($OptionWX, $type = '') {
    $objWechat = new Wechat($OptionWX);
    $result = $objWechat->getMenu();
    if ($type) {
        $json = json_encode($result, JSON_UNESCAPED_UNICODE);
        return $json;
    }
    return $result;
}

//判断是否存在本地配置缓存文件
if (!file_exists($localMenu_file)) {
    $WechatMenuJSON = getWechatMenuData($OptionWX, true);
    file_put_contents($localMenu_file, $WechatMenuJSON); //创建缓存文件并写入
} else {
    //$objWechat = new Wechat($OptionWX);
    $local_Menu_JSON = file_get_contents($localMenu_file); //获取本地的菜单数组
}

$local_Menu_Arr  = json_decode($local_Menu_JSON, true); //转换为php数组

if (!$local_Menu_Arr) { //判断当前本地的数组是否为空
    $WechatMenuJSON = getWechatMenuData($OptionWX, true);
    file_put_contents($localMenu_file, $WechatMenuJSON);//保存至本地文件
} else {
    $WechatMenuArr = $local_Menu_Arr;
}

foreach ($WechatMenuArr as $menus) {
    $buttons_arr = $menus;
}

//$buttons_arr = $WechatMenuArr;

//$a = json_decode(file_get_contents(DATA_DIR . $createMenu_file), true);
//foreach ($a as $v){
//    print_r($v);
//    $buttons_arr = $v;
//}

$button_type_arr = array(
    'click'  => '点击',
    'view'   => '链接',
//    '3'  => 'scancode_push',
//    '4'  => 'scancode_waitmsg',
//    '5'  => 'pic_sysphoto',
//    '6'  => 'pic_photo_or_album',
//    '7'  => 'pic_weixin',
//    '8'  => 'location_select',
//    '9'  => 'media_id',
//    '10' => 'view_limited',
);

if (isset($_POST) && !empty($_POST)){

    $hasError = '';
    //循环判断接收的数据
    for ($i=1;$i<3;$i++) {
        $Pbutton_name = isset($_POST['Pbutton_name_'. $i]) ? $_POST['Pbutton_name_'. $i] : '';
        $Pbutton_type = isset($_POST['Pbutton_type_'. $i]) ? $_POST['Pbutton_type_'. $i] : '';

        if ($Pbutton_name || $Pbutton_type) {
            if ($Pbutton_name == '') {
                echo '<script>alert("第'.$i.'个父级按钮名称为空");</script>';
                $hasError = 1;
            }
            if ($Pbutton_type == '') {
                echo '<script>alert("第'.$i.'个父级按钮种类为空");</script>';
                $hasError = 1;
            }
        }

        if (isset($_POST['Pbutton_type_'. $i])) {
            $Pbutton_type = $_POST['Pbutton_type_'. $i];
        }

        if (!$Pbutton_type && $Pbutton_type == 'click') {
            echo '<script>alert("第'.$i.'个父级按钮键值为空");</script>';
            $hasError = 1;
        }
        if (!$Pbutton_type && $Pbutton_type == 'view') {
            echo '<script>alert("第'.$i.'个父级按钮链接为空");</script>';
            $hasError = 1;
        }

        if ($Pbutton_type == 'sub') {
            foreach ($_POST['Cbutton_names_' . $i] as  $key => $Cbutton_name) {
                if (!$Cbutton_name) {
                    $j = $key +1;
                    echo '<script>alert("第'.$i.'父级按钮里,第'. $j .'个按钮名称为空");</script>';
                    $hasError = 1;
                }
                if (!$_POST['Cbutton_types_'. $i][$key]) {
                    $j = $key +1;
                    echo '<script>alert("第'.$i.'父级按钮里,第'. $j .'个按钮种类为空");</script>';
                    $hasError = 1;
                }
                if (!$_POST['Cbutton_urls_'. $i][$key] && $_POST['Cbutton_types_'. $i][$key] == 'view') {
                    $j = $key + 1;
                    echo '<script>alert("第' . $i . '父级按钮里,第' . $j . '个链接名称为空");</script>';
                    $hasError = 1;
                }
                if (!$_POST['Cbutton_keys_'. $i][$key] && $_POST['Cbutton_types_'. $i][$key] == 'click') {
                    $j = $key + 1;
                    echo '<script>alert("第' . $i . '父级按钮里,第' . $j . '个键值名称为空");</script>';
                    $hasError = 1;
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

    $CreateNewMenu = array(
        'button' => $button_arr,
    );

    if ($hasError) {
        $buttons_arr = $button_arr;
    } else {
        $local_menu_JSON    = json_encode($button_arr, JSON_UNESCAPED_UNICODE);
        $CreateNewMenu_JSON = json_encode($CreateNewMenu, JSON_UNESCAPED_UNICODE); //将生成php数组转为json数组
    }

}

include_once('tpl/menu_web.php');

if (isset($_POST) && !empty($_POST)) {
    if (!$hasError) { ?>
        <?php if (file_put_contents($localMenu_file, $CreateNewMenu_JSON)) {?>
            <h1>保存成功，是否需要提交同步至微信？</h1>
            <form action="">
                <button type="button" onclick="pushToWechat();">确定</button>
            </form>
            <script>
                var token = 'HAHAHA';
                function pushToWechat() {
                    var url = 'push_to_wechat.php?token=' + token ;
                    $.getJSON(url,function (data) {
                        if (data.status) {
                            alert(data.info);
                        } else {
                            alert('提交失败');
                            console.log(data);
                        }
                    });
                }
            </script>
        <?php } else { ?>
            <h1>保存失败</h1>
        <?php }?>
    <?php } else { ?>
        <h1>保存失败</h1>
    <?php } ?>
<?php } ?>

