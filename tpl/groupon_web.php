<?php include_once('header_web.php');?>
    <script type="text/javascript" src="/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="/js/wxshare.js"></script>
	<script type="text/javascript">
	var imgUrl = "<?php echo $fx['image'];?>";
	var link   = "<?php echo $fx['url'];?>";
	var title  = "<?php echo $fx['title'];?>";
	var desc   = "<?php echo $fx['content'];?>";
	wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
</script>

<body>
    <div class="page-group" id="page-deta">
        <div id="page-nav-bar" class="page page-current">

            <div class="content native-scroll"<?php if($info['productStatus'] == 1){ ?> style="top:0rem;bottom:2.75rem;"<?php } ?>>

				<a href="javascript:history.back(-1);" class="back deta-back"></a>
				<?php if($info['productStatus'] == 1){ ?><a href="javascript:;" class="deta-share"></a><?php } ?>

				<?php if($info['productStatus'] == 0){ ?><section class="pro-null"></section><?php } ?>

				<?php if($info['productStatus'] == 1){ ?>
					<section class="swiper-container deta-banner" data-space-between="0">
						<div class="swiper-wrapper">
							<?php foreach($info['banners'] as $v){ ?>
								<div class="swiper-slide"><img src="<?php echo $v['bannerImage'];?>" /></div>
							<?php } ?>
						</div>
						<div class="swiper-pagination"></div>
					</section>

					<section class="deta-info">
						<div class="d-i-1">
							<span class="sales">累积销量：<?php echo $info['proSellrNum'];?>件</span>
							￥<span class="nowPrice"><?php echo $info['productPrice'];?></span>
							<span class="oldPrice">￥<?php echo $info['sellingPrice'];?></span>
							<?php switch($info['activityType']){
								case 5: ?>
									<span class="stips">团长必中 团员抽奖</span>
									<?php break; ?>
								<?php case 7: ?>
									<span class="stips">免费开团</span>
									<?php break; ?>
							<?php } ?>
						</div>
						<div class="name"><?php echo $info['productName'];?></div>
						<div class="txt"><?php echo $info['productSketch'];?></div>
						<?php if($info['activityType'] == 5){ ?>
							<div class="txt2">
								<div>活动时间：<b class="themeColor"><?php echo $info['activitySTime'];?></b> 到 <b class="themeColor"><?php echo $info['activityETime'];?></b></div>
                                <div>活动规则：</div>
								<div>1、0.1元支付开团，规定时间内邀请好友支付0.1元参团，成团即开奖。</div>
								<div>2、团长必中，并从每个成团中抽取一个幸运团成员，获得奖品。</div>
								<div>3、不成团或无中奖用户均全额退款。</div>
								<div>4、每人均有一次开团与一次参团机会。每个人每个订单限购数量为1。</div>
								<div>5、活动奖品预计开奖后72小时内发放。</div>
							    <div>6、同一产品，同一地址、同一手机号、同一支付账号均为同一用户，重复参与将视为无效，系统会关闭订单并退款。</div>
							    <div>温馨提醒：</div>
							    <div>每个团组团有效期为6个小时，如团结束时间大于活动结束时间时，则按活动结束的时间。<br />
							                  任何刷奖等作弊行为均视为无效，在法律允许范围内，拼得好拥有本次活动最终解释权！</div>
							</div>
						<?php }elseif($info['activityType'] == 6){ ?>
							<div class="txt2">【活动说明：活动 <b class="themeColor"><?php echo $info['startTime'];?></b> 开始，限量 <b class="themeColor"><?php echo $info['limitNum'];?> </b>份，售完即止！商品售完时未能成团者即视为活动失败】</div>
						<?php } elseif ($info['activityType'] == 7) { ?>
                            <div class="txt2">
                                <div>活动时间：<b class="themeColor"><?php echo $info['activitySTime'];?></b> 到 <b class="themeColor"><?php echo $info['activityETime'];?></b></div>
                                <div>活动规则：</div>
                                <div>1、0元立即开团，规定时间内邀请好友一起0元拼团，拼团成功后将进入待抽奖箱。</div>
                                <div>2、待活动时间结束，系统将随机抽取幸运的中奖团，该团成员将获得奖品。</div>
                                <div>3、不成团或无中奖用户均全额退款。</div>
                                <div>4、每人均有一次参与（开团或参团）机会。</div>
                                <div>5、活动奖品预计开奖后72小时内发放。</div>
                                <div>温馨提醒：</div>
                                <div>每个团组团有效期为24个小时，如团结束时间大于活动结束时间时，则按活动结束的时间。 </div>
                            </div>
                        <?php } ?>
						<div class="tips"><img src="images/deta-tips.png" /></div>
						<?php if($info['activityType'] == 6){ ?>
							<?php $seckillStateIcons = array('notstart'=>'soon', 'end'=>'over', 'sellout'=>'out', 'selling'=>'ing'); ?>
							<div class="icon"><img src="images/seckill-<?php echo $seckillStateIcons[$seckillState];?>.png" /></div>
						<?php } ?>
					</section>
                 <?php if($info['activityType'] !=8){?>
					<?php if($showWaitGroupList && !empty($info['waitGroupList'])){ ?>
					<section class="deta-group">
						<h3 class="title1">欢迎您直接参与其他小伙伴发起的拼团</h3>
						<ul class="list">
							<?php foreach($info['waitGroupList'] as $_active){ ?>
							<li>
								<a class="btn" href="groupon_join.php?aid=<?php echo $_active['groupRecId'];?>&pid=<?php echo $info['productId'];?>&free=<?php echo ($info['activityType']==2)?1:0;?>">参团&nbsp;&gt;</a>
								<div class="info">
									<div class="img"><img src="<?php echo $_active['userImage']?$_active['userImage']:'/images/def_user.png';?>" /></div>
									<div class="name"><?php echo $_active['userName'];?></div>
									<div class="num">还差 <?php echo $_active['oweNum'];?> 人成团</div>
									<div class="timer" data-timer="<?php echo $_active['remainSec'];?>"><i class="icon-timer"></i><span></span> 后结束</div>
								</div>
							</li>
							<?php } ?>
						</ul>
					</section>
					<?php } ?>
                 <?php }?>
					<section class="deta-tips">
						<h3>活动说明</h3>
						<div><img src="images/deta-tips2.png" /></div>
					</section>

					<div class="deta-iframe">
						<iframe id="proInfo" src="<?php echo API_URL;?>/getProductInfoView.do?id=<?php echo $info['productId']?>" frameborder="0" width="100%"></iframe>
					</div>
				<?php } ?>

                <section class="pro-like">
                    <h3 class="title1"><!--猜你喜欢--></h3>
                    <ul>
						<?php foreach($likes as $v){ ?>
							<li>
								<a class="img" href="groupon.php?id=<?php echo $v['activityId'];?>"><img src="<?php echo $v['productImage'];?>" /></a>
								<a class="name" href="groupon.php?id=<?php echo $v['activityId'];?>"><?php echo $v['productName'];?></a>
								<div class="price">
									<a href="javascript:;" class="collect<?php if($v['isCollect']==1){?> active<?php } ?>" data-collect="<?php echo ($v['isCollect']==1)?'1':'0';?>" data-actid="<?php echo $v['activityId'];?>" data-pid="<?php echo $v['productId'];?>"><!--收藏--></a>
									￥<span><?php echo $v['price'];?></span>
								</div>
							</li>
						<?php } ?>
                    </ul>
                </section>
            </div>

			<?php if($info['productStatus'] == 1){ ?>
				<div class="deta-footer">
					<a class="goIndex" href="/">
						<span class="icon i-home"></span>
						<span class="tab-label">首页</span>
					</a>
					<a class="goCollection<?php if($collected){?> active<?php } ?>" href="javascript:;" data-collect="<?php echo $collected?'1':'0';?>">
						<span class="icon i-collection"></span>
						<span class="tab-label">收藏</span>
					</a>
					<?php switch($info['activityType']){
						case 5://0.1抽奖
						case 7://免费抽奖
							$orderUrl = ($info['activityType'] == 5) ? 'order_raffle01.php' : 'order_raffle.php';
						?>
							<?php if($info['activityStatus'] == 2){ ?>
								<?php if($info['activityType'] == 5){ ?>
									<div class="more1 more1-m2"><a href="lottery_new.php?act=winning&aid=<?php echo $info['activityId'];?>&type=5">查看中奖名单</a></div>
								<?php }else{ ?>
									<?php switch($info['isWaitOpen']){
										case 1: ?>
											<div class="more1 more1-m2" style="background: #7D7D7D;"><a href="javascript:;" class="gray">等待开奖中</a></div>
											<?php break; ?>
										<?php case 2: ?>
											<div class="more1 more1-m2"><a href="lottery_new.php?act=winning&aid=<?php echo $info['activityId'];?>&type=7">查看中奖名单</a></div>
											<?php break; ?>
									<?php } ?>
								<?php } ?>
							<?php }elseif($info['activityStatus'] == 1){ ?>
								<?php if($info['activityType'] == 7  && $info['isOpen'] == 1){ ?>
									<div class="more1 more1-m2" style="background: #7D7D7D;"><a href="javascript:;" class="gray">您已参与过该活动</a></div>
								<?php }elseif(empty($skus['validSKu'])){ ?>
									<div class="more1 more1-m2" style="background: #7D7D7D;"><a href="javascript:;" class="gray">商品已售罄</a></div>
							    <?php }else{ ?>
									<div class="buy more1 more1-m2">
										<a id="openSku" data-href="<?php echo $orderUrl;?>">
                                            <?php if ($info['activityType'] == 5) { ?>
                                                <p>￥<b><?php echo $info['productPrice'];?></b></p>
                                            <?php } elseif ($info['activityType'] == 7) { ?>
                                                <p>￥<b><?php echo $info['productPrice'];?></b></p>
                                            <?php } ?>
											<p><?php echo $info['groupNum'];?>人成团</p>
										</a>
									</div>
								<?php } ?>
							<?php } ?>
						<?php break; ?>
						<?php case 6://限时秒杀
							switch($seckillState){
								case 'end': ?>
								<?php case 'sellout': ?>
								  <?php if(empty($skus['validSKu'])){ ?>
									<div class="more1 more1-m2" style="background: #7D7D7D;"><a href="javascript:;" class="gray">商品已售罄</a></div>
							    <?php }else{?>
									<div class="more1 more1-m2"><a href="seckill.php">更多拼团</a></div>
								<?php }?>
								<?php break; ?>
								<?php case 'notstart': ?>
									<div class="more1 more1-m2"><a href="seckill.php">即将开始</a></div>
								<?php break; ?>
								<?php case 'selling': ?>
									<div class="buy more1 more1-m2">
										<a id="openSku" data-href="order_seckill.php">
											<p>￥<b><?php echo $info['productPrice'];?></b></p>
											<p><?php echo $info['groupNum'];?>人成团</p>
										</a>
									</div>
								<?php break; ?>
							<?php } ?>
						<?php break; ?>
						<?php default: ?>
							<div class="buy buy-m2">
								<?php if($info['productStatus'] == 0){ ?>
									<a style="background-color:#999">已下架</a>
									<a class="more" href="/">查看更多</a>
								<?php }elseif(empty($skus['validSKu'])){ ?>
									<a style="background-color:#999; width:100%">商品已售罄</a>
								<?php }else{?>
									<!-- <a class="one" href="order_alone.php?id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>" id="btn-alone"> -->
									<a class="one" data-href="order_alone.php" id="btn-alone" data-ref="alone">
										 <p>￥<b><?php echo $info['alonePrice'];?></b></p>
										 <p>单独购买</p>
									</a>
									<?php if($isFreeBuy){ ?>
										<!-- <a class="more" href="order_free.php?id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>" id="btn-groupon"> -->
										<a class="more" data-href="order_free.php" id="btn-groupon" data-ref="free">
											 <p>￥<b>0.00</b></p>
											 <p><?php echo $info['groupNum'];?>人团</p>
										</a>
									<?php } elseif($info['activityType'] == 8){?>
										<a class="more" data-href="order_pdk.php" id="btn-groupon" data-ref="pdk">
											 <?php if($info['isPdk'] ==1 && $pdkUid ==$userid){?> 
											  <p>￥<b>0.00</b></p>
											 <?php }elseif($info['isPdk'] ==1 && $pdkUid ==''){?>
											  <p>￥<b>0.00</b></p>
											 <?php }else{?>
											  <p>￥<b><?php echo $info['productPrice'];?></b></p>
											 <?php }?>
											 <p><?php echo $info['groupNum'];?>人团</p>
										</a>
									<?php }else{ ?>
										<!-- <a class="more" href="order_groupon.php?id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>" id="btn-groupon">-->
										<a class="more" data-href="order_groupon.php" id="btn-groupon" data-ref="groupon">
											 <p>￥<b><?php echo $info['productPrice'];?></b></p>
											 <p><?php echo $info['groupNum'];?>人团</p>
										</a>
									<?php } ?>
								<?php } ?>
							</div>
						<?php break; ?>
					<?php } ?>
				</div>
			<?php } ?>
        </div>

		<?php
		$_arrDomain = explode('.', $_SERVER['SERVER_NAME']);
		array_shift($_arrDomain);
		?>

        <script>
