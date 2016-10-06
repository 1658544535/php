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
    <div class="page-group" id="page-deta">
        <div id="page-nav-bar" class="page page-current">

            <div class="content native-scroll" style="top:0rem;bottom:2.75rem;">

				<a href="javascript:history.back(-1);" class="back deta-back"></a>

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
                        <span class="oldPrice">￥<?php echo $info['alonePrice'];?></span>
                    </div>
                    <div class="name"><?php echo $info['productName'];?></div>
                    <div class="txt"><?php echo $info['productSketch'];?></div>
                    <div class="tips"><img src="images/deta-tips.png" /></div>
                </section>

				<?php if(!empty($info['waitGroupList'])){ ?>
                <section class="deta-group">
                    <h3 class="title1">欢迎您直接参与其他小伙伴发起的拼团</h3>
                    <ul class="list">
						<?php foreach($info['waitGroupList'] as $_active){ ?>
						<li>
                            <a class="btn" href="groupon_join.php?aid=<?php echo $_active['groupRecId'];?>&pid=<?php echo $info['productId'];?>&free=<?php echo $info['isGroupFree'];?>">参团&nbsp;&gt;</a>
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

				<div class="deta-iframe">
					<iframe id="proInfo" src="<?php echo API_URL;?>/getProductInfoView.do?id=<?php echo $info['productId']?>" frameborder="0" width="100%"></iframe>
				</div>

                <section class="deta-tips">
                    <h3>活动说明</h3>
                    <div><img src="images/deta-tips2.png" /></div>
                </section>

            </div>

			<div class="deta-footer">
                <a class="goIndex" href="/">
                    <span class="icon i-home"></span>
                    <span class="tab-label">首页</span>
                </a>
                <div class="buy">
					<?php if($info['productStatus'] == 0){ ?>
						<a class="one">下架</a>
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

            $(document).on("pageInit", "#page-deta", function(e, pageId, page) {
				var jsonUrlParam = {"id":"<?php echo $grouponId;?>","pid":"<?php echo $info['productId'];?>","skuid":"","num":1};

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
					$("#buy").attr("href", _genUrl());
				});


                //打开sku弹窗
                function skuOpen(){
                    $.showIndicator();          //打开加载指示器
                    
					 var req = {
					     msg: "",
					     code: 1,
					     data:  <?php echo empty($skus) ? '{}' : json_encode($skus);?> 
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

						//绑定点击事件
						$(".sku-item .list a").on("click", function(){
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
                                $("#sku-choose").html("请选择颜色和套餐类型");
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
                                for(var item in skuData){
                                    if(skuData[item]["skuColor"] == skuColor && skuData[item]["skuFormat"] == skuFormat){
                                        // $(".popup-sku").attr("data-skuId", skuData[item]["id"]);
                                        skuId = skuData[item]["id"];
                                    }
                                }
								_genUrl({"skuid":skuId});
								$("#buy").removeClass("gray");
//                                url += "?skuid=" + skuId + "&id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>&num="+$("#buy-num").val();
//                                $("#buy").attr("href", url).removeClass("gray");
                            }else if(!skuFormat && !skuColor){
                                $("#sku-color .list a, #sku-format .list a").removeClass("disable");
                            }
                        });
					}else{
						$.toast(req.msg);
					}
					
					$.popup(".popup-sku");      //弹出弹窗
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
                        <div class="skuTxt" id="sku-choose">请选择颜色和套餐类型</div>
                    </div>
                </div>
				<?php foreach($skus['skuList'] as $_sku){ ?>
					<div class="sku-item" id="<?php if($_sku['skuType'] == 1){ ?>sku-color<?php }elseif($_sku['skuType'] == 2){ ?>sku-format<?php } ?>">
						<h4 class="title1">
							<?php if($_sku['skuType'] == 1){ ?>
								颜色
							<?php }elseif($_sku['skuType'] == 2){ ?>
								规则
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
    </div>
</body>

</html>








