<?php include_once('header_web.php');?>
<?php include_once('wxshare_web.php');?>

<body>
    <div class="page-group" id="page-userSet">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="user.php">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">设置</h1>
            </header>

            <div class="content native-scroll">

                <section class="pdk-form">
                    <ul>
                        <li><a href="user_set.php?act=user_coupon">
                            <div class="item">
                                <div class="label">周边</div>
                                <div class="main">&nbsp;</div>
                            </div>
                        </a></li>
                        <li><a href="user_set.php?act=about">
                            <div class="item">
                                <div class="label">关于拼得好</div>
                                <div class="main">&nbsp;</div>
                            </div>
                        </a></li>
                        <li class="last"><a href="user_wallet.php?act=wallet">
                            <div class="item">
                                <div class="label">兑换礼券</div>
                                <div class="main">&nbsp;</div>
                            </div>
                        </a></li>
                    </ul>
                </section>

            </div>
        </div>
    </div>
</body>

</html>
