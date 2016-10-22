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
    <script type='text/javascript' src='js/jquery-2.1.4.min.js' charset='utf-8'></script>
    <script>jQuery.noConflict()</script>
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
                <a class="button button-link button-nav pull-left back" href="">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">申请拼得客</h1>
            </header>

            <div class="content native-scroll">

                <section class="pdk-form">
                    <ul>
                        <form id="submitForm" action="pindeke_apply.php?act=apply" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                            <li>
                                <div class="item">
                                    <div class="label">真实姓名</div>
                                    <div class="main">
                                        <input id="name" type="text" name="" class="txt" placeholder="填写真实姓名" value="<?php echo $infoEdit['name'];?>" />
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="label">手机号码</div>
                                    <div class="main">
                                        <input id="phone" type="text" name="" class="txt" placeholder="填写手机号码" value="<?php echo $infoEdit['phone'];?>" />
                                    </div>
                                </div>
                            </li>
                            <li class="last">
                                <div class="item">
                                    <div class="label">身份证号码</div>
                                    <div class="main">
                                        <input id="number" type="text" name="" class="txt" placeholder="填写身份证号码" value="<?php echo $infoEdit['cardNo'];?>" />
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="label">推广渠道</div>
                                    <div class="main">
                                        <input id="way" type="text" name="" class="txt" placeholder="填写推广渠道" value="<?php echo $infoEdit['channel'];?>" />
                                    </div>
                                </div>
                            </li>
                      <?php if(($infoEdit['image1']!='') || ($infoEdit['image2']!='') || ($infoEdit['image3']!='') || ($infoEdit['image4']!='') || ($infoEdit['image5']!='')){ ?>
                        <li class="last">
                            <div class="item">
                                <div class="label">推广证明</div>
                            </div>
                            <div class="uploadImg">
                            <?php for($i=1; $i<=5; $i++){ ?>
                                <?php if($infoEdit['image'.$i] != ''){ ?>
	                                <div class="uploadImg-item">
	                                    <div class="img"><img data-file="res.msg" data-src="#" src="<?php echo $infoEdit['image'.$i];?>"></div>
	                                </div>
                                <?php } ?>
							<?php } ?>
                                    <div class="uploadImg-item">
                                        <input type="file" capture="camera" accept="image/*" />
                                        <div class="img noImg"></div>
                                        <span class="close" style="display:none;"></span>
                                    </div>
                                </div>
                            </li>
                        <?php }?>
                        </form>
                    </ul>
                </section>

                <div class="placeholder-50"></div>
                <div class="pdk-submit">
                    <input type="submit" value="重新提交信息" />
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
