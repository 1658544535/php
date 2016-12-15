<?php include_once('header_web.php');?>
<?php include_once('wxshare_web.php');?>

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

                <form id="submitForm" action="aftersale.php?act=tracking" accept-charset="utf-8" method="post">
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
                                        <textarea id="no" name="no" rows="1" class="txt" placeholder="请输入运单编号" ></textarea>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </section>

                    <div class="afterSales-submit">
                        <input type="button" value="提交申请" />
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

                    //提交
                    $(".afterSales-submit input").on("click", function(){
                        if($.trim($("#type").val()) == ""){
                            $.toast("请选择退款类型");
                            return false;
                        }
                        if($.trim($("#no").val()) == ""){
                            $.toast("请填写运单编号");
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
