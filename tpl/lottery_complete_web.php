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
    <div class="page-group" id="page-evaluate-success">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="user_lottery.php">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">评价成功</h1>
            </header>

            <div class="content native-scroll">

                <section class="evaluate-null"></section>

                <section class="pro-like">
                    <h3 class="title1"><!--猜你喜欢--></h3>
                    <ul>
                        <?php foreach ($LikeList as $like){?>
                        <li>
                            <a class="img" href="groupon.php?id=<?php echo $like['activityId'];?>"><img src="<?php echo $like['productImage'];?>" /></a>
                            <a class="name" href="groupon.php?id=<?php echo $like['activityId'];?>"><?php echo $like['productName'];?></a>
                            <div class="price">
                                <a href="javascript:;" class="collect<?php if($like['isCollect']==1){?> active<?php } ?>" data-collect="<?php echo ($like['isCollect']==1)?'1':'0';?>" data-actid="<?php echo $like['activityId'];?>" data-pid="<?php echo $like['productId'];?>"><!--收藏--></a>
                                                                ￥<span><?php echo $like['price'];?></span>
                            </div>
                        </li>
                        <?php }?>
                    </ul>
                </section>

            </div>

        </div>
         <script>
            var _apiUrl = "/api_action.php?act=";
            //猜你喜欢收藏
                $(".pro-like .collect").on("click", function(){
                    var _this = $(this);
					opCollect(_this, _this.attr("data-actid"), _this.attr("data-pid"));
                });

				function opCollect(_this,actid, pid){
					var _collected = ((_this.attr("data-collect") != "undefined") && (_this.attr("data-collect") == "1")) ? true : false;
					$.showIndicator();
                    $.ajax({
                        url: _apiUrl+(_collected ? "uncollect" : "collect"),
                        type: 'POST',
                        dataType: 'json',
                        data: {"id":actid,"pid":pid},
                        success: function(res){
							$.hideIndicator();

							if(res.code == 1){
								if(_collected){
									_this.removeClass("active");
									_this.attr("data-collect", 0);
								}else{
									_this.addClass("active");
									_this.attr("data-collect", 1);
								}
							}else{
								if((typeof(res.data.data.r) != "undefined") && (res.data.data.r == 'login')){
									window.location.href = "user_binding.php";
								}
							}
							$.toast(res.msg);
                        }
                    });
				}

           
        </script>
    </div>
</body>

</html>
