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
                    <tr>
                        <td>subscribe</td>
                        <td>自定义关注回复</td>
                        <td><?php echo $subscribe_data['reply_type'] ?></td>
                        <td><?php echo $subscribe_data['content']; ?></td>
                        <td align="center"><a class="btn btn-save js-edit" data-id="1" href="javascript:;">修改</a></td>
                    </tr>
                    <?php if ($lists) {?>
                        <?php foreach ($lists as $reply) { ?>
                            <tr>
                                <td><?php echo $reply['event'] ?></td>
                                <td><?php echo $reply['key'] ?></td>
                                <td><?php echo $reply['reply_type'] ?></td>
                                <td><?php echo $reply['content'] ?></td>
                                <td align="center">
                                    <a class="btn btn-save js-edit" data-id="<?php echo $reply['id']; ?>" href="javascript:;">修改</a>
                                    <a class="btn btn-del js-delete" data-id="<?php echo $reply['id']; ?>" href="javascript:;">删除</a>
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
                    <td align="center">标题</td>
                    <%}else if(title[j] == "Description"){%>
                    <td align="center">描述</td>
                    <%}else if(title[j] == "Url"){%>
                    <td align="center">链接</td>
                    <%}else if(title[j] == "PicUrl"){%>
                    <td align="center" width="120">图片</td>
                <%}}%>
            </tr>
            <%for(var i=0; i<content.length; i++){%>
            <tr>
                <%for(var j=0; j<title.length; j++){%>
                    <%if(title[j] == 'PicUrl'){%>
                    <td align="center"><img src="<%= content[i][j]%>" class="reply-table-img" /></td>
                    <%}else{%>
                    <td align="center"><%= content[i][j]%></td>
                <%}}%>
            </tr>
            <%}%>
        </table>
    </script>



    <script src="//cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
    <script src="js/baiduTemplate.js"></script>
    <script src="js/jquery.form.js"></script>
    <script>
        $(function(){

            /* 跳转到修改页 */
            $(".js-edit").on('click',function () {
                var id  = $(this).data('id');
                var url = 'wx_reply.php?act=edit&id=' + id;
                window.location.href = url;
            });

            /* 删除操作 */
            $(".js-delete").on('click',function () {
                if(confirm('确定删除回复?')) {
                    $(this).html('<div class="loading"></div>');
                    var id  = $(this).data('id');
                    var url = 'wx_reply.php?act=delete&id=' + id;
                    var p = $(this).parent().parent();
                    $.getJSON(url,function (data) {
                        if (data.status) {
                            p.remove();
                        } else {
                            alert(data.info);
                            $(this).html('删除');
                        }
                    });
                }
                
            });

            // 处理回复内容的数据
            (function() {
                var bt = baidu.template;
                var otr = $(".reply-list .table tr");
                if(otr.length > 1){
                    $(".reply-list .table tr:gt(0)").each(function(index, el) {
                        var content = $(el).find("td:eq(3)");
                        try {
                            // 如果回复内容为json格式的字符串,将字符串转化为指定格式的json
                            var json = eval("("+content.html()+")");
                            var data = {},
                                contentArr = [];
                            for(var item in json) {
                                if (json[item] instanceof Object) {
                                    // for(var item2 in json[item]) {
                                    //     var titleArr = [],
                                    //         contentItem = [];
                                    //     for(var itme3 in json[item][item2]) {
                                    //         titleArr.push(itme3);
                                    //         contentItem.push(json[item][item2][itme3]);
                                    //     };
                                    //     contentArr.push(contentItem);
                                    // }
                                    var titleArr = [],
                                        contentItem = [];
                                    for(var itme3 in json[item]) {
                                        titleArr.push(itme3);
                                        contentItem.push(json[item][itme3]);
                                    };
                                    contentArr.push(contentItem);
                                }else{
                                    titleArr = ['msg'];
                                    contentArr = [[json[item]]]
                                }
                                data["title"] = titleArr;
                                data["content"] = contentArr;
                            };

                            //插入表格
                            var html = bt('t:reply_content', data);
                            content.html(html);
                        }catch(e) {
                            // 如果回复内容为不是json格式的字符串, 不做处理
                        }
                        
                    });
                }
            })();

        })
    </script>

</body>
</html>


