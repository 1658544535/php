<?php
/**
 * Created by PhpStorm.
 * User: Jasper
 * Date: 2016/11/9 0009
 * Time: 11:13
 */

define('HN1', true);
define('LIB_ROOT', '../includes/lib/');

include_once(LIB_ROOT.'Weixin.class.php');
include_once(LIB_ROOT.'weixin/errCode.php');
$OptionWX = array(
    'token'=>'weixin', //填写你设定的key
    'encodingaeskey'=> '', //填写加密用的EncodingAESKey
    'appid'=>'wx3eea553d8ab21caa', //填写高级调用功能的app id
    'appsecret'=>'8a8eaaeda77febffb186e26e42572df6' //填写高级调用功能的密钥
);
$objWechat = new Wechat($OptionWX);
$menus_arr = $objWechat->getMenu();

$button_type_arr = array(
    '1'  => 'click',
    '2'  => 'view',
    '3'  => 'scancode_push',
    '4'  => 'scancode_waitmsg',
    '5'  => 'pic_sysphoto',
    '6'  => 'pic_photo_or_album',
    '7'  => 'pic_weixin',
    '8'  => 'location_select',
    '9'  => 'media_id',
    '10' => 'view_limited',
);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="//cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
    <title>微信自定菜单</title>
</head>
<body>
<div>
    <form action="" method="post">
        <ul>

            <li data-id="1">
                <div>
                    名称：<input type="text" name="Pbutton_name_1">

                    <div>
                        类型：<select name="Pbutton_type_1" class="js-button-type" onchange="ButtonType(this);">
                            <option value="">请选择按钮类型</option>
                            <option value="sub">sub_button</option>
                            <?php foreach ($button_type_arr as $k => $v) { ?>
                                <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
                            <?php } ?>

                        </select>
                    </div>

                    <div class="js-button-type-box">

                        <div>
                            链接：<input type="text" name="Pbutton_url_1">
                        </div>
                        <div>
                            key ：<input type="text" name="Pbutton_key_1">
                        </div>

                    </div>

                    <!--二级菜单-->
                    <div style="display: none;">
                        <ul>
                            <a href="#" onclick="newChild(this);">点击添加</a>
                        </ul>
                    </div>
                </div>

            </li>



            <li>
                <hr>
                <a href="#" class="js-newFirst" onclick="newFirst(this);">点击添加</a>
            </li>
        </ul>

        <hr>

        <button type="button" onclick="submit();">保存并提交</button>
    </form>
</div>
</body>
<script>

    /* 判断BUTTON的种类是否为二级*/
    function ButtonType(_this) {
        var type = $(_this).val();
        /* 若为二级 */
        if (type == 'sub1' || type == 'sub2' || type == 'sub3' || type == 'sub' ) {
            $(_this).parent().next().css("display", "none");
            $(_this).parent().next().next().css("display", "block");
        } else {
            $(_this).parent().next().css("display", "block");
            $(_this).parent().next().next().css("display", "none");
        }
    }

    /* 添加新的一级菜单 */
    function newFirst(_this) {
        var num = $(_this).parent().siblings().length;
        var i = num + 1;
        if (num >= 3) {
            alert("最多只能存在3个一级菜单");
            return false;
        }
        var html = '<li data-id="'+ i +'"><hr><div> 名称：<input type="text" name="Pbutton_name_'+ i +'"> <div> 类型：<select name="Pbutton_type_'+ i +'" class="js-button-type" onchange="ButtonType(this);"> <option value="">请选择按钮类型</option> <option value="sub">sub_button</option><?php foreach ($button_type_arr as $k => $v) { ?><option value="<?php echo $v; ?>"><?php echo $v; ?></option><?php } ?></select> </div> <div class="js-button-type-box"> <div> 链接：<input type="text" name="Pbutton_url_'+ i +'"> </div> <div> key ：<input type="text" name="Pbutton_key_'+ i +'"> </div> </div><!--二级菜单--> <div style="display: none;"> <ul> <a href="#" onclick="newChild(this);">点击添加</a> </ul> </div> </div></li>';
        $(_this).parent().before(html);
    }

    /* 添加新的二级菜单 */
    function newChild(_this) {
        var num = $(_this).siblings().length;
        var i = $(_this).parent().parent().parent().parent().data("id"); //一级菜单的个数
        var html = '<li><br><div> 名称：<input type="text" name="Cbutton_names_'+ i +'[]" value=""> </div> <div> 类型：<select name="Cbutton_types_'+ i +'[]" > <option value="">请选择按钮类型</option><?php foreach ($button_type_arr as $k => $v) { ?><option value="<?php echo $v; ?>"><?php echo $v; ?></option><?php } ?></select> </div> <div> 链接：<input type="text" name="Cbutton_urls_'+ i +'[]"> </div> <div> key ：<input type="text" name="Cbutton_keys_'+ i +'[]"> </div> </li>';
        if (num >= 5) {
            alert("最多只能存在5个二级菜单");
            return false;
        }
        $(_this).before(html);
    }

</script>
</html>

<?php

if (isset($_POST)){

    $button_arr = array();

    if (isset($_POST['Pbutton_name_1'])) {
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

    if (isset($_POST['Pbutton_name_2'])) {
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

    if (isset($_POST['Pbutton_name_3'])) {
        if ($_POST['Pbutton_type_3'] == 'sub') {

            $sub_button_3 = array();

            foreach ($_POST['Cbutton_names_'.'3'] as $k3 => $Cbutton_name_3) {
                $sub_button_3[] = array(
                    'name' => $Cbutton_name_3,
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

    if (isset($_POST['Pbutton_name_1'])) {
        $result = $objWechat->createMenu($CreateNewMenu);
        var_dump($objWechat->errMsg);
        var_dump($objWechat->errCode);
    }

//    $result = $objWechat->createMenu($newmenu);
//    $result = $objWechat->createMenu($CreateArr);
//    $result = $objWechat->getMenu();

//    print_r($result);

//    var_dump($objWechat->errMsg);
//    var_dump($objWechat->errCode);

}






