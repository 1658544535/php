<?php include_once('header_web.php');?>
<?php include_once('wxshare_web.php');?>

<body>
    <div class="page-group" id="page-pdk-recordDeta">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="pindeke.php?act=withdrawals_records">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">交易详情</h1>
            </header>

            <div class="content native-scroll">
                <section class="pdkRecordDeta">
                    <ul>
	                        <li class="header">
	                            <div class="label">出账金额</div>
	                            <div class="main">￥<?php echo $Objwithdrawals['price'];?></div>
	                        </li>
	                        <li>
	                            <div class="label">类型</div>
	                            <div class="main">支出</div>
	                        </li>
	                        <li>
	                            <div class="label">申请时间</div>
	                            <div class="main"><?php echo $Objwithdrawals['date'];?></div>
	                        </li>
                        <?php if($Objwithdrawals['status'] ==3){?>
	                        <li>
	                            <div class="label">完成时间</div>
	                            <div class="main"><?php echo $Objwithdrawals['overTime'];?></div>
	                        </li>
                        <?php }?>
	                        <li>
	                            <div class="label">交易单号</div>
	                            <div class="main"><?php echo $Objwithdrawals['orderNo'];?></div>
	                        </li>
                        <?php if($Objwithdrawals['status'] ==2){?>
	                        <li>
	                            <div class="label">确认审核时间</div>
	                            <div class="main"><?php echo $Objwithdrawals['falseDate'];?></div>
	                        </li>
                        <?php }?>
                        <?php if($Objwithdrawals['status'] !=0 && $Objwithdrawals['status'] !=2){?>
	                        <li>
	                            <div class="label">剩余金额</div>
	                            <div class="main"><?php echo $Objwithdrawals['surpluPrice'];?></div>
	                        </li>
                        <?php }?>
	                        <li>
	                            <div class="label">备注</div>
	                            <div class="main"><?php echo $Objwithdrawals['remark'];?></div>
	                        </li>
                        <?php if($Objwithdrawals['status'] ==2){?>
	                        <li>
	                            <div class="label">审核不通过理由</div>
	                            <div class="main"><?php echo $Objwithdrawals['reason'];?></div>
	                        </li>
                        <?php }?>
                    </ul>
                </section>
                
            </div>
        </div>
    </div>
</body>

</html>
