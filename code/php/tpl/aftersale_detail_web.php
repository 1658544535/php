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
    <?php include_once('wxshare_web.php');?>
</head>

<body>
    <div class="page-group" id="page-afterSales">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">售后详情</h1>
            </header>

            <div class="content native-scroll bgWhite">

                <section class="afterSales-form">
                    <ul>
                        <li>
                            <div class="item">
                                <div class="label">
                                    退款类型
                                </div>
                                <div class="main"><?php echo $mapType[$info['type']];?></div>
                            </div>
                        </li>
                        <li>
                            <div class="item">
                                <div class="label">
                                    退款金额
                                </div>
                                <div class="main themeColor">￥<?php echo $info['refundPrice'];?></div>
                            </div>
                        </li>
                        <li>
                            <div class="item">
                                <div class="label">
                                    退款原因
                                </div>
                                <div class="main"><?php echo $mapReason[$info['refundType']];?></div>
                            </div>
                        </li>
                        <li>
                            <div class="item">
                                <div class="label">
                                    商品描述
                                </div>
                                <div class="main"><?php echo $info['remarks'];?></div>
                            </div>
                        </li>
                        <li>
                            <div class="item">
                                <div class="label">
                                    联系方式
                                </div>
                                <div class="main"><?php echo $info['phone'];?></div>
                            </div>
                        </li>
						<?php if(($info['refundImage1']!='') || ($info['refundImage2']!='') || ($info['refundImage3']!='')){ ?>
							<li>
								<div class="label1">凭证图片</div>
								<div class="uploadImg">
									<?php for($i=1; $i<=3; $i++){ ?>
										<?php if($info['refundImage'.$i] != ''){ ?>
											<div class="uploadImg-item">
												<div class="img"><img src="<?php echo $info['refundImage'.$i];?>" /></div>
											</div>
										<?php } ?>
									<?php } ?>
								</div>
							</li>
						<?php } ?>
                    </ul>
                </section>

            </div>
        </div>
    </div>
</body>

</html>
