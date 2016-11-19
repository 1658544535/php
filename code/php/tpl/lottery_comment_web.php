<?php include_once('header_notice_web.php');?>

<body>
    <div class="page-group" id="page-evaluate-submit">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="user_lottery.php">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">我要晒图</h1>
            </header>

            <div class="content native-scroll">
                <section class="evaluate-pro">
                    <div class="img"><img src="<?php echo $proImage;?>" /></div>
                    <div class="name"><?php echo $proName;?></div>
                </section>

                <section class="pdk-form">
                    <ul>
                        <form id="submitForm" action="lottery_new.php?act=comment_save&attId=<?php echo $attId ;?>&aid=<?php echo $aId;?>" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                            <li class="evaluate-txt">
                                <div class="evaluate-txt-main"><textarea name="content" id="evaluate-txt" placeholder="写下您的购物体验和使用感受来帮助其他小伙伴！"></textarea></div>
                                <div class="evaluate-txt-num">500</div>
                            </li>
                        </form>
                        <li class="last" style="padding-top:1.0rem;">
                            <div class="uploadImg">
                                <div class="uploadImg-item">
                                    <input type="file" capture="camera" accept="image/*" />
                                    <div class="img noImg"></div>
                                    <span class="close" style="display:none;"></span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </section>

                <div class="placeholder-50"></div>
                <div class="pdk-submit">
                    <input type="submit" value="提交" />
                </div>

                
            </div>
            <script type='text/javascript' src='js/fileupload/jquery.ui.widget.js' charset='utf-8'></script>
            <script type='text/javascript' src='js/fileupload/jquery.iframe-transport.js' charset='utf-8'></script>
            <script type='text/javascript' src='js/fileupload/jquery.fileupload.js' charset='utf-8'></script>
            <script>
                $(document).on("pageInit", "#page-evaluate-submit", function(e, pageId, page) {
                    //评论文字数量
                    $("#evaluate-txt").on("keyup", function(){
                        var val = $(this).val(),
                            num = $(this).val().length,
                            maxNum = 500;
                        surplus = maxNum - num;
                        if(surplus<=0){
                            surplus = 0;
                            val = val.substring(0,maxNum);
                            $("#evaluate-txt").val(val);
                        }
                        $(".evaluate-txt-num").html(surplus);
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
                            url: "/lottery_new.php?act=uploadimg&uid=<?php echo $userid;?>",//上传地址
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
                                        if(_this.parents(".uploadImg").find(".uploadImg-item").length < 9)
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
                        if($.trim($("#evaluate-txt").val()) == ""){
                            $.toast("请填写评论");
                            return false;
                        }
                        if($(".uploadImg img").length<=0){
                            $.toast("请上传图片");
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
