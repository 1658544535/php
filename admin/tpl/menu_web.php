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

    <a href="index.php">主页</a>
    <a href="wx_reply.php">自定义回复</a>
    <a href="auth.php?act=logout">登出</a>

    <form action="wx_menu.php?act=update" method="post" id="wechatMenuForm">
        <ul>

            <?php foreach ($buttons_arr as $k => $v) { ?>

                <li data-id="<?php echo $k+1 ?>">
                    <a href="javascript:" class="js-delete" onclick="deleteFirst(this)">删除</a>
                    <div>
                        名称：<input type="text" name="Pbutton_name_<?php echo $k+1 ?>" value="<?php echo $v["name"];?>">
                        <div>
                            类型：<select name="Pbutton_type_<?php echo $k+1 ?>" class="js-button-type" onchange="ButtonType(this);">
                                <option value="">请选择按钮类型</option>
                                <option value="sub" <?php if (isset($v["sub_button"]) && !empty($v["sub_button"])) echo "selected";?>>菜单</option>
                                <?php foreach ($button_type_arr as $key => $value) {  ?>
                                    <option value="<?php echo $key; ?>"  <?php if (!isset($v["sub_button"]) || empty($v["sub_button"])) { if ($v["type"] == $key) echo "selected"; } ?>><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="js-button-type-box">
                            <div class="js-view">
                                key ：<input type="text" class="js-key" name="Pbutton_key_<?php echo $k+1 ?>" value="<?php echo isset($v["key"]) ? $v["key"] : ''; ?>">
                            </div>
                            <div class="js-click">
                                链接：<input type="text" class="js-url" name="Pbutton_url_<?php echo $k+1 ?>" value="<?php echo isset($v["url"]) ? $v["url"] : ''; ?>">
                            </div>
                            <!--二级菜单-->
                            <div class="js-sub" style="<?php if (!isset($v["sub_button"]) && empty($v["sub_button"])) echo "display: none;"; ?>">
                                <ul>

                                    <?php foreach ($v as $sub_key => $sub_buttons) {
                                        //循环输出二级菜单 ?>
                                        <?php if (is_array($sub_buttons)){ ?>
                                            <?php foreach ($sub_buttons as $sub_button) { ?>

                                                <li>
                                                    <a href="javascript:" class="js-delete">删除</a>
                                                    <div> 名称：<input type="text" name="Cbutton_names_<?php echo $k+1 ?>[]" value="<?php echo $sub_button["name"]; ?>"> </div>
                                                    <div>
                                                        类型：<select onchange="ButtonType(this);" name="Cbutton_types_<?php echo $k+1 ?>[]">
                                                            <?php foreach ($button_type_arr as $key => $value) { ?>
                                                                <option value="<?php echo $key;?>" <?php if ($sub_button["type"] == $value) echo "selected"; ?>><?php echo $value;?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <div> key ：<input type="text" name="Cbutton_keys_<?php echo $k+1 ?>[]" value="<?php echo isset($sub_button["key"]) ? $sub_button["key"] : ''; ?>"> </div>
                                                        <div> 链接：<input type="text" name="Cbutton_urls_<?php echo $k+1 ?>[]" value="<?php echo isset($sub_button["url"]) ? $sub_button["url"] : ''; ?>"> </div>
                                                    </div>
                                                </li>

                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>

                                    <a href="#" class="js-newChild" onclick="newChild(this);">点击添加</a>
                                </ul>

                            </div>
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
        <button type="submit">保存并提交</button>
    </form>

</div>

<div class="js-alert" style="display: none;">
    <h1>保存成功，是否需要提交同步至微信？</h1>
    <form action="">
        <button type="button" onclick="pushToWechat();">确定</button>
    </form>
</div>

</body>
<script>
    $(function(){
        update_select();
    });

    /* 判断BUTTON的种类是否为二级*/
    function ButtonType(_this) {
        var type = $(_this).val();
        var subDiv = $(_this).parent().next().children();
        var index = subDiv.length;
        /* 若为二级 */
        if (type == 'sub1' || type == 'sub2' || type == 'sub3' || type == 'sub' ) {
            index = 2;
        } else if(type == "click"){
            index = 0;
        }else if(type == "view"){
            index = 1;
        }else {
            index = subDiv.length;
        }
        subDiv.hide().eq(index).show();
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
        var html = '<li data-id="'+ i +'"><hr><a href="javascript:" class="js-delete" onclick="deleteFirst(this)">删除</a><div> 名称：<input type="text" name="Pbutton_name_'+ i +'"> <div> 类型：<select name="Pbutton_type_'+ i +'" class="js-button-type" onchange="ButtonType(this);"> <option value="">请选择按钮类型</option> <option value="sub">菜单</option><?php foreach ($button_type_arr as $k => $v) { ?><option value="<?php echo $k; ?>"><?php echo $v; ?></option><?php } ?></select> </div> <div class="js-button-type-box"><div> key ：<input type="text" name="Pbutton_key_'+ i +'"> </div><div> 链接：<input type="text" name="Pbutton_url_'+ i +'"></div> </div><!--二级菜单--> <div style="display: none;"> <ul> <a href="#" class="js-newChild" onclick="newChild(this);">点击添加</a> </ul> </div> </div></li>';
        $(_this).parent().before(html);
        update_select();
    }

    /* 添加新的二级菜单 */
    function newChild(_this) {
        var num = $(_this).siblings().length;
        var i = $(_this).parent().parent().parent().parent().data("id"); /*一级菜单的个数*/
        var html = '<li><a href="javascript:" class="js-delete" onclick="deleteChild(this)">删除</a><div> 名称：<input type="text" name="Cbutton_names_'+ i +'[]" value=""> </div> <div> 类型：<select onchange="ButtonType(this);" name="Cbutton_types_'+ i +'[]" > <option value="">请选择按钮类型</option><?php foreach ($button_type_arr as $k => $v) { ?><option value="<?php echo $k; ?>"><?php echo $v; ?></option><?php } ?></select> </div> <div> <div> key ：<input type="text" name="Cbutton_keys_'+ i +'[]"> </div><div> 链接：<input type="text" name="Cbutton_urls_'+ i +'[]"> </div></div> </li>';
        if (num >= 4) {
            $(_this).parent().find(".js-newChild").hide();
            // alert("最多只能存在5个二级菜单");
            // return false;
        }
        $(_this).before(html);
        update_select();
    }

    /* 删除菜单 */
    function deleteFirst(_this) {
        var p = $(_this).parent();
        console.log(p.siblings('li').length);
        if(p.siblings('li').length<=4){
            p.parent().find(".js-newFirst").show();
        }
        p.remove();
    }
    function deleteChild(_this) {
        var p = $(_this).parent();
        if(p.siblings('li').length<=5){
            p.siblings(".js-newChild").show();
        }
        p.remove();
    }

    /* ajax提交更新写入操作 */
    $('#wechatMenuForm').ajaxForm({
        success: function (data) {
            data = eval("(" + data + ")");
            if (data.status) {
                $('.js-alert').css("display", "block");
            } else {
                alert(data.info);
            }
        }
    });
    /* ajax提交同步至微信端 */
    var token = 'HAHAHA';
    function pushToWechat() {
        var url = 'wx_menu.php?act=pushToWechat&token=' + token ;
        $.getJSON(url,function (data) {
            if (data.status) {
                alert(data.info);
            } else {
                alert('提交失败');
                console.log(data);
            }
        });
    }
    /*更新select对应的div显示*/
    function update_select(){
        $("select").each(function(index, el) {
            ButtonType(el);
        });
    }

</script>
</html>