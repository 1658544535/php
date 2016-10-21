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
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="/js/wxshare.js"></script>
	<script type="text/javascript">
	var imgUrl = "<?php echo $info['banners'][0]['bannerImage'];?>";
	var link   = window.location.href;
	var title  = "<?php echo $info['productPrice'];?>元的<?php echo $info['productName'];?>";
	var desc   = "<?php echo $info['productSketch'];?>";
	wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
	</script>
</head>

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
						</div>
						<div class="name"><?php echo $info['productName'];?></div>
						<div class="txt"><?php echo $info['productSketch'];?></div>
						<div class="tips"><img src="images/deta-tips.png" /></div>
					</section>

					<?php if(!$isFreeBuy && !empty($info['waitGroupList'])){ ?>
					<section class="deta-group">
						<h3 class="title1">欢迎您直接参与其他小伙伴发起的拼团</h3>
						<ul class="list">
							<?php foreach($info['waitGroupList'] as $_active){ ?>
							<li>
								<a class="btn" href="groupon_join.php?aid=<?php echo $_active['groupRecId'];?>&pid=<?php echo $info['productId'];?>&free=<?php echo ($info['activityType']==2)?1:0;?>">参团&nbsp;&gt;</a>
								<div class="info">
									<div class="img"><img src="<?php echo $_active['userImage'];?>" /></div>
									<div class="name"><?php echo $_active['userName'];?></div>
									<div class="num">还差 <?php echo $_active['oweNum'];?> 人成团</div>
									<div class="timer" data-timer="<?php echo $_active['remainSec'];?>"><i class="icon-timer"></i><span></span> 后结束</div>
								</div>
							</li>
							<?php } ?>
						</ul>
					</section>
					<?php } ?>

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
					<div class="buy buy-m2">
						<?php if($info['productStatus'] == 0){ ?>
							<a style="background-color:#999">已下架</a>
							<a class="more" href="/">查看更多</a>
						<?php }else{ ?>
							<!-- <a class="one" href="order_alone.php?id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>" id="btn-alone"> -->
							<a class="one" data-href="order_alone.php" id="btn-alone" data-ref="alone">
								 <p>￥<b><?php echo $info['alonePrice'];?></b></p>
								 <p>单独购买</p>
							</a>
							<?php if($isFreeBuy){ ?>
								<!-- <a class="more" href="order_free.php?id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>" id="btn-groupon"> -->
								<a class="more" data-href="order_free.php" id="btn-groupon" data-ref="free">
									 <p>￥<b>0.00</b></p>
									 <p>0元开团</p>
								</a>
							<?php }else{ ?>
								<!-- <a class="more" href="order_groupon.php?id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>" id="btn-groupon"> -->
								<a class="more" data-href="order_groupon.php" id="btn-groupon" data-ref="groupon">
									 <p>￥<b><?php echo $info['productPrice'];?></b></p>
									 <p><?php echo $info['groupNum'];?>人团</p>
								</a>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
        </div>

		<?php
		$_arrDomain = explode('.', $_SERVER['SERVER_NAME']);
		array_shift($_arrDomain);
		?>

        <script>
			var _apiUrl = "/api_action.php?act=";
			document.domain='<?php echo implode('.', $_arrDomain);?>';
			<?php if($info['productStatus'] == 1){ ?>
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
			<?php } ?>

            $(document).on("pageInit", "#page-deta", function(e, pageId, page) {
				<?php if($info['productStatus'] == 1){ ?>
					var jsonUrlParam = {"id":"<?php echo $grouponId;?>","pid":"<?php echo $info['productId'];?>","skuid":"","num":1};
					var clickBuy = false;

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
						if(clickBuy) location.href = _genUrl();
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
						 $(".popup-sku .info .img img").attr("src", req["data"]["validSKu"][0]["skuImg"]);

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

							//绑定点击事件
							$(".sku-item .list a").on("click", function(){
								clickBuy = false;
								if($(this).hasClass("disable")) return;
								$(".popup-sku").attr("data-skuId", "");
								$("#buy").attr("href", "javascript:;").addClass("gray");
								var skuColor = null, skuFormat = null, chooseNum = 0;
								//点击样式
								if($(this).hasClass("active")){
									$(this).removeClass("active");
								}else{
									$(this).siblings('a').removeClass("active");
									$(this).addClass("active");
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
	//                                url += "?skuid=" + skuId + "&id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>&num="+$("#buy-num").val();
	//                                $("#buy").attr("href", url).removeClass("gray");
								}else if(!skuFormat && !skuColor){
									$("#sku-color .list a, #sku-format .list a").removeClass("disable");
									clickBuy = false;
								}
							});
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
                <div class="sku-number">
                    <span class="label">购买数量</span>
                    <div class="quantity">
                        <span class="minus">-</span>
                        <input type="text" value="1" id="buy-num" class="num" />
                        <span class="plus">+</span>
                    </div>
                </div>
                <a id="buy" class="go">确定</a>
            </div>
        </div>
		<?php } ?>

		<div class="popup popup-share">
            <a href="javascript:;" class="close-popup"></a>
        </div>
    </div>
</body>

</html>








