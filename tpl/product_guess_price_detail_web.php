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
    <div class="page-group" id="page-guessDeta">
        <div id="page-nav-bar" class="page page-current">

            <div class="content native-scroll" style="top:0rem;bottom:2.75rem;">
                <header class="bar bar-nav">
                    <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                        <span class="icon icon-back"></span>
                    </a>
                    <h1 class="title">猜价赢好礼</h1>
                </header>
<?php if($bLogin == false){?>
   <div class="content native-scroll">
                    <section class="swiper-container deta-banner guessDeta-banner" data-space-between="0">
                        <div class="swiper-wrapper">
                            <?php foreach($ProductImage['result'] as $pimage){?>
                              <div class="swiper-slide"><img src="<?php echo $pimage['image'];?>" /></div>
                            <?php }?>  
                        </div>
                        <div class="swiper-pagination"></div>
                    </section>
                  <?php if($ObjGrouponInfo['result']['isStart']  ==2 ){?>   
                     <section class="guessDeta-info center">
                        <div class="name"><?php echo $ObjGrouponInfo['result']['productName'];?></div>
                        <div class="tips">来晚啦！该活动已经结束</div>
                        <div class="finalPrice">最终价格：<span class="price"><?php echo $ObjGrouponInfo['result']['realPrice'];?></span></div>
                     </section> 
                   <section class="guessJoinList guessDetaJoinList">
	                        <div class="freeList-tips">需参与者才可以看到其他参与者信息</div>
	               </section>
                  <?php }?>
                   <section class="guessDeta-info">
                        <div class="name"><?php echo $ObjGrouponInfo['result']['productName'];?></div>
                        <div class="list">
                            <span class="label">距离结束：</span>
                            <div id="downTime" class="downTime" data-timer="<?php echo $seckillTimeDiff;?>"></div>
                        </div>
                        <div class="list">
                            <span class="label">价格区间：</span>
                            <div class="price"><?php echo $ObjGrouponInfo['result']['minPrice'] ;?>-<?php echo $ObjGrouponInfo['result']['maxPrice'] ;?></div>
                        </div>
                  </section>
                    <section class="guessJoinList guessDetaJoinList">
                            <div class="freeList-tips">已有<span class="themeColor"><?php echo $ObjGrouponInfo['result']['joinNum'];?>个</span>小伙伴参与，您需要提交价格才可以看到其它记录</div>
                    </section>
                  
        <div class="deta-iframe">
	       <iframe id="proInfo" src="<?php echo API_URL;?>/getProductInfoView.do?id=<?php echo $productId?>" frameborder="0" width="100%"></iframe>
        </div>
           
               <script>
				document.domain='taozhuma.com';
				function setIframeHeight(iframe) {
					if (iframe) {
						var iframeWin = iframe.contentWindow || iframe.contentDocument.parentWindow;
						if (iframeWin.document.body) {
							iframe.height = iframeWin.document.documentElement.scrollHeight || iframeWin.document.body.scrollHeight;
						}
					}
				};
				window.onload = function () {
					setIframeHeight(document.getElementById('proInfo'));
				};
			</script>
             </div>

            </div>
            <div class="deta-footer">
                <a class="goIndex" href="index.php">
                    <span class="icon i-home"></span>
                    <span class="tab-label">首页</span>
                </a>
	            
	            <?php if($ObjGrouponInfo['result']['isStart']  ==2){?>
	            <div class="more3">
                    <a class="btn" href="groupon.php?id=<?php echo $gId;?>"><span>购买商品</span></a>
                    <a class="btn light" href="product_guess_price.php"><span>查看更多</span></a>
                    <div class="txt"><span>来晚了! 活动已结束</span></div>
                </div>  
	            <?php }?>
	             <div class="more1">
	                      <a  class="btn" href="/user_binding.php?dir=<?php echo $_SERVER['REQUEST_URI']; ?>" ><span>我要参与</span></a>
	             </div>

            </div>
    </div>
<?php }else{?>
                <div class="content native-scroll">
                    <section class="swiper-container deta-banner guessDeta-banner" data-space-between="0">
                        <div class="swiper-wrapper">
                            <?php foreach($ProductImage['result'] as $pimage){?>
                              <div class="swiper-slide"><img src="<?php echo $pimage['image'];?>" /></div>
                            <?php }?>  
                        </div>
                        <div class="swiper-pagination"></div>
                    </section>
            <?php if($ObjGrouponInfo['result']['isJoin']  ==1 && $ObjGrouponInfo['result']['isPublic']  ==0 && $ObjGrouponInfo['result']['isStart']  ==2){?>
                 <section class="guessDeta-info center">
                        <div class="name"><?php echo $ObjGrouponInfo['result']['productName'];?></div>
                        <div class="tips" style="color:red;">即将开奖，请耐心等待</div>
                    </section>
                    
                    <section class="guessJoinList guessDetaJoinList">
                       <div class="freeList-tips">
                                                       已有<span class="themeColor"><?php echo $ObjGrouponInfo['result']['joinNum'];?>个</span>小伙伴参与
                            <a href="product_guess_price.php?act=user&gid=<?php echo $gId;?>">点击查看更多</a>
                        </div>
	                        <ul class="list-container">
	                            <?php foreach ($ObjUserList['result']['joinUserList'] as $ul){?>
	                            <li><a href="javascript:;">
	                                <div class="img"><img src="<?php echo $ul['userImage'] ;?>" /></div>
	                                <div class="info">
	                                    <div class="name"><?php echo $ul['userName'];?></div>
	                                    <div class="price"><p>出价</p><p class="themeColor">￥<span class="real"><?php echo $ul['userPrice'];?></span></p></div>
	                                    <div class="time"><?php echo $ul['joinTime'];?></div>
	                                </div>
	                            </a></li>
	                        <?php }?>
	                       </ul>
            </section>
            
            
            <?php }elseif($ObjGrouponInfo['result']['isStart']  ==1 && $ObjGrouponInfo['result']['isJoin']  ==0 && $ObjGrouponInfo['result']['isPublic']  ==0 ){?>
                    <section class="guessDeta-info">
                        <div class="name"><?php echo $ObjGrouponInfo['result']['productName'];?></div>
                        <div class="list">
                            <span class="label">距离结束：</span>
                            <div id="downTime" class="downTime" data-timer="<?php echo $seckillTimeDiff;?>"></div>
                        </div>
                        <div class="list">
                            <span class="label">价格区间：</span>
                            <div class="price"><?php echo $ObjGrouponInfo['result']['minPrice'] ;?>-<?php echo $ObjGrouponInfo['result']['maxPrice'] ;?></div>
                        </div>
                    </section>
             <?php }elseif($ObjGrouponInfo['result']['isStart']  ==1 && $ObjGrouponInfo['result']['isJoin']  ==1 && $ObjGrouponInfo['result']['isPublic']  ==0 ){?>
                    <section class="guessDeta-info">
                        <div class="name"><?php echo $ObjGrouponInfo['result']['productName'];?></div>
                        <div class="list">
                            <span class="label">距离结束：</span>
                            <div id="downTime" class="downTime" data-timer="<?php echo $seckillTimeDiff;?>"></div>
                        </div>
                        <div class="list">
                            <span class="label">价格区间：</span>
                            <div class="price"><?php echo $ObjGrouponInfo['result']['minPrice'] ;?>-<?php echo $ObjGrouponInfo['result']['maxPrice'] ;?></div>
                        </div>
                    </section>
              <?php }elseif($ObjGrouponInfo['result']['isStart']  ==2  && $ObjGrouponInfo['result']['isJoin']  ==0){?>         
                     
                     <section class="guessDeta-info center">
                        <div class="name"><?php echo $ObjGrouponInfo['result']['productName'];?></div>
                        <div class="tips">来晚啦！该活动已经结束</div>
                        <div class="finalPrice">最终价格：<span class="price"><?php echo $ObjGrouponInfo['result']['realPrice'];?></span></div>
                     </section> 
              <?php }elseif($ObjGrouponInfo['result']['isJoin']  ==1 && $ObjGrouponInfo['result']['isStart']  ==2 && $ObjGrouponInfo['result']['isPublic']  ==1 && $ObjGrouponInfo['result']['isWin']  ==1 && $ObjGrouponInfo['result']['prize'] ==1){?>
               <section class="guessDeta-info center">
                        <div class="name"><?php echo $ObjGrouponInfo['result']['productName'];?></div>
                        <div class="tips">恭喜您！得到了该商品</div>
                        <div class="finalPrice">最终价格：<span class="price"><?php echo $ObjGrouponInfo['result']['realPrice'];?></span></div>
                    </section>
              
              <?php }elseif($ObjGrouponInfo['result']['isStart']  ==2 && $ObjGrouponInfo['result']['isPublic']  ==1 && $ObjGrouponInfo['result']['isJoin']  ==1 && $ObjGrouponInfo['result']['isWin']  ==1){?>
	               <section class="guessDeta-info center">
	                        <div class="name"><?php echo $ObjGrouponInfo['result']['productName'];?></div>
	                        <?php if($ObjGrouponInfo['result']['prize'] ==2){?>
	                          <div class="tips">恭喜您，获得二等奖</div>
	                        <?php }elseif($ObjGrouponInfo['result']['prize'] ==3){?>
	                          <div class="tips">恭喜您，获得三等奖</div>
	                          <?php }?>
	                        <div class="finalPrice">最终价格：<span class="price"><?php echo $ObjGrouponInfo['result']['realPrice'];?></span></div>
	                    </section>
	         <?php }?>
                       <section class="guessJoinList guessDetaJoinList">
                        <?php if( $ObjGrouponInfo['result']['isJoin'] ==1 && $ObjGrouponInfo['result']['isStart'] ==1){?>
	                        <ul class="list-container">
	                                                  您的出价信息如下：
	                            <li><a href="javascript:;">
	                                <div class="img"><img src="<?php echo $ObjUser['result']['userImage'];?>" /></div>
	                                <div class="info">
	                                    <div class="name"><?php echo $ObjGrouponInfo['result']['userInfo']['userName'];?></div>
	                                    <div class="price"><p>出价</p><p class="themeColor">￥<span class="real"><?php echo $ObjGrouponInfo['result']['userInfo']['userPrice'];?></span></p></div>
	                                    <div class="time"><?php echo $ObjGrouponInfo['result']['userInfo']['joinTime'];?></div>
	                                </div>
	                            </a></li>
	                          </ul>
                        <div class="freeList-tips">
                                                       已有<span class="themeColor"><?php echo $ObjGrouponInfo['result']['joinNum'];?>个</span>小伙伴参与
                            <a href="product_guess_price.php?act=user&gid=<?php echo $gId;?>">点击查看更多</a>
                        </div>
	                        <ul class="list-container">
	                          <?php foreach ($ObjUserList['result']['joinUserList'] as $ul){?>
	                            <li><a href="javascript:;">
	                                <div class="img"><img src="<?php echo $ul['userImage'] ;?>" /></div>
	                                <div class="info">
	                                    <div class="name"><?php echo $ul['userName'];?></div>
	                                    <div class="price"><p>出价</p><p class="themeColor">￥<span class="real"><?php echo $ul['userPrice'];?></span></p></div>
	                                    <div class="time"><?php echo $ul['joinTime'];?></div>
	                                </div>
	                            </a></li>
	                           <?php }?>
	                        </ul>
                      <?php }elseif( $ObjGrouponInfo['result']['isStart'] ==2 &&  $ObjGrouponInfo['result']['isJoin'] ==0 ){?>
	                      <section class="guessJoinList guessDetaJoinList">
	                        <div class="freeList-tips">需参与者才可以看到其他参与者信息</div>
	                      </section>
                   <?php }elseif($ObjGrouponInfo['result']['isStart'] ==1 && $ObjGrouponInfo['result']['isJoin'] ==0 ){?>
                          <section class="guessJoinList guessDetaJoinList">
                            <div class="freeList-tips">已有<span class="themeColor"><?php echo $ObjGrouponInfo['result']['joinNum'];?>个</span>小伙伴参与，您需要提交价格才可以看到其它记录</div>
                          </section>
                    <?php }?>
                    </section>

           <?php if( $ObjGrouponInfo['result']['isJoin'] ==1 && $ObjGrouponInfo['result']['isPublic'] ==1 && $ObjGrouponInfo['result']['isWin'] ==1   && $ObjGrouponInfo['result']['isStart'] ==2){?>
					<section class="guessJoinList guessDetaJoinList">
					                        <div class="freeList-tips">
					                            获一等奖的小伙伴<b class="themeColor">【<?php echo $ObjPrizeList['result']['friPrizeNum'];?>人】</b>
					                            <a href="product_guess_price.php?act=prize&gid=<?php echo $gId; ?>&type=1">点击查看更多</a>
					                        </div>
					                        <?php foreach ($ObjPrizeList['result']['friPrizeList'] as $p1){?>
					                        <ul class="list-container">
					                            <li><a href="javascript:;">
					                                <div class="img"><img src="<?php echo $p1['userImage'];?>" /></div>
					                                <div class="info">
					                                    <div class="name"><?php echo $p1['userName']?></div>
					                                    <div class="price"><p>出价</p><p class="themeColor">￥<span class="real"><?php echo $p1['userPrice'];?></span></p></div>
					                                    <div class="time"><?php echo $p1['joinTime'];?></div>
					                                </div>
					                            </a></li>
					                        </ul>
					                    <?php }?>
					                    </section>
					
					                    <section class="guessJoinList guessDetaJoinList">
					                        <div class="freeList-tips">
					                            获二等奖的小伙伴<b class="themeColor">【<?php echo $ObjPrizeList['result']['twoPrizeNum'];?>人】</b>
					                            <a href="product_guess_price.php?act=prize&gid=<?php echo $gId; ?>&type=2">点击查看更多</a>
					                        </div>
					                        <?php foreach ($ObjPrizeList['result']['twoPrizeList'] as $p2){?>
					                        <ul class="list-container">
					                            <li><a href="javascript:;">
					                                <div class="img"><img src="<?php echo $p2['userImage'];?>" /></div>
					                                <div class="info">
					                                    <div class="name"><?php echo $p2['userName'];?></div>
					                                    <div class="price"><p>出价</p><p class="themeColor">￥<span class="real"><?php echo $p2['userPrice'];?></span></p></div>
					                                    <div class="time"><?php echo $p2['joinTime'];?></div>
					                                </div>
					                            </a></li>
					                        </ul>
		                                  <?php }?>
					                    </section>
					
					                    <section class="guessJoinList guessDetaJoinList">
					                        <div class="freeList-tips">
					                            获三等奖的小伙伴<b class="themeColor">【<?php echo $ObjPrizeList['result']['thrPrizeNum'];?>人】</b>
					                            <a href="product_guess_price.php?act=prize&gid=<?php echo $gId; ?>&type=3">点击查看更多</a>
					                        </div>
					                        <?php foreach ($ObjPrizeList['result']['thrPrizeList'] as $p3){?>
					                        <ul class="list-container">
					                            <li><a href="javascript:;">
					                                <div class="img"><img src="<?php echo $p3['userImage'];?>" /></div>
					                                <div class="info">
					                                    <div class="name"><?php echo $p3['userName'];?></div>
					                                    <div class="price"><p>出价</p><p class="themeColor">￥<span class="real"><?php echo $p3['userPrice'];?></span></p></div>
					                                    <div class="time"><?php echo $p3['joinTime'];?></div>
					                                </div>
					                            </a></li>
					                        </ul>
					                        <?php }?>
					                    </section>
               <?php }?>
                    
                   
                    <div class="deta-iframe">
	<iframe id="proInfo" src="<?php echo API_URL;?>/getProductInfoView.do?id=<?php echo $productId?>" frameborder="0" width="100%"></iframe>
          </div>
           
               <script>
				document.domain='taozhuma.com';
				function setIframeHeight(iframe) {
					if (iframe) {
						var iframeWin = iframe.contentWindow || iframe.contentDocument.parentWindow;
						if (iframeWin.document.body) {
							iframe.height = iframeWin.document.documentElement.scrollHeight || iframeWin.document.body.scrollHeight;
						}
					}
				};
				window.onload = function () {
					setIframeHeight(document.getElementById('proInfo'));
				};
			</script>
                    
                </div>

            </div>

            <div class="deta-footer">
                <a class="goIndex" href="index.php">
                    <span class="icon i-home"></span>
                    <span class="tab-label">首页</span>
                </a>
               
               <?php if($ObjGrouponInfo['result']['isJoin']  ==1 && $ObjGrouponInfo['result']['isPublic']  ==0 && $ObjGrouponInfo['result']['isStart']  ==2){?>
               <div class="more2">
	                <a class="btn" href="product_guess_price.php"><span>查看更多</span></a>
		            <div class="txt"><span>耐心等待开奖结果</span></div>
               </div>
               <?php  }elseif($ObjGrouponInfo['result']['isJoin']  ==0 && $ObjGrouponInfo['result']['isStart']  ==1 ){?>
                <div class="more1">
                      <a id="guess-join" class="btn" href="javascript:;"><span>我要参与</span></a>
                </div>
               <?php }elseif($ObjGrouponInfo['result']['isJoin']  ==1 && $ObjGrouponInfo['result']['isStart']  ==1 ){?>
	            <div class="more2">
	                    <a class="btn" href="product_guess_price.php"><span>查看更多</span></a>
	                    <div class="txt"><span>您的报价为：￥<?php echo $ObjGrouponInfo['result']['userInfo']['userPrice'];?>  丨 等待揭晓！</span></div>
	                </div>
               <?php }elseif($ObjGrouponInfo['result']['isJoin']  ==0 && $ObjGrouponInfo['result']['isStart']  ==2 ){?>
                <div class="more3">
                    <a class="btn" href="groupon.php?act=guess&pid=<?php echo $productId;?>"><span>购买商品</span></a>
                    <a class="btn light" href="product_guess_price.php"><span>查看更多</span></a>
                    <div class="txt"><span>来晚了! 活动已结束</span></div>
                </div>
                <?php }elseif($ObjGrouponInfo['result']['isJoin']  ==1 && $ObjGrouponInfo['result']['isPublic']  ==1 && $ObjGrouponInfo['result']['isWin']  ==1 && $ObjGrouponInfo['result']['isStart']  ==2 && $ObjGrouponInfo['result']['prize'] ==1){?>
	        	<div class="more2">
	                    <a class="btn" href="groupon.php?act=guess&pid=<?php echo $productId;?>"><span>我想购买</span></a>
	                    <?php if($ObjGrouponInfo['result']['isRecCoupon']  == 0){?>
	                    <div class="txt" onClick="location.href='order_guess.php?id=<?php echo $gId;?>&pid=<?php echo $productId;?>'"><span>活动结束，恭喜您已得奖！<br/>填写收货信息</span></div>
	            <?php }else{?>
	                    <div class="txt gray"><span>活动结束，恭喜您已得奖！<br/>填写收货信息</span></div>
	            <?php }?>
	            </div>
	       <?php }elseif($ObjGrouponInfo['result']['isJoin']  ==1 && $ObjGrouponInfo['result']['isPublic']  ==1 && $ObjGrouponInfo['result']['isWin']  ==1 && $ObjGrouponInfo['result']['isStart']  ==2  && $ObjGrouponInfo['result']['isRecCoupon'] ==1){?>
	        	<div class="more2">
	                    <a class="btn" href="product_guess_price.php"><span>查看更多</span></a>
	                    <div class="txt" onClick="location.href='groupon.php?act=guess&pid=<?php echo $productId;?>'"><span>恭喜您获得<?php echo $ObjGrouponInfo['result']['couponPrice'];?>元抵用券，点击马上购买</span></div>
	                </div>
        	<?php }elseif($ObjGrouponInfo['result']['isJoin']  ==1 && $ObjGrouponInfo['result']['isPublic']  ==1 && $ObjGrouponInfo['result']['isWin']  ==1 && $ObjGrouponInfo['result']['isStart']  ==2  && $ObjGrouponInfo['result']['isRecCoupon'] ==0 ){?>
        	<div class="more2">
	                    <a class="btn" href="product_guess_price.php"><span>查看更多</span></a>
	                    <?php if($ObjGrouponInfo['result']['prize']  ==2){?>
	                    <div class="txt"><span>获得二等奖，奖品发放中...</span></div>
	                <?php }elseif($ObjGrouponInfo['result']['prize']  ==3){?>
	                    <div class="txt"><span>获得三等奖，奖品发放中...</span></div>
	                <?php }?>
	                </div>
        	<?php }?>
        	</div>
           
            <script>
                $(document).on("pageInit", "#page-guessDeta", function(e, pageId, page) {
                    //参与
                    $("#guess-join").on("click", function(){
                        $.popup('.popup-join');
                    });
                    $(".popup-join input.big").on("keyup", function(){
                        var val = $(this).val();
                        val = val.replace(/[^\d]/g,'');
                        $(this).val(val);
                    });
                    $(".popup-join input.small").on("keyup", function(){
                    	var val = $(this).val();
                    	if(val.length>1){
                    		$(this).val(val.substring(0,1));
                    	}
                    });
                    $("#guess-price").on("click", function(){
                        var price1 = parseInt($(".popup-join input.big").val()),
                            price2 = parseInt($(".popup-join input.small").val());
                            price2 = !!price2 ? price2 : 0;
                        var price = price1 + '.' + price2;
                        var minPrice = <?php echo $ObjGrouponInfo['result']['minPrice'] ;?>,
                            maxPrice = <?php echo $ObjGrouponInfo['result']['maxPrice'] ;?>;
                        
                        if(!price1 && price1!=0){
                            $.toast('请填写价格');
                        }else{
                            if(price>maxPrice || price<minPrice){
                              $.toast('估计需在价格区间内');
                            }else{
                              $.post("product_guess_price.php?act=detail_save", {price: price, gid: <?php echo $gId;?>}, function(req){
                                  if(req.code > 0){
                                      $.toast('估价成功');
                                      location.href=document.location;
                                  }
                              }, "json");
                            }
                        }
                        
                    });

                    //弹窗
                    if($(".popup-guessCoupon").length>0){
                      $.post("product_guess_price.php?act=popup", {userid:<?php echo $userid;?>, gid:<?php echo $gId;?>});
                      $.popup('.popup-guessCoupon');
                    }
                });
            </script>
        </div>

        <div class="popup popup-join">
            <div>
                <a href="javascript:;" class="close-popup"></a>
                <div class="main">
                    <span>我的估价:</span>
                    <input type="tel" class="big" /><b>.</b><input type="tel" class="small" />
                </div>
                <a id="guess-price" href="javascript:;" class="go">立即前往</a>
            </div>
        </div>

      <?php if($ObjGrouponInfo['result']['isJoin']  ==1 && $ObjGrouponInfo['result']['isPublic']  ==1 && $ObjGrouponInfo['result']['isStart']  ==2 && $ObjGrouponInfo['result']['isWin']  ==1  && $ObjGrouponInfo['result']['isRecCoupon']  ==1 && $ObjGrouponInfo['result']['prize']  ==2 || $ObjGrouponInfo['result']['prize'] ==3 && $ObjGrouponInfo['result']['isAlert']  ==0){?>
        <div class="popup popup-guessCoupon">
	        <div>
	            <a href="javascript:;" class="close-popup"></a>
	            <div class="bg-top"></div>
	            <div class="main">
	                <h3 class="title1">恭喜您获取<span class="themeColor"><?php echo $ObjGrouponInfo['result']['couponPrice'];?>元</span>抵扣券</h3>
	                <div class="tips1">本抵扣券用于购买此商品，请点击进行购买</div>
	                <div class="tips2">注意：本券有效期为24小时</div>
	                <a href="groupon.php?act=guess&pid=<?php echo $productId;?>" class="go">立即前往</a>
	            </div>
	            <div class="bg-footer"></div>
	        </div>
	    </div>							
    <?php }?>
        
        
        
    </div>
   <?php }?> 
</body>

</html>
