<?php include_once('header_web.php');?>
<?php include_once('wxshare_web.php');?>

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
