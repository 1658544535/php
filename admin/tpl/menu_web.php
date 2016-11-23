<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/base.css" />
    <link rel="stylesheet" type="text/css" href="css/content.css" />
    <title>微信自定菜单</title>
</head>
<body>

    <div class="wrap">

        <section class="header bounceInUp bounceInUp-1 animated">
            <div class="logo"><a href="index.php">拼得好</a></div>
            <ul class="menu">
                <li><a class="active" href="wx_menu.php">
                    <img src="images/index-menu-menu.png" />
                    <p>自定义菜单</p>
                </a></li>
                <li><a href="wx_reply.php">
                    <img src="images/index-menu-reply.png" />
                    <p>自定义回复</p>
                </a></li>
                <li><a href="auth.php?act=logout">
                    <img src="images/index-menu-logout.png" />
                    <p>登 出</p>
                </a></li>
            </ul>
        </section>

        <section class="content bounceInUp bounceInUp-2 animated">

            <form action="wx_menu.php?act=update" method="post" id="wechatMenuForm">
                <?php foreach ($buttons_arr as $k => $v) { ?>
                <dl class="wx-menu clearfix" data-id="<?php echo $k+1 ?>">
                    <dt class="key">
                        <div class="key-main">
                            <input class="form-control" type="text" placeholder="请输入名称..." name="Pbutton_name_<?php echo $k+1 ?>" value="<?php echo $v["name"];?>" />
                            <select placeholder="请选择按钮类型..." class="form-control" name="Pbutton_type_<?php echo $k+1 ?>" onchange="typeChange(this)">
                                <option value="">请选择按钮类型...</option>
                                <option value="sub" <?php if (isset($v["sub_button"]) && !empty($v["sub_button"])) echo "selected";?>>菜单</option>
                                <?php foreach ($button_type_arr as $key => $value) {  ?>
                                    <option value="<?php echo $key; ?>"  <?php if (!isset($v["sub_button"]) || empty($v["sub_button"])) { if ($v["type"] == $key) echo "selected"; } ?>><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                            <a class="btn btn-del" href="javascript:;" onclick="delMenu(this)" title="删 除">删 除</a>
                        </div>
                    </dt>
                    <dd class="value clearfix">
                        <div class="v-menu">
                            <ul class="wx-sub-menu">
                                <?php foreach ($v as $sub_key => $sub_buttons) {
                                    //循环输出二级菜单 ?>
                                    <?php if (is_array($sub_buttons)){ ?>
                                        <?php foreach ($sub_buttons as $sub_button) { ?>
                                            <li class="clearfix">
                                                <div class="sub-key">
                                                    <input class="form-control" type="text" placeholder="请输入名称..." name="Cbutton_names_<?php echo $k+1 ?>[]" value="<?php echo $sub_button["name"]; ?>" />
                                                    <select class="form-control" name="Cbutton_types_<?php echo $k+1 ?>[]" onchange="typeChange(this)">
                                                        <?php foreach ($button_type_arr as $key => $value) { ?>
                                                            <option value="<?php echo $key;?>" <?php if ($sub_button["type"] == $key) echo "selected"; ?>><?php echo $value;?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="sub-value">
                                                    <div class="v-click clearfix">
                                                        <input class="form-control" type="text" placeholder="请输入key..." name="Cbutton_keys_<?php echo $k+1 ?>[]" value="<?php echo isset($sub_button["key"]) ? $sub_button["key"] : ''; ?>" />
                                                    </div>
                                                    <div class="v-view clearfix">
                                                        <input class="form-control" type="text" placeholder="请输入链接..." name="Cbutton_urls_<?php echo $k+1 ?>[]" value="<?php echo isset($sub_button["url"]) ? $sub_button["url"] : ''; ?>" />
                                                    </div>
                                                    <a class="btn btn-del" href="javascript:;" onclick="delSubMenu(this)" title="删 除">删 除</a>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                                <li>
                                    <a class="btn btn-add" href="javascript:;" onclick="addSubMenu(this)">添 加</a>
                                </li>
                            </ul>
                        </div>
                        <div class="v-click">
                            <input class="form-control" type="text" placeholder="请输入key..." name="Pbutton_key_<?php echo $k+1 ?>" value="<?php echo isset($v["key"]) ? $v["key"] : ''; ?>" />
                        </div>
                        <div class="v-view">
                            <input class="form-control" type="text" placeholder="请输入链接..." name="Pbutton_url_<?php echo $k+1 ?>" value="<?php echo isset($v["url"]) ? $v["url"] : ''; ?>" />
                        </div>
                    </dd>
                </dl>
                <?php } ?>

                <div class="form-submit">
                    <?php if(count($buttons_arr)<3){?>
                    <a class="btn btn-add" href="javascript:;" onclick="addMenu(this)">添 加</a>
                    <?php }?>
                    <button class="btn btn-save" type="submit">保存并提交</button>
                    <div class="loading hide"></div>
                </div>

            </form>

        </section>

        <section class="wx-syn animated hide">
            <h3>保存成功，是否需要提交同步至微信？</h3>
            <button class="btn btn-save" type="button">确 定</button>
            <a class="btn btn-cancel" href="javascript:;">取 消</a>
        </section>

    </div>

    <script id="t:menu" type="text/html">
        <dl class="wx-menu clearfix" data-id="<%= num%>">
            <dt class="key">
                <div class="key-main">
                    <input class="form-control" type="text" placeholder="请输入名称..." name="Pbutton_name_<%= num%>" />
                    <select placeholder="请选择按钮类型..." class="form-control" name="Pbutton_type_<%= num%>" onchange="typeChange(this)">
                        <option value="">请选择按钮类型...</option>
                        <option value="sub">菜单</option>
                        <?php foreach ($button_type_arr as $key => $value) {  ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                    <a class="btn btn-del" href="javascript:;" onclick="delMenu(this)" title="删 除">删 除</a>
                </div>
            </dt>
            <dd class="value clearfix">
                <div class="v-menu">
                    <ul class="wx-sub-menu">
                        <li>
                            <a class="btn btn-add" href="javascript:;" onclick="addSubMenu(this)">添 加</a>
                        </li>
                    </ul>
                </div>
                <div class="v-click">
                    <input class="form-control" type="text" placeholder="请输入key..." name="Pbutton_key_<%= num%>" />
                </div>
                <div class="v-view">
                    <input class="form-control" type="text" placeholder="请输入链接..." name="Pbutton_url_<%= num%>" />
                </div>
            </dd>
        </dl>
    </script>

    <script id="t:sub_menu" type="text/html">
        <li class="clearfix">
            <div class="sub-key">
                <input class="form-control" type="text" placeholder="请输入名称..." name="Cbutton_names_<%= num%>[]" />
                <select class="form-control" name="Cbutton_types_<%= num%>[]" onchange="typeChange(this)">
                    <?php foreach ($button_type_arr as $key => $value) { ?>
                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="sub-value">
                <div class="v-click">
                    <input class="form-control" type="text" placeholder="请输入key..." name="Cbutton_keys_<%= num%>[]" />
                </div>
                <div class="v-view">
                    <input class="form-control" type="text" placeholder="请输入链接..." name="Cbutton_urls_<%= num%>[]" />
                </div>
                <a class="btn btn-del" href="javascript:;" onclick="delSubMenu(this)" title="删 除">删 除</a>
            </div>
        </li>
    </script>

</body>
<script src="//cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
<script src="js/baiduTemplate.js"></script>
<script src="js/jquery.form.js"></script>
<script>    
    $(function(){

        //显示按钮类型相应的内容
        setId();
        $("select.form-control").each(function(index, el) {
            typeChange(el);
        });

        // ajax提交更新写入操作
        $(document).on("change", ".form-control", function(){
            if($(this).val() != '') {
                $(this).removeClass("error");
            }
        });
        $('#wechatMenuForm').on("submit", function(){
            $(".form-control:hidden").each(function(index, el) {
                if($(el).is(":hidden") || $(el).parent().is(":hidden")){
                    // $(el).attr("disabled", true);
                    $(el).val('');
                }
            });
            var _this = $(this);
            if(doValidate()){
                $(".form-submit .btn").hide();
                $(".form-submit .loading").show();
                _this.ajaxSubmit({
                    success: function (data) {
                        data = eval("(" + data + ")");
                        if (data.status) {
                            $(".form-submit").hide();
                            $('.wx-syn').show().removeClass("zoomOut").addClass("zoomIn");
                        } else {
                            alert(data.info);
                            $(".form-submit .btn").show();
                            $(".form-submit .loading").hide();
                        }
                        // $(".form-control").attr("disabled", false);
                    }
                });
            }
            return false;
        });
        

        // ajax提交同步至微信端
        var token = 'HAHAHA';
        $(".wx-syn .btn-save").on("click", function(){
            $(".wx-syn").removeClass("zoomIn").addClass("zoomOut");
            $(".form-submit").show();
            var url = 'wx_menu.php?act=pushToWechat&token=' + token ;
            $.getJSON(url,function (data) {
                if (data.status) {
                    alert(data.info);
                } else {
                    alert('提交失败');
                }
                $(".form-submit .btn").show();
                $(".form-submit .loading").hide();
            });
        });

        // 取消同步至微信
        $(".wx-syn .btn-cancel").on("click", function(){
            $(".wx-syn").removeClass("zoomIn").addClass("zoomOut");
            $(".form-submit .btn").show();
            $(".form-submit .loading").hide();
            $(".form-submit").fadeIn();
        });

    });


    /* 按钮类型切换显示相应的内容 */
    function typeChange(_this) {
        var type = $(_this).val(),
            ifSub = !!$(_this).parents(".sub-key").length;
        var oAll, oSub, oClick, oView;
        if(ifSub){
            oAll = $(_this).parents(".sub-key").parent().find(".sub-value>div");
            oClick = $(_this).parents(".sub-key").parent().find(".sub-value .v-click");
            oView = $(_this).parents(".sub-key").parent().find(".sub-value .v-view");
        }else{
            oAll = $(_this).parents(".wx-menu").find(".value>div");
            oSub = $(_this).parents(".wx-menu").find(".value>.v-menu");
            oClick = $(_this).parents(".wx-menu").find(".value>.v-click");
            oView = $(_this).parents(".wx-menu").find(".value>.v-view");
        }
        oAll.hide();
        if (type == 'sub1' || type == 'sub2' || type == 'sub3' || type == 'sub' ) {
            oSub.show();
        } else if(type == "click"){
            oClick.show();
        }else if(type == "view"){
            oView.show();
        }
    }

    /* 添加一级菜单 */
    function addMenu(_this) {
        var oMenu = $(".wx-menu");

        // 3个一级菜单
        if(oMenu.length >= 2){
            $(_this).hide();
        }
        if(oMenu.length >= 3){
            return false;
        }
        var bt = baidu.template;
        var html = bt('t:menu',{num: oMenu.length+1});
        if(oMenu.length == 0){
            $("#wechatMenuForm").prepend(html);
        }else{
            oMenu.last().after(html);
        }
        

        var oSelect = $(".wx-menu").last().find(".key-main select.form-control");
        typeChange(oSelect);
    }

    /* 添加二级菜单 */
    function addSubMenu(_this) {
        var oSubMenu = $(_this).parents(".v-menu");
        var oSubMenuLen = oSubMenu.find(".wx-sub-menu li").length - 1;

        // 5个二级菜单
        if(oSubMenuLen >= 4){
            $(_this).hide();
        }
        if(oSubMenuLen >= 5){
            return false;
        }
        var bt = baidu.template;
        var id = oSubMenu.parents(".wx-menu").data("id");
        var html = bt('t:sub_menu',{num: id});
        $(_this).parent().before(html);
        $(_this).removeClass("error");

        var oSelect = $(_this).parent().prev().find(".sub-key select.form-control");
        typeChange(oSelect);
    }

    /* 删除一级菜单 */
    function delMenu(_this) {
        var oMenu = $(_this).parents(".wx-menu");
        var oAdd = oMenu.siblings("a");

        oMenu.remove();
        setId();

        if(oMenu.length <= 2){
            oAdd.show();
        }
    }

    /* 删除二级菜单 */
    function delSubMenu(_this) {
        var oSubMenu = $(_this).parents("li");
        var oAdd = $(_this).parents(".wx-sub-menu").find("li").last().find('a');

        oSubMenu.remove();

        if(oSubMenu.length <= 4){
            oAdd.show();
        }
    }

    /* 删除一级菜单是更改id */
    function setId() {
        $(".wx-menu").each(function(index, el) {
            var pair = "_" + $(el).data("id"),
                rep = "_" + (index+1);
            $(el).find(".form-control").each(function(index1, el1) {
                var name = $(el1).attr("name");
                name = name.replace(pair, rep);
                $(el1).attr("name", name);
            });
        });
    }

    /* 表单验证 */
    function doValidate() {
        var success = true;

        //表单不能为空
        $(".form-control:visible").each(function(index, el) {
            var _this = $(el);
            if(_this.val() == '') {
                success = false;
                _this.addClass("error");
            }
        });

        //按钮类型为菜单对应的子菜单至少一个
        $(".v-menu:visible").each(function(index, el) {
            var _this = $(el);
            if(_this.find(".wx-sub-menu>li").length<=1) {
                success = false;
                _this.find(".wx-sub-menu>li").last().find("a").addClass("error");
            }
        });

        return success;
    }

</script>
</html>