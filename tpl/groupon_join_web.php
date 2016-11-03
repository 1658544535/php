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
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/baiduTemplate.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="/js/wxshare.js"></script>
	<script type="text/javascript">
	var imgUrl = "<?php echo $fx['image'];?>";
	var link   = "<?php echo $fx['url'];?>";
	var title  = "<?php echo $fx['title'];?>";
	var desc   = "<?php echo $fx['content'];?>";
	wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
	</script>
</head>

<body>
    <div class="page-group" id="page-proTips">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="index.php">
                    <span class="icon icon-back"></span>
                </a>
                <?php if($info['isSellOut'] ==1){?>
                <h1 class="title">组团失败</h1>
                <?php }else{?>
                <h1 class="title">
					<?php $pageHeadTitles = array(0=>'我要组团', 1=>'组团成功', 2=>'组团失败'); ?>
					<?php echo $pageHeadTitles[$info['status']];?>
				</h1>
            <?php }?>
            </header>

		<?php if($info['isSellOut'] ==1){?>
		 <section class="proTips-5">
		   <a href="/">
	         <div class="info">
				<?php echo $info['groupNum'];?>人成团&nbsp;&nbsp;当前团<?php echo $info['joinNum'];?>人 &nbsp;
                               ￥<span class="price1"><?php echo $info['groupPrice'];?></span>
			 </div>
			   <span class="btn">更多拼团 ></span>
			</a>
		 </section>
		 <?php }else{?>
			<section class="proTips-5">
				<?php switch($info['status']){
					case 0: ?>
						<?php if($info['userIsHead'] == 1){ ?>
							<a href="/">
								<div class="info">
									<?php echo $info['groupNum'];?>人成团&nbsp;&nbsp;当前团<?php echo $info['joinNum'];?>人 &nbsp;
									￥<span class="price1"><?php echo $info['groupPrice'];?></span>
								</div>
								<span class="btn">更多拼团 ></span>
							</a>
						<?php }elseif($info['isGroup'] == 0){ ?>
							<a id="openSku" data-href="order_join.php" data-ref="groupon">
							<!-- <a href="order_join.php?id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>&free=<?php echo $isGrouponFree;?>&aid=<?php echo $attendId;?>"> -->
								<div class="info">
									<?php echo $info['groupNum'];?>人成团&nbsp;&nbsp;当前团<?php echo $info['joinNum'];?>人 &nbsp;
									￥<span class="price1"><?php echo $info['groupPrice'];?></span>
								</div>
								<span class="btn">我要拼团 ></span>
							</a>
						<?php } ?>
					<?php break; ?>
					<?php case 1: ?>
						<?php if($info['isGroup'] == 1){ ?>
							<a href="/">
								<div class="info">
									<?php echo $info['groupNum'];?>人召集完毕&nbsp;&nbsp;
									￥<span class="price1"><?php echo $info['groupPrice'];?></span>
								</div>
								<span class="btn">更多拼团 ></span>
							</a>
						<?php }else{ ?>
							<a href="/">
								<div class="info">
									马上开团
								</div>
								<span class="btn">更多拼团 ></span>
							</a>
						<?php } ?>
					<?php break; ?>
					<?php case 2: ?>
						<a href="/">
							<div class="info">
								<?php echo $info['groupNum'];?>人成团&nbsp;&nbsp;当前团<?php echo $info['joinNum'];?>人 &nbsp;
								￥<span class="price1"><?php echo $info['groupPrice'];?></span>
							</div>
							<span class="btn">更多拼团 ></span>
						</a>
					<?php break; ?>
				<?php } ?>
			</section>
		<?php }?>
			<?php if($info['status'] ==2 && $info['activityType'] ==5){?>
			<section class="proTips-6">
                <div>
                    <a href="lottery_new.php" class="light">查看更多</a>
                </div>
            </section>
           <?php }elseif($info['status'] ==1 && $info['activityType'] ==5){?>
           <section class="proTips-6">
                <div>
                    <a href="lottery_new.php" class="light">查看更多</a>
                </div>
            </section>
            <?php }?>
            <div class="content native-scroll">
				<?php if($info['isSellOut'] ==1){?>
					<section class="proTips-1">	
						<input type="hidden" id="showShare" />
							<div class="txt1">
								<div class="img"><img src="images/tip-fail.png" /></div>
									组团失败，商品已售罄
								</div>
				   </section>
			   <?php }else{?> 
				<section class="proTips-1">
					<?php switch($info['status']){
						case 0: ?>
							<input type="hidden" id="showShare" />
							<?php if($info['userIsHead'] == 1){ ?>
								<div class="txt1">
									<div class="img"><img src="images/tip-success.png" /></div>
									恭喜你，开团成功！
								</div>
								<div class="txt2">还差<?php echo $info['poorNum'];?>人，赶紧分享召集小伙伴组团啦！</div>
							<?php }elseif($info['isGroup'] == 0 ){ ?>
								<div class="txt1">
									<div class="img"><img src="images/tip-ing.png" /></div>
									您终于来了，快参团吧！
								</div>
								<div class="txt2">已有<?php echo $info['joinNum'];?>人参团，还差<?php echo $info['poorNum'];?>人，赶快分享召集小伙伴组团啦.</div>
							<?php } ?>
						<?php break; ?>
						<?php case 1: ?>
							<?php if($info['isGroup'] == 1){ ?>
								<div class="txt1">
									<div class="img"><img src="images/tip-success.png" /></div>
									恭喜您，拼团成功！
								</div>
								<div class="txt2">小伙伴已集结完毕，商品会尽快向各位发货，请耐心等待.</div>
							<?php }else{ ?>
								<div class="txt1">
									<div class="img"><img src="images/tip-fail.png" /></div>
									您来晚了，已经成团！
								</div>
								<div class="txt2">赶紧点击“我要开团”，疯抢起来吧！</div>
							<?php } ?>
						<?php break; ?>
						<?php case 2: ?>
								<?php if($info['activityType'] != 5){?>
									<div class="txt1">
										<div class="img"><img src="images/tip-fail.png" /></div>
										很遗憾，组团失败！
									</div>
									<div class="txt2">拼团期内未达到成团人数，系统会在1-2个工作日内，按原路自动退款至各位成员.</div>
								 <?php }else{?>
									   <div class="txt1">
										<div class="img"><img src="images/tip-fail.png" /></div>
										很遗憾，该团已过期
									</div>
									<div class="txt2">组团时间到，未召集到相应人数的小伙伴！</div>
							     <?php }?>
						<?php break; ?>
					<?php }?>
				</section>
		    <?php } ?>
	    <?php if($info['activityType'] != 5 ){?>
                <section class="freeList proTips-2">
                    <h3 class="title1">拼团商品</h3>
                    <ul class="list-container">
                        <li><a href="<?php if($jumpProduct){ ?>groupon.php?id=<?php echo $grouponId;?><?php }else{ ?>javascript:;<?php } ?>">
                            <div class="img"><img src="<?php echo $info['productImage'];?>"></div>
                            <div class="info">
                                <div class="name"><?php echo $info['productName'];?></div>
                                <div class="price">
                                    <?php if($jumpProduct){ ?><div class="btn">商品详情</div><?php } ?>
                                    拼团价：<span class="price1">￥<?php echo $info['groupPrice'];?></span>
                                    <span class="price2">￥<?php echo $info['alonePrice'];?></span>
                                </div>
                            </div>
                        </a></li>
                    </ul>
                </section>
          <?php }else{?>
                <section class="freeList proTips-2">
                    <h3 class="title1">拼团商品</h3>
                    <ul class="list-container">
                        <li><a href="javascript:;">
                            <div class="img"><img src="<?php echo $info['productImage'];?>"></div>
                            <div class="info">
                                <div class="name"><?php echo $info['productName'];?></div>
                                <div class="price">
                                    <div class="btn" onclick="location.href='groupon.php?id=<?php echo $grouponId;?>'">商品详情</div>
                                    <?php if($info['status'] !=0){?>
                                    <div class="btn gray" onclick="location.href='lottery_new.php?act=winning&attId=<?php echo $info['recordId'];?>'">中奖详情</div>
                                     <?php }?>                  
                                    <span class="price1">￥<?php echo $info['groupPrice'];?></span>
                                </div>
                            </div>
                        </a></li>
                    </ul>
                </section>
           <?php }?>
                
                
               
               <section class="proTips-3">
                 <?php if($info['isSellOut'] ==1){?>
                         <div class="title1"> 
						     <p class="time themeColor">组团失败，商品已售罄</p>
						<span>参团小伙伴</span>
						</div>	    
				<?php }else{?>
                    <div class="title1">
						<?php switch($info['status']){
							case 0: ?>
								<div class="time">本团将于<div id="downTime" data-timer="<?php echo $info['remainSec'];?>"></div>结束</div>
							<?php break; ?>
							<?php case 2: ?>
							      <p class="time themeColor">本团已结束</p>
							<?php break; ?>
						<?php } ?>
                        <span>参团小伙伴</span>
                    </div>
                 <?php }?>
                    <ul class="list">
						<?php foreach($info['groupUserList'] as $v){ ?>
							<li>
								<div class="img"><img src="<?php echo $v['userImage']?$v['userImage']:'/images/def_user.png';?>" /></div>
								<div class="name">
									<?php if($v['isHead']){ ?><span>团长</span><?php } ?>
									<p><?php echo $v['userName'];?></p>
								</div>
								<div class="time"><?php echo $v['joinTime'];?></div>
							</li>
						<?php } ?>
						<?php switch($info['status']){
							case 0: ?>
								<li class="join">
									<div class="img"></div>
									<div class="tips">
										已有<?php echo $info['joinNum'];?>人参团，还差<?php echo $info['poorNum'];?>人，快加入我们吧！
									</div>
								</li>
							<?php break; ?>
							<?php case 2: ?>
								<li class="fail">
									<div class="tips">组团时间到，未召集到相应人数的小伙伴！</div>
								</li>
							<?php break; ?>
						<?php } ?>
                    </ul>   
                 
                </section>

                <section class="deta-tips proTips-4">
                    <h3>活动说明</h3>
                    <div><img src="images/deta-tips2.png" /></div>
                </section>
            </div>
			
        </div>

        <script>
            $(document).on("pageInit", "#page-proTips", function(e, pageId, page) {
				<?php if($info['productStatus'] == 1){ ?>
					var jsonUrlParam = {"id":"<?php echo $grouponId;?>","pid":"<?php echo $info['productId'];?>","skuid":"","num":1,"free":"<?php echo $isGrouponFree;?>","aid":"<?php echo $attendId;?>","as":"<?php echo $info['activityType'];?>"};
					var clickBuy = false;

					$("#openSku").on("click", function(){
						$(".popup-sku").attr("data-href", $(this).attr("data-href"));
						$("#sku-price").html($(this).find(".price1").html());
						// if($(this).attr("data-ref") == "free"){
						// 	$(".popup-sku .sku-number").hide();
						// 	$("#buy-num").val("1");
						// }else{
							$(".popup-sku .sku-number").show();
						// }
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

            });
        </script>

		<?php if(!empty($skus)){ ?>
        <div class="popup popup-sku" style="display:none">
            <div>
                <a href="javascript:;" class="close-popup"></a>
                <div class="info">
                    <div class="img"><img src="<?php echo $info['banners'][0]['bannerImage'];?>" /></div>
                    <div class="main">
                        <div class="name"><?php echo $info['products']['productName'];?></div>
                        <div class="price">￥<span id="sku-price">-</span></div>
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
				<?php if($info['activityType'] != 5 && $info['activityType'] != 6){?>
                <div class="sku-number">
                    <span class="label">购买数量</span>
                    <div class="quantity">
                        <span class="minus">-</span>
                        <input type="text" value="1" id="buy-num" class="num" />
                        <span class="plus">+</span>
                    </div>
                </div>
                <?php } ?>
                <a id="buy" href="javascript:;" class="go">确定</a>
            </div>
        </div>
		<?php } ?>

        <?php if($showBlack){ ?>
        <div class="popup popup-share popup-share2">
            <a href="javascript:;" class="close-popup"></a>
            <div class="">
            	<div class="s-1">还差 <span><?php echo $info['poorNum'];?></span> 人，邀请好友参团吧</div>
            	<div class="s-2">点击右上角按钮，发送给朋友或群聊</div>
            	<div class="s-3">拼团人数不足退款</div>
            </div>
        </div>
        <?php } ?>
    </div>
</body>

</html>
