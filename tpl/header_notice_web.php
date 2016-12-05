<?php define("SOURCE_VERSOIN", '20161122');?>
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
//	    $.ajax({  
//		        url: "msg.php",
//		        data: {"act":"plan2"},  
//		        dataType: "json",  
//		        success: function (data) {
//		            var data = data["data"]["data"],
//		                degree = 1,
//		                pushTxt = '';
//
//                    //打乱数组数据
//                    var arrLen = data.length,
//                        keyArr = [];
//                    for(var i=0; i<arrLen; i++){
//                        keyArr.push(i);
//                    };
//                    keyArr.sort(function(){ return 0.5 - Math.random()});
//                    var newDataArr = [];
//                    for(var j=0; j<keyArr.length; j++){
//                        newDataArr.push(data[keyArr[j]]);
//                    };
//                    data = newDataArr;
//                    
//		            fn_timer();
//		            var timer = setInterval(fn_timer, 6000);
//		            function fn_timer(){
//		                if(degree<=data.length){
//		                    pushTxt = '<a href="groupon_join.php?aid='+data[degree-1]["attendId"]+'" class="message-push"><img src="'+data[degree-1]["icon"]+'" class="img" />新订单来自'+data[degree-1]["address"]+'的【'+data[degree-1]["userName"]+'】一起拼！</a>';
//		                    $(".page-group").append(pushTxt);
//		                    setTimeout(function(){
//		                        $(".message-push").remove();
//		                    }, 4000);
//		                    degree++;
//		                }else{
//		                    clearInterval(timer);
//		                }
//		            }
//		        }  
//		    });
        </script>
</head>