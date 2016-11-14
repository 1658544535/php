<?php define("SOURCE_VERSOIN", '2016111210');?>
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
    <link rel="stylesheet" href="css/all.min.css?v=<?php echo SOURCE_VERSOIN;?>">
    <link rel="stylesheet" href="js/swiper/swiper.min.css">
    <script type='text/javascript' src='js/jquery-2.1.4.min.js' charset='utf-8'></script>
    <script>jQuery.noConflict()</script>
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/baiduTemplate.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js?v=<?php echo SOURCE_VERSOIN;?>' charset='utf-8'></script>
    <script>
        $(function(){
            var pushTxt = '<a href="1" class="message-push"><img src="http://pin.taozhuma.com/upfiles/focusbanner/20161004093329310841.jpg" class="img" />最新订单来自 【地址】 的 【用户昵称】，1秒前</a>';
            if($(".message-push".length>0)){
                $(".message-push").remove();
            }
            $(".page-group").append(pushTxt);
            setTimeout(function(){
                $(".message-push").remove();
            }, 5000);
        });
    </script>
</head>