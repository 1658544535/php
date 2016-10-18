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
    <script type='text/javascript' src='js/sui/sm.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</head>

<body>
    <div class="page-group" id="page-pdk-recordDeta">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="pindeke.php?act=incomes">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">交易详情</h1>
            </header>

            <div class="content native-scroll">
                <section class="pdkRecordDeta">
                    <ul>
                        <li class="header">
                            <div class="label">入账金额</div>
                            <div class="main">￥<?php echo $Objincome['result']['price'];?></div>
                        </li>
                        <li>
                            <div class="label">类型</div>
                            <div class="main">收入</div>
                        </li>
                        <li>
                            <div class="label">时间</div>
                            <div class="main"><?php echo $Objincome['result']['date'];?></div>
                        </li>
                        <li>
                            <div class="label">剩余金额</div>
                            <div class="main"><?php echo $Objincome['result']['surpluPrice'];?></div>
                        </li>
                        <li>
                            <div class="label">备注</div>
                            <div class="main"><?php echo $Objincome['result']['remark'];?></div>
                        </li>
                    </ul>
                </section>
                
            </div>
        </div>
    </div>
</body>

</html>
