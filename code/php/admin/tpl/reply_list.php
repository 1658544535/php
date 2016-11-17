<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>自定义回复列表</title>
</head>
<body>

<a href="index.php">主页</a>
<a href="wx_menu.php">自定义菜单</a>
<a href="auth.php?act=logout">登出</a>

<div class="text-reply">
    <table border="1">
        <tr>
            <th>类型</th>
            <th>key值</th>
            <th>回复内容</th>
            <th>操作</th>
        </tr>

        <tr>
            <td>subscribe</td>
            <td>自定义关注回复</td>
            <td><?php echo $subscribe_data['content']; ?></td>
            <td><button class="js-edit"   data-id="1" type="button">修改</button></td>
        </tr>

        <?php if ($lists) {?>
            <?php foreach ($lists as $reply) { ?>

                    <tr>
                        <td><?php echo $reply['event'] ?></td>
                        <td><?php echo $reply['key'] ?></td>
                        <td><?php echo $reply['content'] ?></td>
                        <td>
                            <button class="js-edit"   data-id="<?php echo $reply['id']; ?>" type="button">修改</button>
                            <button class="js-delete" data-id="<?php echo $reply['id']; ?>" type="button">删除</button>
                        </td>
                    </tr>

            <?php } ?>
        <?php } else { ?>
            暂时没有自定义回复
        <?php } ?>

    </table>

</div>
<a href="wx_reply.php?act=create">新建</a>



</body>
<script src="//cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
<script src="js/jquery.form.js"></script>
<script>

    /* 跳转到修改页 */
    $(".js-edit").on('click',function () {
        var id  = $(this).data('id');
        var url = 'wx_reply.php?act=edit&id=' + id;
        window.location.href = url;
    });

    /* 删除操作 */
    $(".js-delete").on('click',function () {
        var id  = $(this).data('id');
        var url = 'wx_reply.php?act=delete&id=' + id;
        var p = $(this).parent().parent();
        $.getJSON(url,function (data) {
            if (data.status) {
                p.remove();
            } else {
                alert(data.info);
                console.log(data);
            }
        });
    });

</script>
</html>


