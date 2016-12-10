<?php include_once('header_web.php');?>
<?php include_once('wxshare_web.php');?>

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

                    <section class="afterSales-form">
                        <ul>
                            <form id="submitForm" action="aftersale.php?act=apply" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                                <input type="hidden" name="oid" value="<?php echo $orderId;?>" />
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
                                        <!-- <div class="main">
                                            <input id="price" type="tel" name="m[price]" class="txt price" data-max="<?php echo $order['productInfo']['orderPrice'];?>" placeholder="请输入退款金额" value="<?php echo $order['productInfo']['orderPrice'];?>" />
                                        </div> -->
                                        <div class="main themeColor">￥<?php echo $order['productInfo']['orderPrice'];?></div>
                                        <input id="price" type="hidden" name="m[price]" class="txt price" value="<?php echo $order['productInfo']['orderPrice'];?>" />
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
                                            <input type="text" name="m[phone]" class="txt" placeholder="请输入联系方式" value="<?php echo $order['addressInfo']['tel'];?>" />
                                        </div>
                                    </div>
                                </li>
                            </form>
                            <li>
                                <div class="uploadImg">
                                    <div class="uploadImg-item">
                                        <input type="file" capture="camera" accept="image/*" />
                                        <div class="img noImg"></div>
                                        <!-- <input type="file" capture="camera" accept="image/*" name="img[]" /> -->
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </section>

                    <div class="afterSales-submit">
                        <input type="button" value="提交申请" />
                    </div>

            </div>
            <script type='text/javascript' src='js/fileupload/jquery.ui.widget.js' charset='utf-8'></script>
            <script type='text/javascript' src='js/fileupload/jquery.iframe-transport.js' charset='utf-8'></script>
            <script type='text/javascript' src='js/fileupload/jquery.fileupload.js' charset='utf-8'></script>
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
                          values: ['仅退款'<?php if(!(($order['isSuccess'] == 1) && ($order['orderStatus'] == 2))){?>, '我要退货'<?php } ?>],
                          displayValues: ['仅退款'<?php if(!(($order['isSuccess'] == 1) && ($order['orderStatus'] == 2))){?>, '我要退货'<?php } ?>]
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

                    //上传图片
                    $(document).on("click", '.uploadImg-item', function(){
                        $('.uploadImg-item').removeClass("active");
                        $(this).addClass("active");
                        bindUploadImg();
                    });

                    //删除图片
                    $(document).on("click", '.uploadImg-item .close', function(){
                        var _item = $(this).parents(".uploadImg-item");
                        if(_item.siblings().find(".noImg").length <= 0){
                            $(this).parents(".uploadImg").append('<div class="uploadImg-item"><input type="file" capture="camera" accept="image/*" /><div class="img noImg"></div></div>');
                        }
                        _item.remove();
                    });

                    function bindUploadImg(){
                        jQuery('.uploadImg .uploadImg-item.active input[type="file"]').fileupload({
                            autoUpload: true,//是否自动上传
                            url: "/aftersale.php?act=uploadimg&oid=<?php echo $orderId;?>",//上传地址
                            dataType: 'json',
                            success: function (res, status){//设置文件上传完毕事件的回调函数
                                var data = {
                                    code: res.state,
                                    msg: res.msg,
                                    url: res.url
                                }
                                if(data.code > 0){
                                    var _this = $(".uploadImg-item.active input");
                                    var url = data.url;
                                    if(_this.parent().find(".img").hasClass("noImg")){
                                        _this.parent().find(".img").removeClass("noImg");
                                        _this.parent().find(".img").html('<img data-file="'+data.msg+'" data-src="'+ url +'" src="'+ url +'" />');
                                        _this.parent().find("input[type='hidden']").val(url);
                                        $(".uploadImg-item .close").show();
                                        if(_this.parents(".uploadImg").find(".uploadImg-item").length < 3)
                                        _this.parent().after('<div class="uploadImg-item"><input type="file" capture="camera" accept="image/*" /><div class="img noImg"></div><span class="close" style="display:none;"></span></div>');
                                    }else{
                                        _this.parent().find(".img").find("img").attr("src", url);
                                        _this.parent().find("input[type='hidden']").val(url);
                                        $(".uploadImg-item .close").show();
                                    }
                                    $(".uploadImg-item.active .img").removeClass("loadingImg");
                                }else{
                                    $.toast(data.msg);
                                    $(".uploadImg-item.active .img").removeClass("loadingImg");
                                }
                            },
                            error: function(e) {
                                $.toast("图片上传失败，请重试");
                                $(".uploadImg-item.active .img").removeClass("loadingImg");
                            },
                            progressall: function (e, data) {//设置上传进度事件的回调函数
                                $(".uploadImg-item.active .img").addClass("loadingImg");
                            }
                        });
                    }

                    //提交
                    $(".afterSales-submit input").on("click", function(){
                        if($.trim($("#type").val()) == ""){
                            $.toast("请选择退款类型");
                            return false;
                        }
                        // if($.trim($("#price").val()) == ""){
                        //     $.toast("请输入退款金额");
                        //     return false;
                        // }
                        if($.trim($("#reason").val()) == ""){
                            $.toast("请选择退款原因");
                            return false;
                        }
                        if($.trim($("#reason").val()) == ""){
                            $.toast("请输入问题描述");
                            return false;
                        }
                        if($.trim($("input[name='m[describe]']").val()) == ""){
                            $.toast("请输入问题描述");
                            return false;
                        }
                        var _tel = $("input[name='m[phone]']").val();
                        var _re = /(^1\d{10}$)/;
                        if(!_re.test(_tel)){
                            $.toast("请正确填写联系方式");
                            return false;
                        }
                        $(".uploadImg img").each(function(index, el) {
                            $("#submitForm").append('<input type="hidden" name="img[]" value="'+ $(el).attr("data-file") +'" />');
                        });

                        $("#submitForm").submit();
                    });
                });
            </script>
        </div>
    </div>
</body>

</html>
