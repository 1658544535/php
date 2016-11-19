<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>微信自定义回复</title>
    <style>
        table{
            text-align: left;
        }
    </style>
</head>
<body>

<form action="<?php echo (isset($isEdit)) ? 'wx_reply.php?act=update&id='. $edit_id : 'wx_reply.php?act=insert' ?>" method="post" id="myForm">

    <div>
        <table>
            <?php if (isset($edit_id) && $edit_id == 1) { ?>
                <tr>
                    <th>关注自定义回复</th>
                    <th>
                        <input type="hidden" name="key" placeholder="多个关键字，请用空格隔开" value="<?php if (isset($isEdit)) echo $data['key'] ;?>" <?php if (isset($isEdit)) echo 'readonly' ;?>>
                    </th>
                </tr>
            <?php } else { ?>
                <tr>
                    <th>key值:</th>
                    <th>
                        <input type="text" name="key" placeholder="多个关键字，请用空格隔开" value="<?php if (isset($isEdit)) echo $data['key'] ;?>" >
                    </th>
                </tr>
            <?php } ?>
            <tr>
                <th>回复类型：</th>
                <th>
                    <select name="replyType" onchange="changeReplyType(this)">
                        <option value="">请选择自定义回复类型</option>
                        <option value="text" <?php echo (isset($isEdit) && $replyType == 'text') ? 'selected' : '' ?>>文本回复</option>
                        <option value="news" <?php echo (isset($isEdit) && $replyType == 'news') ? 'selected' : '' ?>>图文回复</option>
                    </select>
                </th>
            </tr>

            <tr style="<?php if (isset($edit_id) && $edit_id == 1) echo 'display:none;'; ?>">
                <th>事件类型:</th>
                <th>
                    <select name="event" placeholder="">
                        <option value="">请选择触发事件类型</option>
                        <?php foreach ($options_arr as $key => $val) { ?>
                            <option value="<?php echo $key;?>"<?php if (isset($isEdit)) { if ($data['event'] == $key) echo "selected"; } ?>>
                                <?php echo $val;?>
                            </option>
                        <?php } ?>
                    </select>
                </th>
            </tr>
        </table>

        <table class="js-text" style="<?php if (isset($isEdit)) { echo ($replyType == 'news') ? 'display: none;':''; } ?>">
            <tr class="js-text">
                <th>回复内容：</th>
                <th>
                    <textarea class="js-text-input" name="content" cols="80" rows="5" placeholder="请输入自定义回复的内容"><?php if (isset($isEdit)) { echo ($replyType == 'text') ?  $replyContent['msg'] : '' ; }?></textarea>
                </th>
            </tr>
        </table>

        <?php if (isset($isEdit) && $replyType == 'news') { ?>
            <?php foreach ($replyContent as $item) { ?>
                <hr>
                <table class="js-news" style="<?php if (isset($isEdit)) { echo ($replyType == 'text') ? 'display: none;':''; } ?>">
                    <tr class="js-news">
                        <th>标题：</th>
                        <th><input class="js-news-input" type="text" name="title[]" value="<?php echo $item['Title']; ?>"></th>
                    </tr>

                    <tr>
                        <th>描述：</th>
                        <th><input class="js-news-input" type="text" name="desc[]" value="<?php echo $item['Description']; ?>"></th>
                    </tr>

                    <tr>
                        <th>链接：</th>
                        <th><input class="js-news-input" type="text" name="url[]" value="<?php echo $item['Url']; ?>"></th>
                    </tr>

                    <tr>
                        <th>图片链接：</th>
                        <th><input class="js-news-input" type="text" name="picurl[]" value="<?php echo $item['PicUrl']; ?>"></th>
                    </tr>
                </table>

            <?php } ?>
        <?php } ?>


        <a href="javascript:" class="js-news js-news-input js-news-add" style="display: none;" onclick="addNewsInput(this)">添加</a>
    </div>

    <button type="submit"><?php echo (isset($isEdit)) ? '保存修改' : '新建并保存';?></button>
    <button type="button" onclick="history.go(-1)">返回</button>

</form>

    <div class="README">
        <h2>说明：</h2>
        <ul>
            <li>文本 <br>
                key值填入关键字（唯一，不可重复。可存在多个关键字，关键字之间用空格隔开。） <br>
            </li>
            <li>扫码 <br>
                key值填入 qrcodesenceID（唯一，不可重复。） <br>
                当用户已经关注公众号，扫描相关二维码的时候 <br>
                回复该二维码的qrcodesenceID对应的回复内容。</li>
            <li>扫码关注 <br>
                key值填入 qrcodesenceID（唯一，不可重复。） <br>
                当用户扫描二维码时没有关注该公众号时，回复该 qrcodesenceID 相对应的回复内容</li>
            <li>点击 <br>
                点击事件。Key值填入键值（唯一，不可重复。与自定义菜单那边键值相对应） <br>
                当用户点击相对应的按钮时回复相对键值的回复内容。</li>
        </ul>
    </div>

    <hr>

    <h2>链接说明：</h2>
    <p>添加链接： &lt;a href=&quot;链接地址&quot;&gt;显示的文字&lt;/a&gt;</p>
    <p>首页: http://weixin.pindegood.com </p>
    <p>团免券激活领取: http://weixin.pindegood.com/free.php?id=团免券链接id</p>
    <p>优惠券领取: http://weixin.pindegood.com/coupon_action.php?linkid=链接id&aid=活动id</p>

</body>

<script src="//cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
<script src="js/jquery.form.js"></script>
<script>
    $('#myForm').ajaxForm({
        success: function (data) {
            data = eval("(" + data + ")");
            if (data.status) {
                history.go(-1);
            } else {
                alert(data.info)
            }
        }
    });
    
    function changeReplyType(_this) {
        var type = $(_this).val();
        if (type == 'text') {
            $('.js-news').hide();
            $('.js-news-input').attr('disabled', true);
            $('.js-text').show();
            $('.js-text-input').attr('disabled', false);
        }
        if (type == 'news'){
            $('.js-text').hide();
            $('.js-text-input').attr('disabled', true);
            $('.js-news').show();
            if($("table.js-news").length>7) {
                $(".js-news-add").hide();
            }
            $('.js-news-input').attr('disabled', false);
        }
    }

    function addNewsInput(_this) {
        if($("table.js-news").length>=7) {
            $(".js-news-add").hide();
        }
        var html = '<hr class="js-news"><table class="js-news"><tr class="js-news"><th>标题：</th><th><input class="js-news-input" type="text" name="title[]"></th> </tr> <tr> <th>描述：</th> <th><input class="js-news-input" type="text" name="desc[]"></th> </tr> <tr> <th>链接：</th> <th><input class="js-news-input" type="text" name="url[]"></th></tr><tr><th>图片链接：</th> <th><input class="js-news-input" type="text" name="picurl[]"></th></tr></table>';
        $(_this).before(html);
    }
</script>
</html>

