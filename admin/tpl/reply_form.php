<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>微信自定义回复</title>
    <link rel="stylesheet" type="text/css" href="css/base.css" />
    <link rel="stylesheet" type="text/css" href="css/content.css" />
</head>
<body>

    <div class="wrap">

        <section class="header bounceInUp bounceInUp-1 animated">
            <div class="logo"><a href="index.php">拼得好</a></div>
            <ul class="menu">
                <li><a href="wx_menu.php">
                    <img src="images/index-menu-menu.png" />
                    <p>自定义菜单</p>
                </a></li>
                <li><a class="active" href="wx_reply.php">
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
            <form class="reply_form" action="<?php echo (isset($isEdit)) ? 'wx_reply.php?act=update&id='. $edit_id : 'wx_reply.php?act=insert' ?>" method="post" id="myForm">
                <dl>
                    <?php if (isset($edit_id) && $edit_id == 1) { ?>
                    <dt class="label">关注自定义回复</dt>
                    <dd class="main"><input  class="form-control" type="text" name="key" placeholder="多个关键字，请用空格隔开" value="<?php if (isset($isEdit)) echo $data['key'] ;?>" <?php if (isset($isEdit)) echo 'readonly' ;?>></dd>
                    <?php } else { ?>
                    <dt class="label">key值</dt>
                    <dd class="main"><input class="form-control" type="text" name="key" placeholder="多个关键字，请用空格隔开" value="<?php if (isset($isEdit)) echo $data['key'] ;?>" ></dd>
                    <?php } ?>
                </dl>
                <dl>
                    <dt class="label">回复类型</dt>
                    <dd class="main">
                        <select id="replay_type" class="form-control" name="replyType" onchange="typeChange(this)">
                            <option value="">请选择自定义回复类型</option>
                            <option value="text" <?php echo (isset($isEdit) && $replyType == 'text') ? 'selected' : '' ?>>文本回复</option>
                            <option value="news" <?php echo (isset($isEdit) && $replyType == 'news') ? 'selected' : '' ?>>图文回复</option>
                        </select>
                    </dd>
                </dl>
                <dl style="<?php if (isset($edit_id) && $edit_id == 1) echo 'display:none;'; ?>">
                    <dt class="label">事件类型</dt>
                    <dd class="main">
                        <select class="form-control" name="event" placeholder="">
                            <option value="">请选择触发事件类型</option>
                            <?php foreach ($options_arr as $key => $val) { ?>
                                <option value="<?php echo $key;?>"<?php if (isset($isEdit)) { if ($data['event'] == $key) echo "selected"; } ?>>
                                    <?php echo $val;?>
                                </option>
                            <?php } ?>
                        </select>
                    </dd>
                </dl>
                <dl id="v-text">
                    <dt class="label">回复内容</dt>
                    <dd class="main">
                        <textarea class="form-control" name="content" rows="4" placeholder="请输入自定义回复的内容"><?php if (isset($isEdit)) { echo ($replyType == 'text') ?  $replyContent[0] : '' ; }?></textarea>
                    </dd>
                </dl>
                <dl id="v-news">
                    <dt class="label">图文回复</dt>
                    <dd class="main">
                        <?php if (isset($isEdit) && $replyType == 'news') { ?>
                            <?php foreach ($replyContent as $item) { ?>
                            <ul class="reply_form2">
                                <li class="clearfix">
                                    <div class="label">标题</div>
                                    <div class="main"><input class="form-control" type="text" name="title[]" value="<?php echo $item['Title']; ?>"></div>
                                </li>
                                <li class="clearfix">
                                    <div class="label">描述</div>
                                    <div class="main"><input class="form-control" type="text" name="desc[]" value="<?php echo $item['Description']; ?>"></div>
                                </li>
                                <li class="clearfix">
                                    <div class="label">链接</div>
                                    <div class="main"><input class="form-control" type="text" name="url[]" value="<?php echo $item['Url']; ?>"></div>
                                </li>
                                <li class="clearfix">
                                    <div class="label">图片链接</div>
                                    <div class="main">
                                        <div class="upLoadImg has">
                                            <input class="file" type="file" name="pic[]">
                                            <div class="view"><img src="<?php echo $item['PicUrl']; ?>" /></div>
                                        </div>
                                    </div>
                                </li>
                                <li class="del" onclick="delNews(this)"><span></span></li>
                            </ul>
                            <?php } ?>
                        <?php } ?>
                        <a id="news-add" href="javascript:" class="btn btn-add" onclick="addNews(this)">添加</a>
                    </dd>
                </dl>
                <dl class="submit">
                    <dt class="label"> </dt>
                    <dd class="main">
                        <input class="btn btn-save" type="submit" value="<?php echo (isset($isEdit)) ? '保存修改' : '新建并保存';?>" />
                        <input class="btn btn-cancel" type="button" onclick="history.go(-1)" value="返回" />
                    </dd>
                    <div class="loading hide"></div>
                </dl>
            </form>
        </section>

        <section class="reply-tips bounceInUp bounceInUp-3 animated">
            <h2>说明</h2>
            <ul class="list">
                <li>
                    <h3 class="title">文本</h3>key值填入关键字（唯一，不可重复。可存在多个关键字，关键字之间用空格隔开。）
                </li>
                <li>
                    <h3 class="title">扫码</h3>
                    key值填入 qrcodesenceID（唯一，不可重复。） <br>
                    当用户已经关注公众号，扫描相关二维码的时候 <br>
                    回复该二维码的qrcodesenceID对应的回复内容。
                </li>
                <li>
                    <h3 class="title">扫码关注</h3>
                    key值填入 qrcodesenceID（唯一，不可重复。） <br>
                    当用户扫描二维码时没有关注该公众号时，回复该 qrcodesenceID 相对应的回复内容
                </li>
                <li>
                    <h3 class="title">点击</h3>
                    点击事件。Key值填入键值（唯一，不可重复。与自定义菜单那边键值相对应） <br>
                    当用户点击相对应的按钮时回复相对键值的回复内容。
                </li>
            </ul>
        </section>

        <section class="reply-tips bounceInUp bounceInUp-3 animated">
            <h2>链接说明：</h2>
            <ul class="list">
                <li>添加链接： &lt;a href=&quot;链接地址&quot;&gt;显示的文字&lt;/a&gt;</li>
                <li>首页: http://weixin.pindegood.com</li>
                <li>团免券激活领取: http://weixin.pindegood.com/free.php?id=团免券链接id</li>
                <li>优惠券领取: http://weixin.pindegood.com/coupon_action.php?linkid=链接id&aid=活动id</li>
            </ul>
        </section>

    </div>

    <script id="t:news-item" type="text/html">
        <ul class="reply_form2">
            <li class="clearfix">
                <div class="label">标题</div>
                <div class="main"><input class="form-control" type="text" name="title[]" value=""></div>
            </li>
            <li class="clearfix">
                <div class="label">描述</div>
                <div class="main"><input class="form-control" type="text" name="desc[]" value=""></div>
            </li>
            <li class="clearfix">
                <div class="label">链接</div>
                <div class="main"><input class="form-control" type="text" name="url[]" value=""></div>
            </li>
            <li class="clearfix">
                <div class="label">图片链接</div>
                <div class="main">
                    <div class="upLoadImg">
                        <input class="file" type="file" name="pic[]">
                        <div class="view"><img src="" /></div>
                    </div>
                </div>
            </li>
            <li class="del" onclick="delNews(this)"><span></span></li>
        </ul>
    </script>

    <script src="//cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
    <script src="js/baiduTemplate.js"></script>
    <script src="js/jquery.form.js"></script>
    <script>
        $(function(){
            // 显示回复类型相应的内容
            typeChange($("#replay_type"));

            // 图片预览
            $(document).on("change", ".upLoadImg input.file", function(){
                var _this = $(this);
                var url = _this.val();
                if (window.createObjectURL != undefined) { // basic
                    url = window.createObjectURL(_this.get(0).files[0]);
                } else if (window.URL != undefined) { // mozilla(firefox)
                    url = window.URL.createObjectURL(_this.get(0).files[0]);
                } else if (window.webkitURL != undefined) { // webkit or chrome
                    url = window.webkitURL.createObjectURL(_this.get(0).files[0]);
                }
                _this.next().children('img').attr("src", url);
                _this.parent().addClass("has");
                $(_this).parent().removeClass("error");
            });

            $(document).on("change", ".form-control", function(){
                if($(this).val() != '') {
                    $(this).removeClass("error");
                }
            });
            $('#myForm').on("submit", function(){
                var _this = $(this);
                $(".form-control:hidden").each(function(index, el) {
                    if($(el).is(":hidden") || $(el).parent().is(":hidden")){
                        $(el).attr("disabled", true);
                    }
                });
                if(doValidate()){
                    _this.find(".submit .loading").show();
                    _this.find(".submit .main").hide();
                    _this.ajaxSubmit({
                        success: function (data) {
                            data = eval("(" + data + ")");
                            if (data.status) {
                                history.go(-1);
                            } else {
                                alert(data.info);
                                _this.find(".submit .loading").hide();
                                _this.find(".submit .main").show();
                            }
                        }
                    });
                }
                $(".form-control").attr("disabled", false);
                return false;
            });
        });

        /* 回复类型切换显示相应的内容 */
        function typeChange(_this) {
            var type = $(_this).val(),
                oText = $("#v-text"),
                oNews = $("#v-news");
            switch (type) {
                case "text": 
                    oText.show();
                    oNews.hide();
                    break;
                case "news": 
                    oText.hide();
                    oNews.show();
                    break;
                default: 
                    oText.hide();
                    oNews.hide();
                    break;
            }
        }

        /* 添加新闻回复 */
        function addNews(_this){
            var num = $("#v-news .reply_form2").length;
            var bt = baidu.template;
            var html = bt('t:news-item',{});
            $(_this).before(html);
            $("#news-add").removeClass("error");
            if(num >= 7){
                $(_this).hide();
            }
        }

        /* 删除新闻回复 */
        function delNews(_this){
            var num = $("#v-news .reply_form2").length;
            $(_this).parent().remove();
            if(num <= 8){
                $("#news-add").show();
            }
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
            if($("#v-news").is(":visible") && $("#v-news .reply_form2").length <= 0){
                success = false;
                $("#news-add").addClass("error");
            }

            // 图片必须选
            $(".upLoadImg").each(function(index, el) {
                if(!$(el).hasClass("has")) {
                    success = false;
                    $(el).addClass("error");
                }
            });

            return success;
        }
    </script>

</body>

</html>

