<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="//cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <title>微信自定菜单</title>
</head>
<body>
<div>

    <form action="" method="post" id="wechatMenuForm">
        <ul>

            <?php foreach ($buttons_arr as $k => $v) { ?>

                <li data-id="<?php echo $k+1 ?>">
                    <a href="javascript:" class="js-delete" onclick="deleteHAHA(this)">删除</a>
                    <div>
                        名称：<input type="text" name="Pbutton_name_<?php echo $k+1 ?>" value="<?php echo $v["name"];?>">
                        <div>
                            类型：<select name="Pbutton_type_<?php echo $k+1 ?>" class="js-button-type" onchange="ButtonType(this);">
                                <option value="">请选择按钮类型</option>
                                <option value="sub" <?php if (isset($v["sub_button"])) echo "selected";?>>菜单</option>
                                <?php foreach ($button_type_arr as $key => $value) {  ?>
                                    <option value="<?php echo $key; ?>"  <?php if (!isset($v["sub_button"])) { if ($v["type"] == $key) echo "selected"; } ?>><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="js-button-type-box" style="<?php if (isset($v["sub_button"])) echo "display: none;"; ?>">
                            <div>
                                链接：<input type="text" class="js-url" name="Pbutton_url_<?php echo $k+1 ?>" value="<?php echo isset($v["url"]) ? $v["url"] : ''; ?>">
                            </div>
                            <div>
                                key ：<input type="text" class="js-key" name="Pbutton_key_<?php echo $k+1 ?>" value="<?php echo isset($v["key"]) ? $v["key"] : ''; ?>">
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
                                                <a href="javascript:" class="js-delete">删除</a>
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



                </li>

            <?php } ?>


            <li>
                <hr>
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
        if (num >= 2) {
            // alert("最多只能存在3个一级菜单");
            $(".js-newFirst").hide();
            // return false;
        }
        var html = '<li data-id="'+ i +'"><hr><a href="javascript:" class="js-delete" onclick="deleteHAHA(this)">删除</a><div> 名称：<input type="text" name="Pbutton_name_'+ i +'"> <div> 类型：<select name="Pbutton_type_'+ i +'" class="js-button-type" onchange="ButtonType(this);"> <option value="">请选择按钮类型</option> <option value="sub">菜单</option><?php foreach ($button_type_arr as $k => $v) { ?><option value="<?php echo $k; ?>"><?php echo $v; ?></option><?php } ?></select> </div> <div class="js-button-type-box"> <div> 链接：<input type="text" name="Pbutton_url_'+ i +'"> </div> <div> key ：<input type="text" name="Pbutton_key_'+ i +'"> </div> </div><!--二级菜单--> <div style="display: none;"> <ul> <a href="#" class="js-newChild" onclick="newChild(this);">点击添加</a> </ul> </div> </div></li>';
        $(_this).parent().before(html);
    }

    /* 添加新的二级菜单 */
    function newChild(_this) {
        var num = $(_this).siblings().length;
        var i = $(_this).parent().parent().parent().parent().data("id"); /*一级菜单的个数*/
        var html = '<li><a href="javascript:" class="js-delete" onclick="deleteHAHA2(this)">删除</a><div> 名称：<input type="text" name="Cbutton_names_'+ i +'[]" value=""> </div> <div> 类型：<select name="Cbutton_types_'+ i +'[]" > <option value="">请选择按钮类型</option><?php foreach ($button_type_arr as $k => $v) { ?><option value="<?php echo $k; ?>"><?php echo $v; ?></option><?php } ?></select> </div> <div> 链接：<input type="text" name="Cbutton_urls_'+ i +'[]"> </div> <div> key ：<input type="text" name="Cbutton_keys_'+ i +'[]"> </div> </li>';
        if (num >= 4) {
            $(".js-newChild").hide();
            // alert("最多只能存在5个二级菜单");
            // return false;
        }
        $(_this).before(html);
    }

    /* 删除菜单 */
    function deleteHAHA(_this) {
        var p = $(_this).parent();
        if(p.siblings('li').length<=3){
            $(".js-newFirst").show();
        }
        p.remove();
    }
    function deleteHAHA2(_this) {
        var p = $(_this).parent();
        if(p.siblings('li').length<=5){
            $(".js-newChild").show();
        }
        p.remove();
    }
</script>
</html>