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
                <a class="button button-link button-nav pull-left back" href="pindeke.php?act=wallet">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">提现申请</h1>
            </header>

            <div class="content native-scroll">

                <section class="pdk-form">
                    <ul>
                        <form id="submitForm" action="pindeke.php?act=withdrawals_save" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                            <li>
                                <div class="item">
                                    <div class="label">真实姓名</div>
                                    <div class="main">
                                        <input id="name" type="text" name="name" class="txt" placeholder="填写真实姓名" />
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="label">转账到</div>
                                    <div class="main">
                                        <input id="way" type="text" name="type" class="txt" placeholder="选择转账到方式" />
                                    </div>
                                </div>
                            </li>
                            <li class="last">
                                <div class="item">
                                    <div class="label">转账帐号</div>
                                    <div class="main">
                                        <input id="number" type="text" name="number" class="txt" placeholder="填写对应的转账帐号" />
                                    </div>
                                </div>
                            </li>
                            <li class="last">
                                <div class="item">
                                    <div class="label">提现金额</div>
                                </div>
                                <div class="price1">
                                    <input id="price" type="tel" name="price" class="txt" />
                                </div>
                                <div class="price2">可用余额 <span><?php echo $Oldprice;?></span>元</div>
                            </li>
                        </form>
                    </ul>
                </section>

                <div class="pdk-submit2">
                    <input type="submit" value="提交申请" />
                    <div class="link">
                        <a href="/pindeke.php?act=withdrawals_records&type=2">查看提现记录</a>
                    </div>
                </div>

            </div>
            <script>
                $(document).on("pageInit", "#page-pdeForm", function(e, pageId, page) {
                    
                    //选择转账到方式
                    $("#way").picker({
                        toolbarTemplate: '<header class="bar bar-nav">\
                        <button class="button button-link pull-right close-picker">确定</button>\
                        <h1 class="title">选择转账到方式</h1>\
                        </header>',
                        cols: [
                        {
                          textAlign: 'center',
                          values: ['支付宝', '微信', '银行']
                        }
                        ]
                    });

                    //提现金额限制
                    $("#price").on("keyup", function(){
                        var now = parseFloat($(this).val());
                        var max = parseFloat($(".price2 span").text());
                        if(now > max){
                            $.toast("提现金额不能大于余额");
                            $(this).val(max);
                        }
                    });

                    //提交
                    $(".pdk-submit2 input").on("click", function(){
                        if($.trim($("#name").val()) == ""){
                            $.toast("请填写真实姓名");
                            return false;
                        }
                        if($.trim($("#way").val()) == ""){
                            $.toast("请选择转账到方式");
                            return false;
                        }
                        if($.trim($("#number").val()) == ""){
                            $.toast("请填写对应的转账帐号");
                            return false;
                        }
                        if($.trim($("#price").val()) == ""){
                            $.toast("请填写提现金额");
                            return false;
                        }
                        
                        $("#submitForm").submit();
                    });
                });
            </script>
        </div>
    </div>
</body>

</html>
