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
    <div class="page-group" id="page-pdeForm">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="user.php">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">我的信息</h1>
            </header>

            <div class="content native-scroll">
<?php if($Objinfo['status'] ==1){?>
                <section class="pdk-form">
                    <ul>
                        <li>
                            <div class="item">
                                <div class="label">真实姓名</div>
                                <div class="main">
                                    <div class="txt"><?php echo $Objinfo['name'];?></div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item">
                                <div class="label">手机号码</div>
                                <div class="main">
                                    <div class="txt"><?php echo $Objinfo['phone'];?></div>
                                </div>
                            </div>
                        </li>
                        <li class="last">
                            <div class="item">
                                <div class="label">身份证号码</div>
                                <div class="main">
                                    <div class="txt"><?php echo $Objinfo['cardNo'];?></div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item">
                                <div class="label">推广渠道</div>
                                <div class="main">
                                    <div class="txt"><?php echo $Objinfo['channel'];?></div>
                                </div>
                            </div>
                        </li>
                        <?php if(($Objinfo['image1']!='') || ($Objinfo['image2']!='') || ($Objinfo['image3']!='') || ($Objinfo['image4']!='') || ($Objinfo['image5']!='')){ ?>
                        <li class="last">
                            <div class="item">
                                <div class="label">推广证明</div>
                            </div>
                            <div class="uploadImg">
                            <?php for($i=1; $i<=5; $i++){ ?>
                                <?php if($Objinfo['image'.$i] != ''){ ?>
	                                <div class="uploadImg-item">
	                                    <div class="img"><img data-file="res.msg" data-src="#" src="<?php echo $Objinfo['image'.$i];?>"></div>
	                                </div>
                                <?php } ?>
							<?php } ?>
                            </div>
                        </li>
                    <?php }?>
                    </ul>
                </section>
<?php }elseif(($Objinfo['status'] ==0) || ($Objinfo['status'] ==2)){?>
                <section class="pdk-form">
                    <ul>
                        <li>
                            <div class="item">
                                <div class="label">真实姓名</div>
                                <div class="main">
                                    <div class="txt"><?php echo $Objinfo['name'];?></div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item">
                                <div class="label">手机号码</div>
                                <div class="main">
                                    <div class="txt"><?php echo $Objinfo['phone'];?></div>
                                </div>
                            </div>
                        </li>
                        <li class="last">
                            <div class="item">
                                <div class="label">身份证号码</div>
                                <div class="main">
                                    <div class="txt"><?php echo $Objinfo['cardNo'];?></div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item">
                                <div class="label">推广渠道</div>
                                <div class="main">
                                    <div class="txt"><?php echo $Objinfo['channel'];?></div>
                                </div>
                            </div>
                        </li>
                         <?php if(($Objinfo['image1']!='') || ($Objinfo['image2']!='') || ($Objinfo['image3']!='') || ($Objinfo['image4']!='') || ($Objinfo['image5']!='')){ ?>
                        <li class="last">
                            <div class="item">
                                <div class="label">推广证明</div>
                            </div>
                            <div class="uploadImg">
                            <?php for($i=1; $i<=5; $i++){ ?>
                                <?php if($Objinfo['image'.$i] != ''){ ?>
	                                <div class="uploadImg-item">
	                                    <div class="img"><img data-file="res.msg" data-src="#" src="<?php echo $Objinfo['image'.$i];?>"></div>
	                                </div>
                                <?php } ?>
							<?php } ?>
                            </div>
                        </li>
                    <?php }?>
                    </ul>
                </section>
                
                <section class="pdk-state">
                    <h3 class="title1">审核信息</h3>
                    <?php if($Objinfo['status'] ==0){?>
                    <div class="txt">当前状态：<span class="themeColor">信息审核中...</span></div>
                    <?php }elseif($Objinfo['status'] ==2){?>
                    <div class="txt">当前状态：<span class="themeColor">审核不通过</span></div>
                    <div class="txt">不通过原因：<span class="themeColor"><?php echo $Objinfo['returnMsg'] ;?></span></div>
                    <?php }?>
                </section>
                 <?php if($Objinfo['status'] ==2){?>
                <div class="placeholder-50"></div>
                <div class="pdk-submit">
                    <input type="button" onClick="location.href='/pindeke_apply.php?act=edit&uid=<?php echo $userid;?>&id=<?php echo $Objinfo['pdkId'];?>'" value="重新提交信息" />
                </div>
                <?php }?>
<?php }?>
                <div class="placeholder-50"></div>
               <!--  <div class="pdk-submit">
                    <input type="button" onClick="location.href='/pindeke.php?act=pdkInfo_edit'" value="点击修改信息" />
                </div>-->

            </div>
        </div>
    </div>
</body>

</html>
