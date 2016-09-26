<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>淘竹马</title>
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
    <div class="page-group" id="page-guessDeta">
        <div id="page-nav-bar" class="page page-current">

            <div class="content native-scroll" style="top:0rem;bottom:2.75rem;">
                <header class="bar bar-nav">
                    <a class="button button-link button-nav pull-left back" href="">
                        <span class="icon icon-back"></span>
                    </a>
                    <h1 class="title">猜价赢好礼</h1>
                </header>

                <div class="content native-scroll">
                    <section class="swiper-container deta-banner guessDeta-banner" data-space-between="0">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide"><img src="images/img/banner.jpg" /></div>
                            <div class="swiper-slide"><img src="images/img/banner.jpg" /></div>
                            <div class="swiper-slide"><img src="images/img/banner.jpg" /></div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </section>

                    <section class="guessDeta-info">
                        <div class="name"><?php echo $ObjGrouponInfo->product_name;?></div>
                        <div class="list">
                            <span class="label">距离结束：</span>
                            <div id="downTime" class="downTime" data-timer="60"></div>
                        </div>
                        <div class="list">
                            <span class="label">价格区间：</span>
                            <div class="price"><?php echo $ObjGrouponInfo->price_min ;?>-<?php echo $ObjGrouponInfo->price_max ;?></div>
                        </div>
                    </section>
                       <section class="guessJoinList guessDetaJoinList">
                        <?php if( $ObjUserInfo =null){?>
	                        <ul class="list-container">
	                            <li><a href="#">
	                                <div class="img"><img src="<?php echo $site_image;?>userlogo/<?php echo $ul->$ObjUserInfo;?>" /></div>
	                                <div class="info">
	                                    <div class="name"><?php echo $ObjUserInfo->name;?></div>
	                                    <div class="price"><p>出价</p><p class="themeColor">￥<span class="real"><?php echo $ObjUserInfo->price;?></span></p></div>
	                                    <div class="time"><?php echo $ObjUserInfo->attend_time;?></div>
	                                </div>
	                            </a></li>
	                          </ul>
                        <?php }?>
                        <div class="freeList-tips">已有<span class="themeColor"><?php echo $ObjGrouponInfo->num;?>个</span>小伙伴参与，您需要提交价格才可以看到其它记录</div>
                        <?php if( $ObjUserInfo =null){?>
	                        <ul class="list-container">
	                            <?php foreach ($ObjUserList as $ul){?>
	                            <li><a href="#">
	                                <div class="img"><img src="<?php echo $site_image;?>userlogo/<?php echo $ul->image;?>" /></div>
	                                <div class="info">
	                                    <div class="name"><?php echo $ul->name;?></div>
	                                    <div class="price"><p>出价</p><p class="themeColor">￥<span class="real"><?php echo  $ul->price;?></span></p></div>
	                                    <div class="time"><?php echo $ul->attend_time;?></div>
	                                </div>
	                            </a></li>
	                        <?php }?>
	                        </ul>
                      <?php }?>
                    </section>

                    <section class="deta-img">
                       <?php if($content !=''){?>
                          <?php echo $url3;?>
                        <?php }else{?>
                       <?php foreach ($imageList as $image){?>
                        <img src="<?php echo $site_image;?>productImages/<?php echo $image->images;?>"/>
                       <?php }}?> 
                    </section>

                </div>

            </div>

            <div class="deta-footer">
                <a class="goIndex" href="index.html">
                    <span class="icon i-home"></span>
                    <span class="tab-label">首页</span>
                </a>
                <div class="more1">
                    <a id="guess-join" class="btn" href="javascript:;"><span>我要参与</span></a>
                </div>
            </div>

            <script>
                $(document).on("pageInit", "#page-guessDeta", function(e, pageId, page) {
                    //参与
                    $("#guess-join").on("click", function(){
                        $.popup('.popup-join');
                    });
                    $("#guess-price").on("click", function(){
                        var price1 = parseInt($(".popup-join input.big").val()),
                            price2 = parseInt($(".popup-join input.small").val());
                        if(!!price1){
                            price2 = !!price2 ? price2 : 0;
                            var price = price1 + '.' + price2;
                            $.post("product_guess_price.php?act=detail_save", {price: price, gid: <?php echo $gId;?>}, function(req){
                                if(req.code > 0){
                                    $.toast('估价成功');
                                    location.href=document.location;
                                }
                            });
                        }else{
                            $.toast('请填写价格');
                        }
                        
                    });
                });
            </script>

        </div>

        <div class="popup popup-join">
            <div>
                <a href="#" class="close-popup"></a>
                <div class="main">
                    <span>我的估价:</span>
                    <input type="text" class="big" /><b>.</b><input type="text" class="small" />
                </div>
                <a id="guess-price" href="javascript:;" class="go">立即前往</a>
            </div>
        </div>

    </div>
    
</body>

</html>
