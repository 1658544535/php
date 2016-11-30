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
                            <select placeholder="请选择按钮类型..." class="form-control" name="Pbutton_type_<?php echo $k+1 ?>">
                                <option value="">请选择按钮类型...</option>
                                <option value="sub" <?php if (isset($v["sub_button"]) && !empty($v["sub_button"])) echo "selected";?>>菜单</option>
                                <?php foreach ($button_type_arr as $key => $value) {  ?>
                                    <option value="<?php echo $key; ?>"  <?php if (!isset($v["sub_button"]) || empty($v["sub_button"])) { if ($v["type"] == $key) echo "selected"; } ?>><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                            <a class="btn btn-del" href="javascript:;" title="删 除">删 除</a>
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
                                                    <select class="form-control" name="Cbutton_types_<?php echo $k+1 ?>[]">
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
                                                    <a class="btn btn-del" href="javascript:;" title="删 除">删 除</a>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                                <li>
                                    <a class="btn btn-add" href="javascript:;">添 加</a>
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
                    <a class="btn btn-add" href="javascript:;">添 加</a>
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
                    <select placeholder="请选择按钮类型..." class="form-control" name="Pbutton_type_<%= num%>">
                        <option value="">请选择按钮类型...</option>
                        <option value="sub">菜单</option>
                        <?php foreach ($button_type_arr as $key => $value) {  ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                    <a class="btn btn-del" href="javascript:;" title="删 除">删 除</a>
                </div>
            </dt>
            <dd class="value clearfix">
                <div class="v-menu">
                    <ul class="wx-sub-menu">
                        <li>
                            <a class="btn btn-add" href="javascript:;">添 加</a>
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
                <select class="form-control" name="Cbutton_types_<%= num%>[]">
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
                <a class="btn btn-del" href="javascript:;" title="删 除">删 除</a>
            </div>
        </li>
    </script>

    <script src="js/require.js" data-main="js/app/menu"></script>

</body>
</html>