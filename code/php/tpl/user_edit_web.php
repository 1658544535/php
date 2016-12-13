<?php include_once('header_web.php');?>
<?php include_once('wxshare_web.php');?>

<body>
    <div class="page-group" id="page-userInfo">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="user.php">
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
                                    <input type="file" id="photo" class="file" capture="camera" name="userimage" />
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
