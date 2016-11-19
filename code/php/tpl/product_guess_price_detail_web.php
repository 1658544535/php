<?php include_once('header_notice_web.php');?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script type="text/javascript">
var imgUrl = "<?php echo $fx['image'];?>";
var link   = "<?php echo $fx['url'];?>";
var title  = "<?php echo $fx['title'];?>";
var desc   = "<?php echo $fx['content'];?>";
wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
</script>

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
           <?php
				$_arrDomain = explode('.', $_SERVER['SERVER_NAME']);
				array_shift($_arrDomain);
			?>
               <script>
                document.domain='<?php echo implode('.', $_arrDomain);?>';
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
                    <div class="txt"><span>活动已结束</span></div>
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
                     <div class="freeList-tips">已有<span class="themeColor">
                             <?php echo $ObjGrouponInfo['result']['joinNum'];?>个</span>小伙伴参与
                         <a href="product_guess_price.php?act=user&gid=<?php echo $gId;?>">点击查看更多</a>
                     </div>
                     <ul class="list-container">
                         <?php foreach ($ObjUserList['result']['joinUserList'] as $ul){?>
                             <li>
                                 <a href="javascript:;">
                                     <div class="img">
                                       <?php if($ul['userImage'] !=''){?>
                                         <img src="<?php echo $ul['userImage'] ;?>" />
                                       <?php }else{?>
                                         <img src="../images/def_user.png" />
                                       <?php }?>
                                     </div>
                                     <div class="info">
                                         <div class="name"><?php echo $ul['userName'];?></div>
                                         <div class="price">
                                             <p>出价</p>
                                             <p class="themeColor">￥<span class="real"><?php echo $ul['userPrice'];?></span></p>
                                         </div>
                                         <div class="time"><?php echo $ul['joinTime'];?></div>
                                     </div>
                                 </a>
                             </li>
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
            <?php }elseif($ObjGrouponInfo['result']['isStart']  == 2){?>
                <?php if($ObjGrouponInfo['result']['isPublic']){
                    //已开奖?>
                    <?php if ($ObjGrouponInfo['result']['isWin']) {
                        //有中奖?>
                        <?php if($ObjGrouponInfo['result']['prize'] == 1) {
                            //获得一等奖?>
                            <section class="guessDeta-info center">
                                <div class="name"><?php echo $ObjGrouponInfo['result']['productName'];?></div>
                                <div class="tips">恭喜您！得到了该商品</div>
                                <div class="finalPrice">最终价格：<span class="price"><?php echo $ObjGrouponInfo['result']['realPrice'];?></span></div>
                            </section>
                        <?php } elseif (in_array($ObjGrouponInfo['result']['prize'],array(2,3))) {
                            //获得二三等奖 ?>
                            <section class="guessDeta-info center">
                                <div class="name"><?php echo $ObjGrouponInfo['result']['productName'];?></div>
                                <?php if($ObjGrouponInfo['result']['prize'] ==2){?>
                                    <div class="tips">恭喜您，获得二等奖</div>
                                <?php }elseif($ObjGrouponInfo['result']['prize'] ==3){?>
                                    <div class="tips">恭喜您，获得三等奖</div>
                                <?php }?>
                                <div class="finalPrice">最终价格：<span class="price"><?php echo $ObjGrouponInfo['result']['realPrice'];?></span></div>
                            </section>
                        <?php } ?>

                    <?php } else {
                        //没有中奖?>
                        <section class="guessDeta-info center">
                            <div class="name"><?php echo $ObjGrouponInfo['result']['productName'];?></div>
                            <div class="tips">来晚啦！该活动已经结束</div>
                            <div class="finalPrice">最终价格：<span class="price"><?php echo $ObjGrouponInfo['result']['realPrice'];?></span></div>
                        </section>
                    <?php } ?>
                <?php } else { ?>
                    <section class="guessDeta-info center">
                        <div class="name"><?php echo $ObjGrouponInfo['result']['productName'];?></div>
                        <div class="tips" style="color:red;">即将开奖，请耐心等待</div>
                    </section>
                <?php } ?>
            <?php } ?>

                    <section class="guessJoinList guessDetaJoinList">
                        <?php if( $ObjGrouponInfo['result']['isJoin'] ==1 && $ObjGrouponInfo['result']['isStart'] ==1){?>
	                        <ul class="list-container">您的出价信息如下：
	                            <li>
                                    <a href="javascript:;">
	                                    <div class="img">
				                           <?php if($ObjGrouponInfo['result']['userInfo']['userImage'] !=''){?>
				                                <img src="<?php echo $ObjGrouponInfo['result']['userInfo']['userImage'];?>" />
				                           <?php }else{?>
				                                <img src="/images/def_user.png" />
				                           <?php }?>
	                                    
	                                    </div>
	                                    <div class="info">
	                                        <div class="name"><?php echo $ObjGrouponInfo['result']['userInfo']['userName'];?></div>
	                                        <div class="price"><p>出价</p><p class="themeColor">￥<span class="real"><?php echo $ObjGrouponInfo['result']['userInfo']['userPrice'];?></span></p></div>
	                                        <div class="time"><?php echo $ObjGrouponInfo['result']['userInfo']['joinTime'];?></div>
	                                    </div>
	                                </a>
                                </li>
                            </ul>
                        <div class="freeList-tips">已有<span class="themeColor"><?php echo $ObjGrouponInfo['result']['joinNum'];?>个</span>小伙伴参与
                            <a href="product_guess_price.php?act=user&gid=<?php echo $gId;?>">点击查看更多</a>
                        </div>
	                        <ul class="list-container">
	                            <?php foreach ($ObjUserList['result']['joinUserList'] as $ul){?>
	                                <li>
                                        <a href="javascript:;">
	                                       <div class="img">
				                               <?php if($ul['userImage'] !=''){?>
				                                    <img src="<?php echo $ul['userImage'];?>" />
				                               <?php }else{?>
				                                    <img src="/images/def_user.png" />
				                               <?php }?>
			                                </div>
	                                        <div class="info">
	                                            <div class="name"><?php echo $ul['userName'];?></div>
	                                            <div class="price"><p>出价</p><p class="themeColor">￥<span class="real"><?php echo $ul['userPrice'];?></span></p></div>
	                                            <div class="time"><?php echo $ul['joinTime'];?></div>
	                                        </div>
	                                    </a>
                                    </li>
                                <?php }?>
	                        </ul>
                        <?php }elseif( $ObjGrouponInfo['result']['isStart'] == 2 && $ObjGrouponInfo['result']['isJoin'] == 0 && !$isPrize){ //价格竞猜已经结束但未开奖 ?>
                            <section class="guessJoinList guessDetaJoinList">
                                <div class="freeList-tips">已有<span class="themeColor">
                                <?php echo $ObjGrouponInfo['result']['joinNum'];?>个</span>小伙伴参与
                                    <a href="product_guess_price.php?act=user&gid=<?php echo $gId;?>">点击查看更多</a>
                                </div>
                                <ul class="list-container">
                                    <?php foreach ($ObjUserList['result']['joinUserList'] as $ul){?>
                                        <li>
                                            <a href="javascript:;">
                                               <div class="img">
				                                   <?php if($ul['userImage'] !=''){?>
				                                         <img src="<?php echo $ul['userImage'];?>" />
				                                   <?php }else{?>
				                                         <img src="/images/def_user.png" />
				                                   <?php }?>
			                                    </div>
                                                <div class="info">
                                                    <div class="name"><?php echo $ul['userName'];?></div>
                                                    <div class="price"><p>出价</p><p class="themeColor">￥<span class="real"><?php echo $ul['userPrice'];?></span></p></div>
                                                    <div class="time"><?php echo $ul['joinTime'];?></div>
                                                </div>
                                            </a>
                                        </li>
                                    <?php }?>
                                </ul>
                            </section>

                   <?php }elseif($ObjGrouponInfo['result']['isStart'] ==1 && $ObjGrouponInfo['result']['isJoin'] ==0 ){?>
                          <section class="guessJoinList guessDetaJoinList">
                            <div class="freeList-tips">已有<span class="themeColor"><?php echo $ObjGrouponInfo['result']['joinNum'];?>个</span>小伙伴参与，您需要提交价格才可以看到其它记录</div>
                          </section>
                    <?php }?>
                    </section>

           <?php if($ObjGrouponInfo['result']['isStart'] ==2 && $isPrize ){ //猜价结束且已开奖 ?>
               <section class="guessJoinList guessDetaJoinList">
                   <div class="freeList-tips">获一等奖的小伙伴
                       <b class="themeColor">【<?php echo $ObjPrizeList['result']['friPrizeNum'];?>人】</b>
                       <a href="product_guess_price.php?act=prize&gid=<?php echo $gId; ?>&type=1">点击查看更多</a>
                   </div>
                   <?php foreach ($ObjPrizeList['result']['friPrizeList'] as $p1){?>
                       <ul class="list-container">
                           <li>
                               <a href="javascript:;">
                                   <div class="img">
                                       <?php if($p1['userImage'] !=''){?>
                                         <img src="<?php echo $p1['userImage'];?>" />
                                       <?php }else{?>
                                         <img src="/images/def_user.png" />
                                       <?php }?>
                                   </div>  
                                   <div class="info">
                                       <div class="name"><?php echo $p1['userName']?></div>
                                       <div class="price"><p>出价</p><p class="themeColor">￥<span class="real"><?php echo $p1['userPrice'];?></span></p></div>
                                       <div class="time"><?php echo $p1['joinTime'];?></div>
                                   </div>
                               </a>
                           </li>
                       </ul>
                   <?php }?>
               </section>

               <section class="guessJoinList guessDetaJoinList">
                   <div class="freeList-tips">获二等奖的小伙伴
                       <b class="themeColor">【<?php echo $ObjPrizeList['result']['twoPrizeNum'];?>人】</b>
                       <a href="product_guess_price.php?act=prize&gid=<?php echo $gId; ?>&type=2">点击查看更多</a>
                   </div>
                   <?php foreach ($ObjPrizeList['result']['twoPrizeList'] as $p2){?>
                       <ul class="list-container">
                           <li>
                               <a href="javascript:;">
                                   <div class="img">
	                                   <?php if($p2['userImage'] !=''){?>
	                                         <img src="<?php echo $p2['userImage'];?>" />
	                                   <?php }else{?>
	                                         <img src="/images/def_user.png" />
	                                   <?php }?>
                                   </div>
                                   <div class="info">
                                       <div class="name"><?php echo $p2['userName'];?></div>
                                       <div class="price"><p>出价</p><p class="themeColor">￥<span class="real"><?php echo $p2['userPrice'];?></span></p></div>
                                       <div class="time"><?php echo $p2['joinTime'];?></div>
                                   </div>
                               </a>
                           </li>
                       </ul>
                   <?php }?>
               </section>

               <section class="guessJoinList guessDetaJoinList">
                   <div class="freeList-tips">获三等奖的小伙伴
                       <b class="themeColor">【<?php echo $ObjPrizeList['result']['thrPrizeNum'];?>人】</b>
                       <a href="product_guess_price.php?act=prize&gid=<?php echo $gId; ?>&type=3">点击查看更多</a>
                   </div>
                   <?php foreach ($ObjPrizeList['result']['thrPrizeList'] as $p3){?>
                       <ul class="list-container">
                           <li>
                               <a href="javascript:;">
                                   <div class="img">
	                                   <?php if($p3['userImage'] !=''){?>
	                                         <img src="<?php echo $p3['userImage'];?>" />
	                                   <?php }else{?>
	                                         <img src="/images/def_user.png" />
	                                   <?php }?>
                                   </div>
                                   <div class="info">
                                       <div class="name"><?php echo $p3['userName'];?></div>
                                       <div class="price"><p>出价</p><p class="themeColor">￥<span class="real"><?php echo $p3['userPrice'];?></span></p></div>
                                       <div class="time"><?php echo $p3['joinTime'];?></div>
                                   </div>
                               </a>
                           </li>
                       </ul>
                   <?php }?>
               </section>
           <?php }?>


           <div class="deta-iframe">
	            <iframe id="proInfo" src="<?php echo API_URL;?>/getProductInfoView.do?id=<?php echo $ObjGrouponInfo['result']['productId'];?>" frameborder="0" width="100%"></iframe>
           </div>
           <?php
				$_arrDomain = explode('.', $_SERVER['SERVER_NAME']);
				array_shift($_arrDomain);
           ?>
               <script>
                   document.domain='<?php echo implode('.', $_arrDomain);?>';
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

                <?php if($ObjGrouponInfo['result']['isJoin']  ==1 && $ObjGrouponInfo['result']['isPublic']  == 0 && $ObjGrouponInfo['result']['isStart']  == 2){
                    //有参与 未开奖 已经结束?>
                    <div class="more2">
                        <a class="btn" href="product_guess_price.php"><span>查看更多</span></a>
                        <div class="txt"><span>耐心等待开奖结果</span></div>
                    </div>
                <?php  }elseif($ObjGrouponInfo['result']['isJoin']  ==0 && $ObjGrouponInfo['result']['isStart']  ==1 ){
                    //未参与 未结束?>
                    <div class="more1">
                          <a id="guess-join" class="btn" href="javascript:;"><span>我要参与</span></a>
                    </div>
                <?php }elseif($ObjGrouponInfo['result']['isJoin']  ==1 && $ObjGrouponInfo['result']['isStart']  ==1 ){
                    //有参与 未结束?>
	                <div class="more2">
	                    <a class="btn" href="product_guess_price.php"><span>查看更多</span></a>
	                    <div class="txt"><span>您的报价为：￥<?php echo $ObjGrouponInfo['result']['userInfo']['userPrice'];?>  丨 等待揭晓！</span></div>
	                </div>
                <?php }elseif($ObjGrouponInfo['result']['isStart']  == 2){
                    //已经结束?>
                    <?php if ($ObjGrouponInfo['result']['isPublic']){
                        //已经结束 已开奖?>
                        <?php if ($ObjGrouponInfo['result']['isJoin'] && $ObjGrouponInfo['result']['isWin']){
                            //已经结束 有参与 已开奖且中奖?>
                            <?php if ($ObjGrouponInfo['result']['prize'] == 1){
                                //一等奖}?>
                                <div class="more2">
                                    <a class="btn" href="groupon.php?act=guess&pid=<?php echo $productId;?>"><span>我想购买</span></a>
                                    <?php if($ObjGrouponInfo['result']['isRecCoupon']  == 0){
                                        //是否分发优惠券 0-否 1-是 ?>
                                        <div class="txt" id="openSku" data-href="order_guess.php">
                                            <span>活动结束，恭喜您已得奖！<br/>填写收货信息</span>
                                        </div>
                                    <?php } else { ?>
                                        <div class="txt gray">
                                            <span>活动结束，恭喜您已得奖！<br/>填写收货信息</span>
                                        </div>
                                    <?php }?>
                                </div>
                            <?php } elseif ($ObjGrouponInfo['result']['isRecCoupon'] == 1) {
                                //获取优惠券 ?>
                                <div class="more2">
                                    <a class="btn" href="product_guess_price.php">
                                        <span>查看更多</span>
                                    </a>
                                    <div class="txt" onClick="location.href='groupon.php?act=guess&pid=<?php echo $productId;?>'">
                                        <span>恭喜您获得<?php echo $ObjGrouponInfo['result']['couponPrice'];?>元抵用券，点击马上购买</span>
                                    </div>
                                </div>
                            <?php } elseif(in_array($ObjGrouponInfo['result']['prize'],array(2,3))) {
                                //获得二三等奖?>
                                <div class="more2">
                                    <a class="btn" href="product_guess_price.php"><span>查看更多</span></a>
                                    <?php if($ObjGrouponInfo['result']['prize']  == 2){?>
                                        <div class="txt"><span>获得二等奖，奖品发放中...</span></div>
                                    <?php }elseif($ObjGrouponInfo['result']['prize']  == 3){?>
                                        <div class="txt"><span>获得三等奖，奖品发放中...</span></div>
                                    <?php }?>
                                </div>
                            <?php }?>
                        <?php } else {
                            // 已经结束 已开奖 未中奖?>
                            <div class="more3">
                                <a class="btn" href="groupon.php?act=guess&pid=<?php echo $productId;?>"><span>购买商品</span></a>
                                <a class="btn light" href="product_guess_price.php"><span>查看更多</span></a>
                                <div class="txt"><span>活动已结束</span></div>
                            </div>
                        <?php } ?>
                    <?php }else{
                        // 已经结束 未开奖?>
                       <div class="more2">
                           <a class="btn" href="product_guess_price.php"><span>查看更多</span></a>
                           <div class="txt"><span>耐心等待开奖结果</span></div>
                       </div>
                    <?php } ?>
                <?php } ?>
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

                    //sku
                    var jsonUrlParam = {"id":"<?php echo $gId;?>","pid":"<?php echo $ObjGrouponInfo['result']['productId'];?>","skuid":"","num":1};
                    var clickBuy = false;

                    $("#openSku").on("click", function(){
                      $(".popup-sku").attr("data-href", $(this).attr("data-href"));
                        $(".popup-sku .sku-number").show();
                      skuOpen();
                    });

                    //数量
                    $(".quantity .minus").on("click", function(){
                      var num = parseInt($(this).next().val());
                      if(num>1){
                        --num;
                        _genUrl({"num":num});
                        $(this).next().val(num);
                      }else{
                        return false;
                      }
                    });
                    $(".quantity .plus").on("click", function(){
                      var num = parseInt($(this).prev().val());
                      ++num;
                      _genUrl({"num":num});
                      $(this).prev().val(num);
                    });

                    $("#buy").on("click", function(){
                      // if(clickBuy) $("#buy").attr("href", _genUrl());
                      if(clickBuy) {
                        var url = _genUrl();
                        location.href = url;
                        // console.log(url);
                      }
                    });

                    //打开sku弹窗
                    function skuOpen(){
                      $.showIndicator();          //打开加载指示器
                      $("#buy").attr("href", "javascript:;").addClass("gray");

                       var req = {
                         msg: "",
                         code: 1,
                         data:  <?php echo empty($skus) ? '{}' : json_encode($skus);?>
                       }
                       if(req["data"]["validSKu"].length > 0){
                        $(".popup-sku .info .img img").attr("src", req["data"]["validSKu"][0]["skuImg"]);
                       }

                      if(req.code>0){
                        var data = req.data;
                        //载入全部sku信息
                        for(var item in data["skuList"]){
                          var itemType = parseInt(data["skuList"][item]["skuType"]),
                            itemList = data["skuList"][item]["skuValue"],
                            itemHtml = '';
                          for(var list in itemList){
                            itemHtml += '<a>' + itemList[list]["optionValue"] + '</a>';
                          }
                          switch (itemType){
                            case 1:
                              $("#sku-color .list").html(itemHtml);
                              break;
                            case 2:
                              $("#sku-format .list").html(itemHtml);
                              break;
                          }
                        }

                        //将可选的sku存入一个全局变量
                        skuData = data["validSKu"];

                        if(req["data"]["validSKu"].length > 0){
                          //绑定点击事件
                          $(".sku-item .list a").on("click", function(){
                            skuItemClick($(this));
                          });
                          //sku默认选择套餐类型第一个
                          if($(".sku-item .list a.active").length<=0){
                            skuItemClick($("#sku-format .list a").eq(0));
                          }
                        //如果只有一个sku,默认选中
                        if(skuData.length == 1){
                            skuItemClick($("#sku-color .list a").eq(0));
                        }
                        }else{
                          $("#sku-color .list a, #sku-format .list a").addClass("disable");
                        }
                        function skuItemClick(obj){
                          var _this = obj;
                          clickBuy = false;
                          if(_this.hasClass("disable")) return;
                          $(".popup-sku").attr("data-skuId", "");
                          $("#buy").attr("href", "javascript:;").addClass("gray");
                          var skuColor = null, skuFormat = null, chooseNum = 0;
                          //点击样式
                          if(_this.hasClass("active")){
                            _this.removeClass("active");
                          }else{
                            _this.siblings('a').removeClass("active");
                            _this.addClass("active");
                          }

                          //选择的值
                          skuColor = $("#sku-color .list a.active").html();
                          skuFormat = $("#sku-format .list a.active").html();
                          if(!skuFormat && !skuColor){
                            $("#sku-choose").html("请选择规格和套餐类型");
                          }else{
                            var chooseTxt = '';
                            !!skuColor ? chooseTxt+='"' + skuColor + '"' : '';
                            !!skuFormat ? chooseTxt+='、"' + skuFormat + '"' : '';
                            $("#sku-choose").html('已选择' + chooseTxt);
                          }

                          if(!!skuFormat){
                            $("#sku-format .list a.active").siblings('a').addClass("disable");
                            $("#sku-color .list a").not(".active").addClass("disable");
                            for(var item in skuData){
                              if(skuData[item]["skuFormat"] == skuFormat){
                                $("#sku-color .list a").each(function(index, el) {
                                  if($(el).html() == skuData[item]["skuColor"]){
                                    $(el).removeClass("disable");
                                  }
                                });
                              }
                            }
                          }
                          if(!!skuColor){
                            $("#sku-color .list a.active").siblings('a').addClass("disable");
                            $("#sku-format .list a").not(".active").addClass("disable");
                            for(var item in skuData){
                              if(skuData[item]["skuColor"] == skuColor){
                                $("#sku-format .list a").each(function(index, el) {
                                  if($(el).html() == skuData[item]["skuFormat"]){
                                    $(el).removeClass("disable");
                                  }
                                });
                              }
                            }
                          }

                          if(!!skuFormat && !!skuColor){
                            var url = $(".popup-sku").attr("data-href"),
                              skuId = '';
                            var skuImg = '';
                            for(var item in skuData){
                              if(skuData[item]["skuColor"] == skuColor && skuData[item]["skuFormat"] == skuFormat){
                                // $(".popup-sku").attr("data-skuId", skuData[item]["id"]);
                                skuId = skuData[item]["id"];
                                skuImg = skuData[item]["skuImg"];
                              }
                            }
                            _genUrl({"skuid":skuId});
                            if(skuImg !="" && skuImg != null){
                              $(".popup-sku .info .img img").attr("src", skuImg);
                            }
                            $("#buy").removeClass("gray");
                            clickBuy = true;
                          }else if(!skuFormat && !skuColor){
                            $("#sku-color .list a, #sku-format .list a").removeClass("disable");
                            clickBuy = false;
                          }
                        }
                      }else{
                        $.toast(req.msg);
                      }

                      $.popup(".popup-sku");      //弹出弹窗
                      $("#buy-num").val(1);
                      $.hideIndicator();          //关闭加载指示器
                    }

                    function _genUrl(_json){
                      if(typeof(_json) != "undefined"){
                        for(var o in _json){
                          jsonUrlParam[o] = _json[o];
                        }
                      }
                      var _arr = [];
                      for(var o in jsonUrlParam){
                        _arr.push(o+"="+jsonUrlParam[o]);
                      }
                      return $(".popup-sku").attr("data-href")+"?"+_arr.join("&");
                    }
                <?php } ?>


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

        <?php if(!empty($skus)){ ?>
            <div class="popup popup-sku" style="display:none">
                <div>
                    <a href="javascript:;" class="close-popup"></a>
                    <div class="info">
                        <div class="img"><img src="<?php echo $info['banners'][0]['bannerImage'];?>" /></div>
                        <div class="main">
                            <div class="name"><?php echo $info['products']['productName'];?></div>
                            <div class="price">￥<span id="sku-price"><?php echo $ObjGrouponInfo['result']['realPrice'];?></span></div>
                            <div class="skuTxt" id="sku-choose">请选择规格和套餐类型</div>
                        </div>
                    </div>
            <?php foreach($skus['skuList'] as $_sku){ ?>
              <div class="sku-item" id="<?php if($_sku['skuType'] == 1){ ?>sku-color<?php }elseif($_sku['skuType'] == 2){ ?>sku-format<?php } ?>">
                <h4 class="title1">
                  <?php if($_sku['skuType'] == 1){ ?>
                    规格
                  <?php }elseif($_sku['skuType'] == 2){ ?>
                    套餐类型
                  <?php } ?>
                </h4>
                <div class="list"></div>
              </div>
            <?php } ?>
                    <a id="buy" href="javascript:;" class="go">确定</a>
                </div>
            </div>
     <?php }?>
      <?php if($ObjGrouponInfo['result']['isJoin']  ==1 && $ObjGrouponInfo['result']['isPublic']  ==1 && $ObjGrouponInfo['result']['isStart']  ==2 && $ObjGrouponInfo['result']['isWin']  ==1  && $ObjGrouponInfo['result']['isRecCoupon']  ==1 && $ObjGrouponInfo['result']['isAlert']  ==0 && $ObjGrouponInfo['result']['prize']  !=1 ){?>
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
  
</body>

</html>
