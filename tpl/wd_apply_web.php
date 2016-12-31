<?php include_once('header_web.php');?>

<body>
    <div class="page-group" id="page-pdeForm">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="pindeke.php?act=wallet&uid=<?php echo $userid;?>">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">余额提现</h1>
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
                                        <input id="way" type="text" class="txt" placeholder="选择转账到方式" />
                                        <input id="way-value" type="hidden" name="type" />
                                    </div>
                                </div>
                            </li>
                            <li class="last">
                                <div class="item">
                                    <div class="label">转账帐号</div>
                                    <div class="main">
                                        <input id="number" type="text" name="number" class="txt" placeholder="填写对应的转账帐号和银行信息" />
                                    </div>
                                </div>
                            </li>
                            <li class="last">
                                <div class="item">
                                    <div class="label">提现金额</div>
                                </div>
                                <div class="price1">
                                    <input id="price" type="number" name="price" class="txt" />
                                </div>
                                <?php if(!empty($Objinfo['result']['balance'])){?>
                                <div class="price2">可用余额 <span><?php echo $Objinfo['result']['balance'];?></span>元</div>
                                 <?php }else{?>
                                 <div class="price2">可用余额 <span>0</span>元</div>
                                 <?php }?>
                            </li>
                        </form>
                    </ul>
                </section>

                <div class="pdk-submit2">
                    <input type="submit" value="提现" />
                    <div class="link">
                        <a href="/pindeke.php?act=withdrawals_records">查看提现记录</a>
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
                          // displayValues: ['支付宝', '微信', '银行'],
                          // values: [1,2,3],
                          displayValues: ['支付宝', '银行'],
                          values: [1,3]
                        }
                        ],
                        formatValue: function(picker, values, displayValues){
                            $("#way-value").val(values);
                            return displayValues;
                        }
                    });

                    //提现金额限制
                    $("#price").on("keyup", function(){
                        var val = $(this).val();
                        val = val.replace(/[^(\d\.)]/g,'');
                        $(this).val(val);
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
                            $.toast("填写对应的转账帐号和银行信息");
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
