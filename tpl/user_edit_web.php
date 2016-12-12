<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>淘竹马</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="css/sm.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="js/swiper/swiper.min.css">
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/baiduTemplate.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</head>

<body>
    <div class="page-group" id="page-userInfo">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">资料编辑</h1>
                <a id="save" href="javascript:;" class="button button-link button-nav pull-right search">保存</a>
            </header>

            <div class="content native-scroll">

                <form action="user_info?act=user_edit_save" method="post" accept-charset="utf-8" id="userInfoForm" enctype="multipart/form-data">
                    <section class="pdk-form">
                        <ul>
                            <li class="photo">
                                <div class="item">
                                    <div class="label"><img id="photoView" class="img" name="userimage" src="<?php echo $info['userImage'];?>" /></div>
                                    <div class="main">
                                        <div class="txt">修改头像</div>
                                    </div>
                                    <input type="file" id="photo" class="file" accept="images/*" name="userimage" />
                                </div>
                            </li>
                            <li class="last">
                                <div class="item">
                                    <div class="label">昵称</div>
                                    <div class="main">
                                        <input id="name" type="text" name="username" class="txt" placeholder="请填写昵称" value="<?php echo $info['name'];?>">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </section>
                </form>

            </div>
            <script type='text/javascript' src='js/lrz/lrz.bundle.js' charset='utf-8'></script>
        </div>
    </div>
</body>

</html>
