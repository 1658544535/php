<?php include_once('header_notice_web.php');?>
<?php include_once('wxshare_web.php');?>

<body>
    <div class="page-group" id="page-pdeForm">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="pindeke.php?act=pdkInfo">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">我的信息</h1>
            </header>

            <div class="content native-scroll">

                <section class="pdk-form">
                    <ul>
                        <form id="submitForm" action="" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                            <li>
                                <div class="item">
                                    <div class="label">真实姓名</div>
                                    <div class="main">
                                        <input id="name" type="text" name="" class="txt" placeholder="填写真实姓名" value="Dennis" />
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="label">手机号码</div>
                                    <div class="main">
                                        <input id="phone" type="text" name="" class="txt" placeholder="填写手机号码" value="13412345678" />
                                    </div>
                                </div>
                            </li>
                            <li class="last">
                                <div class="item">
                                    <div class="label">身份证号码</div>
                                    <div class="main">
                                        <input id="number" type="text" name="" class="txt" placeholder="填写身份证号码" value="440512345678902345" />
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="label">推广渠道</div>
                                    <div class="main">
                                        <input id="way" type="text" name="" class="txt" placeholder="填写推广渠道" value="淘宝客" />
                                    </div>
                                </div>
                            </li>
                            <li class="last">
                                <div class="item">
                                    <div class="label">推广证明</div>
                                </div>
                                <div class="uploadImg">
                                    <div class="uploadImg-item">
                                        <input type="file" capture="camera" accept="image/*">
                                        <div class="img"><img data-file="res.msg" data-src="#" src="#"></div>
                                        <span class="close"></span>
                                    </div>
                                    <div class="uploadImg-item">
                                        <input type="file" capture="camera" accept="image/*" />
                                        <div class="img noImg"></div>
                                        <span class="close" style="display:none;"></span>
                                    </div>
                                </div>
                                <div class="tips2">注：点击<span class="themeColor">“确认修改”</span>后，用户身份将重新审核</div>
                            </li>
                        </form>
                    </ul>
                </section>

                <div class="placeholder-50"></div>
                <div class="pdk-submit">
                    <input type="submit" value="确认修改" />
                </div>

            </div>
            <script type='text/javascript' src='js/fileupload/jquery.ui.widget.js' charset='utf-8'></script>
            <script type='text/javascript' src='js/fileupload/jquery.iframe-transport.js' charset='utf-8'></script>
            <script type='text/javascript' src='js/fileupload/jquery.fileupload.js' charset='utf-8'></script>
            <script>
                $(document).on("pageInit", "#page-pdeForm", function(e, pageId, page) {
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
                                        if(_this.parents(".uploadImg").find(".uploadImg-item").length < 5)
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
                    $(".pdk-submit input").on("click", function(){
                        if($.trim($("#name").val()) == ""){
                            $.toast("填写真实姓名");
                            return false;
                        }
                        var _tel = $("#phone").val();
                        var _re = /((^1\d{10}$)|(^(\d{3,4}-)?\d{7,8}$))/;
                        if(!_re.test(_tel)){
                            $.toast("请正确填写手机号码");
                            return false;
                        }
                        if($.trim($("#number").val()) == ""){
                            $.toast("请填写身份证号码");
                            return false;
                        }
                        if($.trim($("#way").val()) == ""){
                            $.toast("请填写推广渠道");
                            return false;
                        }
                        if($(".uploadImg img").length<=0){
                            $.toast("请上传推广证明");
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
