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
                <h1 class="title">填写运单号</h1>
            </header>

            <div class="content native-scroll bgWhite">

                <form action="aftersale.php?act=tracking" accept-charset="utf-8" method="post">
					<input type="hidden" name="oid" value="<?php echo $orderId;?>" />
                    <section class="afterSales-form">
                        <ul>
                            <li>
                                <div class="item">
                                    <div class="label">
                                        <span class="themeColor">* </span>快递类型
                                    </div>
                                    <div class="main">
                                        <input id="type" name="type" type="text" class="txt" placeholder="请选择快递类型" />
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="label">
                                        <span class="themeColor">* </span>运单编号
                                    </div>
                                    <div class="main">
                                        <textarea name="no" rows="1" class="txt" placeholder="请输入运单编号" ></textarea>
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
            <script>
                $(document).on("pageInit", "#page-afterSales", function(e, pageId, page) {
                    //快递类型
                    $("#type").picker({
                        toolbarTemplate: '<header class="bar bar-nav">\
                        <button class="button button-link pull-right close-picker">确定</button>\
                        <h1 class="title">请选择快递类型</h1>\
                        </header>',
                        cols: [
                        {
                          textAlign: 'center',
                          values: ["<?php echo implode('","', $trackList);?>"]
                        }
                        ]
                    });
                });
            </script>
        </div>
    </div>
</body>

</html>