// 			 var _apiUrl = "/api_action.php?act=";
	//		document.domain='<?php echo implode('.', $_arrDomain);?>';
			 <?php if($info['productStatus'] == 1){ ?>
// 			 function setIframeHeight(iframe) {
// 			  	if (iframe) {
// 			  		var iframeWin = iframe.contentWindow || iframe.contentDocument.parentWindow;
// 			  		if (iframeWin.document.body) {
// 			  			iframe.height = iframeWin.document.documentElement.scrollHeight || iframeWin.document.body.scrollHeight;
// 			  		}
// 			  	}
// 			 };
// 			 window.onload = function () {
// 			  	setIframeHeight(document.getElementById('proInfo'));
// 			 };
			 <?php } ?>

            $(document).on("pageInit", "#page-deta", function(e, pageId, page) {

				<?php if($info['productStatus'] == 1){ ?>
					var jsonUrlParam = {"id":"<?php echo $grouponId;?>","pid":"<?php echo $info['productId'];?>","skuid":"","num":1,"pdkUid":"<?php echo $pdkUid;?>"};
					var clickBuy = false;

					<?php switch($info['activityType']){
						case 5://0.1抽奖
						case 6://限时秒杀
                        case 7://免费抽奖
					?>
							$("#openSku").on("click", function(){
								$(".popup-sku").attr("data-href", $(this).attr("data-href"));
								$("#sku-price").html($(this).find("b").html());
								skuOpen();
							});
						<?php break;?>
						<?php default: ?>
							$(".deta-footer .one, .deta-footer .more").on("click", function(){
								$(".popup-sku").attr("data-href", $(this).attr("data-href"));
								$("#sku-price").html($(this).find("b").html());
								if($(this).attr("data-ref") == "free"){
									$(".popup-sku .sku-number").hide();
									$("#buy-num").val("1");
								}else{
									$(".popup-sku .sku-number").show();
								}
								skuOpen();
							});
						<?php break;?>
					<?php } ?>

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
					$(".quantity .num").on("change", function(){
						var num = parseInt($(this).val());
						_genUrl({"num":num});
					});

					$("#buy").on("click", function(){
						// var url = _genUrl();
						// if(clickBuy) location.href = url;
						if(clickBuy){
							if($(this).data("isinv") == 1){
								$.prompt('请输入邀请码', function(txt){
									if($.trim(txt) == ''){
										$.toast('请输入邀请码');
									}else{
										_genUrl({"code":txt});
										var url = _genUrl();
										location.href = url;
									}
								})
							}else{
								var url = _genUrl();
								location.href = url;
							}
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
									itemHtml += '<a href="javascript:;">' + itemList[list]["optionValue"] + '</a>';
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
							$(".sku-item").each(function(index, el) {
								if($(el).find(".list").html() == ''){
									$(el).remove();
								}
							});

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

								// 没有选择sku
								if(!skuFormat && !skuColor){
									$("#sku-choose").html("请选择规格和套餐类型");
								}else{
									var chooseTxt = '';
									!!skuColor ? chooseTxt+='"' + skuColor + '"' : '';
									!!skuFormat ? chooseTxt+='、"' + skuFormat + '"' : '';
									$("#sku-choose").html('已选择' + chooseTxt);
								}

								// 只选择规格
								if(!!skuFormat){
									// 只有规格时
									if(data["skuList"].length==1 && data["skuList"][0]["skuType"] == 2){
										var url = $(".popup-sku").attr("data-href"),
											skuId = '';
										var skuImg = '';
										for(var item in skuData){
											if(skuData[item]["skuFormat"] == skuFormat){
												skuId = skuData[item]["id"];
												skuImg = skuData[item]["skuImg"];
											}
										}
										setSkuInfo(skuId, skuImg);
										clickBuy = true;
									}else{
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
								}

								// 只选择颜色
								if(!!skuColor){
									// 只有颜色时
									if(data["skuList"].length==1 && data["skuList"][0]["skuType"] == 1){
										var url = $(".popup-sku").attr("data-href"),
											skuId = '';
										var skuImg = '';
										for(var item in skuData){
											if(skuData[item]["skuColor"] == skuColor){
												skuId = skuData[item]["id"];
												skuImg = skuData[item]["skuImg"];
											}
										}
										setSkuInfo(skuId, skuImg);
										clickBuy = true;
									}else{
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
									
								}
                                if($(".sku-item a.active").length == 1){
                                    $(".sku-item a.active").siblings('a').removeClass("disable");
                                }

                                // 选择两种
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
									setSkuInfo(skuId, skuImg);									
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

					function setSkuInfo(skuId, skuImg){
						_genUrl({"skuid":skuId});
						if(skuImg !="" && skuImg != null){
							$(".popup-sku .info .img img").attr("src", skuImg);
						}
						$("#buy").removeClass("gray");
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


					//收藏
					$(".goCollection").on("click", function(){
						opCollect($(this), "<?php echo $info['activityId'];?>", "<?php echo $info['productId'];?>");
					});
				<?php } ?>

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
				<?php if(!$notQuantity){ ?>
                <div class="sku-number">
                    <span class="label">购买数量</span>
                    <div class="quantity">
                        <span class="minus">-</span>
                        <input type="text" value="1" id="buy-num" class="num" />
                        <span class="plus">+</span>
                    </div>
                </div>
				<?php } ?>
				<?php if($info['activityType'] == 5){?>
                  <a id="buy" href="javascript:;" class="go" data-isinv="<?php echo $info['isInv']?>">确定</a>
	            <?php }else{?>
	              <a id="buy" href="javascript:;" class="go" >确定</a>
	            <?php }?>
            </div>
        </div>
		<?php } ?>

		<div class="popup popup-share">
            <a href="javascript:;" class="close-popup"></a>
        </div>


    </div>
</body>

</html>
