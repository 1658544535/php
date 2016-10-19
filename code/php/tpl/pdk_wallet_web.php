<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $site_name;?></title>
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
    <div class="page-group" id="page-pdk-wallet">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="user.php">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">我的钱包</h1>
            </header>

            <div class="content native-scroll">

                <section class="pdk-wallet">
                    <div class="icon"></div>
                    <div class="price">
                        <ul>
                            <li>
                                <p class="themeColor">10</p>
                                <p>开团数</p>
                            </li>
                            <li>
                                <p class="themeColor">8</p>
                                <p>成团数</p>
                            </li>
                            <li>
                                <p class="themeColor"><?php echo $Objwallet['result']['balance'];?></p>
                                <p>我的余额</p>
                            </li>
                        </ul>
                        <!-- <p class="title1">我的余额</p>
                        <p class="price1">￥<?php echo $Objwallet['result']['balance'];?></p> -->
                    </div>
                    <div class="btn">
                        <a href="/pindeke.php?act=incomes" class="red">查看明细</a>
                        <a href="/pindeke.php?act=withdrawals&uid=<?php echo $userid;?>" class="gray">我要提现</a>
                    </div>
                </section>

            </div>
        </div>
    </div>
</body>

</html>
