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

<div class="text-reply">
    <table border="1">
        <tr>
            <th>关键字</th>
            <th>回复内容</th>
            <th>操作</th>
        </tr>

        <?php if ($lists) {?>
            <?php foreach ($lists as $reply) { ?>

                <tr>
                    <td><?php echo $reply['keyword'] ?></td>
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

<hr>

<div class="event-reply">
    <form action="wx_reply.php?act=update&type=event" id="subReplyForm" method="post">
        <p>关注自定义回复：<button type="submit">保存</button></p>
        <input type="hidden" value="subscribe" name="event_name" readonly>
        <textarea name="reply_content" id="" cols="30" rows="10"><?php echo $subscribe_data['content']; ?></textarea>
     </form>
</div>

</body>
<script src="//cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
<script src="../js/jquery.form.js"></script>
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
        $.getJSON(url,function (data) {
            alert(data.info);
        });
    })

    /* ajax form */
    $('#subReplyForm').ajaxForm({
        success: function (data) {
            data = eval("(" + data + ")");
            if (data.status) {
                alert(data.info);
            } else {
                console.log(data);
            }
        }
    });

</script>
</html>


