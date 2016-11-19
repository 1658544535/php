<?php
/**
 * Created by PhpStorm.
 * User: Jasper
 * Date: 2016/11/17 0017
 * Time: 9:42
 */
include_once('global.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/base.css" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <title>后台管理</title>
</head>
<body>
    <div class="wrap">

        <section class="index-menu">
            <ul>
                <li class="bounceInUp bounceInUp-1 animated"><a href="wx_menu.php">
                    <img src="images/index-menu-menu.png" />
                    <p>自定义菜单</p>
                </a></li>
                <li class="bounceInUp bounceInUp-2 animated"><a href="wx_reply.php">
                    <img src="images/index-menu-reply.png" />
                    <p>自定义回复</p>
                </a></li>
                <li class="bounceInUp bounceInUp-3 animated"><a href="auth.php?act=logout">
                    <img src="images/index-menu-logout.png" />
                    <p>登 出</p>
                </a></li>
            </ul>
        </section>

    </div>
</body>
</html>
