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
    <div class="page-group" id="page-afterSales">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">申请退款</h1>
            </header>

            <div class="content native-scroll bgWhite">

                <form action="aftersale.php?act=apply" accept-charset="utf-8" enctype="multipart/form-data" method="post" onclick="return doSubmit()">
					<input type="hidden" name="oid" value="<?php echo $orderId;?>" />
                    <section class="afterSales-form">
                        <ul>
                            <li>
                                <div class="item">
                                    <div class="label">
                                        <span class="themeColor">* </span>退款类型
                                    </div>
                                    <div class="main">
                                        <input id="type" type="text" name="m[type]" class="txt" placeholder="请选择退款类型" />
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="label">
                                        <span class="themeColor">* </span>退款金额
                                    </div>
                                    <div class="main">
                                        <input id="price" type="text" name="m[price]" class="txt price" data-max="<?php echo $order['productInfo']['orderPrice'];?>" placeholder="请输入退款金额" />
                                    </div>
                                </div>
                                <div class="tips">（最高可退 ￥<?php echo $order['productInfo']['orderPrice'];?>元）</div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="label">
                                        <span class="themeColor">* </span>退款原因
                                    </div>
                                    <div class="main">
                                        <input id="reason" type="text" name="m[reason]" class="txt" placeholder="请选择退款原因" />
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="label">
                                        <span class="themeColor">* </span>问题描述
                                    </div>
                                    <div class="main">
                                        <input type="text" name="m[describe]" class="txt" placeholder="最多可输入170个字" />
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="label">
                                        <span class="themeColor">* </span>联系方式
                                    </div>
                                    <div class="main">
                                        <textarea name="m[phone]" rows="1" class="txt" placeholder="请输入联系方式" ></textarea>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="uploadImg">
                                    <div class="uploadImg-item">
                                        <input type="file" capture="camera" accept="image/*" name="img[]" />
                                        <div class="img noImg"></div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </section>

                    <div class="afterSales-submit">
                        <input type="submit" value="提交申请" />
                    </div>
                </form>

            </div>
            <script type='text/javascript' src='js/lrz/lrz.bundle.js' charset='utf-8'></script>
            <script>
                $(document).on("pageInit", "#page-afterSales", function(e, pageId, page) {
                    //退款类型
                    $("#type").picker({
                        toolbarTemplate: '<header class="bar bar-nav">\
                        <button class="button button-link pull-right close-picker">确定</button>\
                        <h1 class="title">请选择退款类型</h1>\
                        </header>',
                        cols: [
                        {
                          textAlign: 'center',
                          values: ['仅退款', '我要退货'],
                          displayValues: ['仅退款', '我要退货']
                        }
                        ]
                    })
                    //退款类型
                    $("#reason").picker({
                        toolbarTemplate: '<header class="bar bar-nav">\
                        <button class="button button-link pull-right close-picker">确定</button>\
                        <h1 class="title">请选择退款原因</h1>\
                        </header>',
                        cols: [
                        {
                          textAlign: 'center',
						  values: ['商品有质量问题', '没有收到货', '商品少发漏发发错', '商品与描述不一致', '收到商品时有划痕或破损', '质疑假货', '其他']
                        }
                        ]
                    });
                });

				function doSubmit(){
					return true;
				}
            </script>
        </div>
    </div>
</body>

</html>