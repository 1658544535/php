<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="//cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
    <title>自定义回复列表</title>
</head>
<body>

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
            <button class="js-edit"   data-id="<?php echo $reply['id']; ?>">修改</button>
            <button class="js-delete" data-id="<?php echo $reply['id']; ?>">删除</button>
        </td>
    </tr>

    <?php } ?>
<?php } else { ?>
    暂时没有自定义回复
<?php } ?>

</table>

<a href="wx_reply.php?act=create">新建</a>

</body>

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

</script>
</html>


