<?php include_once('header_web.php');?>
<?php include_once('wxshare_web.php');?>

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
                                <?php if(!empty($Objwallet['result']['openNum'])){?>
                                <p class="themeColor"><?php echo $Objwallet['result']['openNum'];?></p>
                                <?php }else{?>
                                <p class="themeColor">0</p>
                                <?php }?>
                                <p>开团数</p>
                            </li>
                            <li>
                                <?php if(!empty($Objwallet['result']['succNum'])){?>
                                <p class="themeColor"><?php echo $Objwallet['result']['succNum'];?></p>
                                <?php }else{?>
                                 <p class="themeColor">0</p>
                                <?php }?>
                                <p>成团数</p>
                            </li>
                             <li>
                                <?php if(!empty($Objwallet['result']['fzPrice'])){?>
                                <p class="themeColor"><?php echo $Objwallet['result']['fzPrice'];?></p>
                                <?php }else{?>
                                 <p class="themeColor">0</p>
                                <?php }?>
                                <p>冻结余额</p>
                            </li>
                            <li>
                                <?php if(!empty($Objwallet['result']['balance'])){?>
                                <p class="themeColor"><?php echo $Objwallet['result']['balance'];?></p>
                                <?php }else{?>
                                <p class="themeColor">0</p>
                                <?php }?>
                                <p>我的余额</p>
                            </li>
                        </ul>
                        <!-- <p class="title1">我的余额</p>
                        <p class="price1">￥<?php echo $Objwallet['result']['balance'];?></p> -->
                    </div>
                    <div class="btn">
                        <a href="/pindeke.php?act=incomes" class="red">查看明细</a>
                        <?php if($Objwallet['result']['isFrozen'] !=1){?>
                        <a href="/pindeke.php?act=withdrawals&uid=<?php echo $userid;?>" class="gray">我要提现</a>
                        <?php }else{?>
                        <a href="javascript:;" class="gray" style="background:#b5b5b6;">我要提现</a>
                        <?php }?>
                    </div>
                </section>

            </div>
        </div>
    </div>
</body>

</html>
