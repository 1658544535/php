<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>拼得好</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="css/sm.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="js/swiper/swiper.min.css">
    <script type='text/javascript' src='js/jquery-2.1.4.min.js' charset='utf-8'></script>
    <script>jQuery.noConflict()</script>
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/baiduTemplate.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</head>

<body>
<div class="page-group" id="page-message">
    <div id="page-nav-bar" class="page page-current">
        <header class="bar bar-nav">
            <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                <span class="icon icon-back"></span>
            </a>
            <h1 class="title">消息</h1>
        </header>

        <?php include_once ('./tpl/footer_nav_web.php'); //引入底部导航 ?>

        <div class="content native-scroll">
            <section class="message-type">
                <ul>
                    <?php foreach ($MessageList as $item) { ?>
                        <li>
                            <a href="message.php?act=scroll&type=<?php echo $item['type'];?>">
                                <div class="img"><img src="<?php echo $item['images'];?>" /><span class="new"></span></div>
                                <div class="info">
                                    <h3 class="title1"><?php echo $item['name'];?></h3>
                                    <p class="txt"><?php echo $item['title'];?></p>
                                </div>
                                <span class="time"><?php echo $item['time'];?></span>
                            </a>
                        </li>
                    <?php } ?>
<!---->
<!--                    <li><a href="#">-->
<!--                            <div class="img"><img src="images/message2.png" /></div>-->
<!--                            <div class="info">-->
<!--                                <h3 class="title1">每日推荐</h3>-->
<!--                                <p class="txt">1元！小狗智能扫地机器人，小....</p>-->
<!--                            </div>-->
<!--                            <span class="time">16-10-08</span>-->
<!--                        </a></li>-->
<!--                    <li><a href="#">-->
<!--                            <div class="img"><img src="images/message3.png" /></div>-->
<!--                            <div class="info">-->
<!--                                <h3 class="title1">订单消息</h3>-->
<!--                                <p class="txt">抽奖团！您已经开团....</p>-->
<!--                            </div>-->
<!--                            <span class="time">16-04-20</span>-->
<!--                        </a></li>-->
                </ul>
            </section>
        </div>

    </div>
</div>
</body>

</html>
