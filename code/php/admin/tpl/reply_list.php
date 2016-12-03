<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/base.css" />
    <link rel="stylesheet" type="text/css" href="css/content.css" />
    <title>自定义回复列表</title>
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
            <div class="reply-list">
                <table class="table">
                    <tr>
                        <th align="left" width="120">类型</th>
                        <th align="left" width="120">key值</th>
                        <th align="left" width="80">回复类型</th>
                        <th align="left">回复内容</th>
                        <th align="center" width="120">操作</th>
                    </tr>
                    <?php if (!empty($lists)) {?>
                        <?php foreach ($lists as $reply) { ?>
                            <tr>
                                <td><?php echo ($reply['id'] !== 1) ? $reply['event'] : 'subscribe';?></td>
                                <td><?php echo ($reply['id'] !== 1) ? $reply['key'] : '自定义关注回复'; ?></td>
                                <td><?php echo $reply['reply_type']; ?></td>
                                <td><?php echo $reply['content']; ?></td>
                                <td align="center">
                                    <a class="btn btn-save js-edit" data-id="<?php echo $reply['id']; ?>" href="javascript:;">修改</a>
                                    <?php if ($reply['id'] !== 1) { ?>
                                        <a class="btn btn-del js-delete" data-id="<?php echo $reply['id']; ?>" href="javascript:;">删除</a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="4" align="center" style="padding: 40px 8px;">暂时没有自定义回复</td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <?php if($totalPage>1){
                echo $nav; //输出分页
            }?>

            <div class="form-submit">
                <a class="btn btn-add" href="wx_reply.php?act=create">新建</a>
            </div>

        </section>

    </div>

    <script id="t:reply_content" type="text/html">
        <table class="table table-reply">
            <tr>
                <%for(var j=0; j<title.length; j++){%>
                    <%if(title[j] == "Title"){%>
                    <td>标题</td>
                    <%}else if(title[j] == "Description"){%>
                    <td>描述</td>
                    <%}else if(title[j] == "Url"){%>
                    <td>链接</td>
                    <%}else if(title[j] == "PicUrl"){%>
                    <td width="120">图片</td>
                <%}}%>
            </tr>
            <%for(var i=0; i<content.length; i++){%>
            <tr>
                <%for(var j=0; j<title.length; j++){%>
                    <%if(title[j] == 'PicUrl'){%>
                    <td><img src="<%= content[i][j]%>" class="reply-table-img" /></td>
                    <%}else{%>
                    <td><%= content[i][j]%></td>
                <%}}%>
            </tr>
            <%}%>
        </table>
    </script>

    <script src="js/require.js" data-main="js/app/reply_list"></script>

</body>
</html>


