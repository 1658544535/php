<?php
/**
 * Created by PhpStorm.
 * User: Jasper
 * Date: 2016/11/9 0009
 * Time: 11:13
 */

define('HN1', true);
define('LIB_ROOT', '../includes/lib/');
define('DATA_DIR', dirname(__FILE__) . '/data/'); //数据保存的位置

include_once(LIB_ROOT.'Weixin.class.php');
include_once(LIB_ROOT.'weixin/errCode.php');

$OptionWX = array(
    'token'=>'weixin', //填写你设定的key
    'encodingaeskey'=> '', //填写加密用的EncodingAESKey
    'appid'=>'wx3eea553d8ab21caa', //填写高级调用功能的app id
    'appsecret'=>'8a8eaaeda77febffb186e26e42572df6' //填写高级调用功能的密钥
);

$createMenu_file = "CreateMenu.json"; //保存的新建菜单JSON数组
$localMenu_file  = "LocalMenu.json"; //本地尚未同步至微信的json数组
$saveMenu_file   = "SaveMenu.json"; //保存已经创建的数组=> 通过getMenu()方法获取的数组

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
if (!file_exists(DATA_DIR . $localMenu_file)) {
    $WechatMenuJSON = getWechatMenuData($OptionWX, true);
    file_put_contents(DATA_DIR . $localMenu_file, $WechatMenuJSON); //创建缓存文件并写入
}

//$objWechat = new Wechat($OptionWX);
$local_Menu_JSON = file_get_contents(DATA_DIR . $localMenu_file); //获取本地的菜单数组
$local_Menu_Arr  = json_decode($local_Menu_JSON, true); //转换为php数组

if (!$local_Menu_Arr) { //判断当前本地的数组是否为空
    $WechatMenuJSON = getWechatMenuData($OptionWX, true);
    file_put_contents(DATA_DIR . $localMenu_file, $WechatMenuJSON);//保存至本地文件
} else {
    $WechatMenuArr = $local_Menu_Arr;
}

$button_arr = $WechatMenuArr;

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
    <script src="js/jquery.form.min.js"></script>
    <title>微信自定菜单</title>
</head>
<body>
<div>

    <form action="" method="post" id="wechatMenuForm">
        <ul>

            <?php foreach ($button_arr as $k => $v) {
//                print_r($v["sub_button"]);
                ?>

                <li data-id="<?php echo $k+1 ?>">
                    <div>
                        名称：<input type="text" name="Pbutton_name_<?php echo $k+1 ?>" value="<?php echo $v["name"];?>">
                        <div>
                            类型：<select name="Pbutton_type_<?php echo $k+1 ?>" class="js-button-type" onchange="ButtonType(this);">
                                <option value="">请选择按钮类型</option>
                                <option value="sub" <?php if (isset($v["sub_button"])) echo "selected";?>>sub_button</option>
                                <?php foreach ($button_type_arr as $key => $value) {  ?>
                                    <option value="<?php echo $value; ?>"  <?php if (!isset($v["sub_button"])) { if ($v["type"] == $value) echo "selected"; } ?>><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="js-button-type-box" style="<?php if (isset($v["sub_button"])) echo "display: none;"; ?>">
                            <div>
                                链接：<input type="text" name="Pbutton_url_<?php echo $k+1 ?>" value="<?php echo isset($v["url"]) ? $v["url"] : ''; ?>">
                            </div>
                            <div>
                                key ：<input type="text" name="Pbutton_key_<?php echo $k+1 ?>" value="<?php echo isset($v["key"]) ? $v["key"] : ''; ?>">
                            </div>
                        </div>
                        <!--二级菜单-->
                        <div style="<?php if (!isset($v["sub_button"])) echo "display: none;"; ?>">
                            <ul>

                                <?php foreach ($v as $sub_key => $sub_buttons) {
                                    //循环输出二级菜单 ?>
                                    <?php if (is_array($sub_buttons)){ ?>
                                        <?php foreach ($sub_buttons as $sub_button) { ?>

                                            <li>
                                                <br>
                                                <div> 名称：<input type="text" name="Cbutton_names_<?php echo $k+1 ?>[]" value="<?php echo $sub_button["name"]; ?>"> </div>
                                                <div>
                                                    类型：<select name="Cbutton_types_<?php echo $k+1 ?>[]">
                                                        <?php foreach ($button_type_arr as $key => $value) { ?>
                                                            <option value="<?php echo $value;?>" <?php if ($sub_button["type"] == $value) echo "selected"; ?>><?php echo $value;?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div> 链接：<input type="text" name="Cbutton_urls_<?php echo $k+1 ?>[]" value="<?php echo isset($sub_button["url"]) ? $sub_button["url"] : ''; ?>"> </div>
                                                <div> key ：<input type="text" name="Cbutton_keys_<?php echo $k+1 ?>[]" value="<?php echo isset($sub_button["key"]) ? $sub_button["key"] : ''; ?>"> </div>
                                            </li>

                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>

                                <a href="#" onclick="newChild(this);">点击添加</a>
                            </ul>

                        </div>
                    </div>

                    <hr>

                </li>

            <?php } ?>


            <li>
                <a href="#" class="js-newFirst" onclick="newFirst(this);">点击添加</a>
            </li>
        </ul>

        <hr>
        <input type="hidden" value="1" name="isCreatJSON">
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


if (isset($_POST) && !empty($_POST)){

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

    $local_menu_JSON    = json_encode($button_arr, JSON_UNESCAPED_UNICODE);
    $CreateNewMenu_JSON = json_encode($CreateNewMenu, JSON_UNESCAPED_UNICODE); //将生成php数组转为json数组
}

if (isset($_POST) && !empty($_POST)) {?>
    <?php if (file_put_contents(DATA_DIR . $createMenu_file, $CreateNewMenu_JSON) && file_put_contents(DATA_DIR . $localMenu_file, $local_menu_JSON)) {?>
        <h1>保存成功，是否需要提交同步至微信？</h1>
        <form action="">
            <button type="button" onclick="pushToWechat();">确定</button>
        </form>
        <script>
            var token = 'HAHAHA';
            function pushToWechat() {
                var url = 'push_to_wechat.php?token=' + token ;
                $.getJSON(url,function (data) {
                    alert(data.info);
                });
            }
        </script>
    <?php } else { ?>
        <h1>保存失败</h1>
    <?php }?>
<?php } ?>




