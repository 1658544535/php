<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>微信自定义回复</title>
</head>
<body>
<?php if (isset($isEdit)) {?>
    <form action="wx_reply.php?act=update&id=<?php echo $edit_id; ?>" method="post" id="myForm">
<?php } else { ?>
    <form action="wx_reply.php?act=insert" method="post" id="myForm">
<?php }?>

    <div>
        <table>
            <tr>
                <th>key值:</th>
                <th>
                    <input type="text" name="key" placeholder="多个关键字，请用空格隔开" value="<?php if (isset($isEdit)) echo $data['key'] ;?>" <?php if (isset($isEdit)) echo 'readonly' ;?>>
                </th>
            </tr>
            <tr>
                <th>事件类型:</th>
                <th>
                    <select name="event" placeholder="">
                        <option value="">请选择自定义回复类型</option>
                        <?php foreach ($options_arr as $key => $val) { ?>
                            <option value="<?php echo $key;?>"<?php if (isset($isEdit)) { if ($data['event'] == $key) echo "selected"; } ?>>
                                <?php echo $val;?>
                            </option>
                        <?php } ?>
                    </select>
                </th>
            </tr>
            <tr>
                <th>回复内容：</th>
                <th>
                    <textarea name="content" cols="30" rows="10" placeholder="请输入自定义回复的内容"><?php if (isset($isEdit)) echo $data['content'] ;?></textarea>
                </th>
            </tr>
        </table>
    </div>

<?php if (isset($isEdit)) {?>
    <button type="submit">保存修改</button>
<?php } else { ?>
    <button type="submit">新建并保存</button>
<?php }?>
    <button type="button" onclick="history.go(-1)">返回</button>

</form>

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
</script>
</html>

