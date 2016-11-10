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
                <?php if($info['status'] ==2){?>
                <h1 class="title">拼团失败</h1>
                <?php }elseif($info['status'] ==1 && $info['isStart'] ==1 && $info['isGroup'] ==1){?>
                <h1 class="title">拼团成功</h1>
                <?php }elseif($info['status'] ==0 && $info['isGroup'] ==0){?>
                <h1 class="title">拼团中</h1>
                <?php }elseif($info['isSellOut'] ==1){?>
                <h1 class="title">商品已售罄</h1>
                <?php }elseif($info['userIsHead'] ==0 && $info['isGroup'] ==1 ){?>
                <h1 class="title">参团成功</h1>
                <?php }elseif($info['userIsHead'] ==1 && $info['status'] ==0 && $info['isStart'] ==1){?>
                <h1 class="title">开团成功</h1>
                <?php }elseif($info['status'] ==1 && $info['isStart'] ==1 && $info['isGroup'] ==0){?>
                <h1 class="title">已成团</h1>
                <?php }?>
            </header>

 <section class="proTipsNew-5">
       <?php if($info['isSellOut'] ==1){?>
                <div>
                    <a href="groupon.php" class="white">更多拼团</a>
                    <a>商品已售罄</a>
                </div>
      <?php }elseif(($info['activityType'] ==5) || ($info['activityType'] ==2) && $info['status'] ==2){?>
                 <div>
                    <?php if($info['activityType'] ==5){?>
                    <a href="lottery_new.php" class="white">更多拼团</a>
                    <?php }else{?>
                    <a href="index.php" class="white">更多拼团</a>
                    <?php }?>
                    <a>您已参与过该活动</a>
                </div>
      <?php }else{?>
             <?php switch($info['status']){
					case 0: ?>
						<?php if($info['userIsHead'] == 1){ ?>
							<div>
			                    <a href="index.php" class="white">更多拼团</a>
			                    <a href="javascript:;">还差<?php echo $info['poorNum'];?>人拼团成功</a>
			                </div>
						<?php }elseif($info['isGroup'] == 0){ ?>
							<div>
								<a href="index.php" class="white">更多拼团</a>
	                            <a href="order_join.php">我要参团</a>
							</div>
						<?php } ?>
					<?php break; ?>
					<?php case 1: ?>
						<?php if($info['isGroup'] == 1){ ?>
							<div>
			                    <a href="index.php" class="white">更多拼团</a>
			                    <a href="groupon.php?id=<?php echo $info['activityId'];?>">我要开团</a>
			                </div>
						<?php }else{ ?>
							<div>
								<a href="index.php" class="white">更多拼团</a>
		                        <a href="groupon.php?id=<?php echo $info['activityId'];?>">我要开团</a>
						   </div>
						<?php } ?>
					<?php break; ?>
					<?php case 2: ?>
						<div>
							<a href="index.php" class="white">更多拼团</a>
	                        <a href="groupon.php?id=<?php echo $info['activityId'];?>">我要开团</a>
					   </div>
					<?php break; ?>
				<?php } ?>
 <?php }?>
 </section>



	
		
	  
	  <div class="content native-scroll">
	    <?php if($info['activityType'] != 5 ){?>
                 <section class="freeList proTipsNew-1">
                    <ul class="list-container">
                        <li><a href="<?php if($jumpProduct){ ?>groupon.php?id=<?php echo $grouponId;?><?php }else{ ?>javascript:;<?php } ?>">
                            <div class="img"><img src="<?php echo $info['productImage'];?>"></div>
                            <div class="info">
                               <div class="name"><?php echo $info['productName'];?></div>
                                <div class="price">
                                    <?php if($jumpProduct){ ?><div class="btn">商品详情</div><?php } ?>
                                    拼团价：<span class="price1">￥<?php echo $info['groupPrice'];?></span>
                                    <?php if($info['status'] ==1 && $info['isGroup'] ==1 && $info['isSellOut'] ==0){?>
                                    <div class="icon"><img src="images/groupJoin-3.png" /></div>
                                <?php }elseif($info['isSellOut'] ==1 && $info['status'] !=1){?>
						            <div class="icon"><img src="images/groupJoin-2.png" /></div>
                                <?php }elseif($info['isSellOut'] ==0 && $info['status'] ==2){?>
						            <div class="icon"><img src="images/groupJoin-4.png" /></div>
						        <?php }elseif($info['isSellOut'] ==0 && $info['isStart'] ==1 && $info['isGroup'] ==0){?>
						            <div class="icon"><img src="images/groupJoin-1.png" /></div>
                                <?php }?>
                                </div>
                            </div>
                        </a></li>
                    </ul>
                </section>

          <?php }else{?>
                
                 <section class="freeList proTipsNew-1">
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
                                    <?php if($info['status'] ==1 && $info['isGroup'] ==1 && $info['isSellOut'] ==0){?>
                                    <div class="icon"><img src="images/groupJoin-3.png" /></div>
                                <?php }elseif($info['isSellOut'] ==1 && $info['status'] !=1){?>
						            <div class="icon"><img src="images/groupJoin-2.png" /></div>
                                <?php }elseif($info['isSellOut'] ==0 && $info['status'] ==2){?>
						            <div class="icon"><img src="images/groupJoin-4.png" /></div>
						        <?php }elseif($info['isSellOut'] ==0 && $info['isStart'] ==0 && $info['isGroup'] ==0){?>
						            <div class="icon"><img src="images/groupJoin-1.png" /></div>
                                <?php }?>
                                </div>
                            </div>
                        </a></li>
                    </ul>
                </section>
           <?php }?>
                
                 <section class="proTipsNew-2">
                    <?php if($info['isSellOut'] ==1 ){?>
                    <h3 class="title1">组团失败，商品已售罄~</h3>
                    <?php }elseif($info['status'] ==2 && $info['isSellOut'] !=1){?>
                    <h3 class="title1">拼团期内未达到成团人数，系统会在1~2个工作日内，按原路自动退款至各位成员~</h3>
                    <?php }elseif($info['status'] ==0 && $info['isGroup'] ==1 ){?>
                    <h3 class="title1">还差<span class="themeColor"><?php echo $info['poorNum'];?></span>人，赶紧分享召集小伙伴组团啦~</h3>
                    <?php }elseif($info['status'] ==0 && $info['isGroup'] ==0 && $info['isSellOut'] !=1){?>
                    <h3 class="title1">您终于来了！还差<span class="themeColor"><?php echo $info['poorNum'];?></span>人，来参团吧！</h3>
                    <?php }elseif($info['isStart'] ==1  && $info['isGroup'] ==0 && $info['isSellOut'] ==0){?>
                    <h3 class="title1">您来晚了，已成团~</h3>
                   <?php }?>
                    <ul class="group">
                        <?php foreach ($info['groupUserList'] as $u){?>
                        <?php if($u['isHead'] ==1){?>
                        <li class="head"><img src="<?php echo $u['userImage'];?>"><span></span></li>
                        <?php }else{?>
                        <li><img src="<?php echo $u['userImage'];?>"></li>
                        <?php }}?>
                        <li class="more"><img src="images/more.png"></li>
                    </ul>
               
                </section>
                
                <?php if($info['status'] ==0 && $info['isSellOut'] ==0){?>
                 <section class="proTipsNew-6">
                    <div>
                                       剩余<div id="downTime" data-timer="<?php echo $info['remainSec'];?>"></div>结束
                    </div>
                </section>
                <?php }?>
                
                
                
                 <section class="proTips-3 proTipsNew-3">
                    <div class="btn">查看全部参团详情</div>
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
                <?php if($wxUser['subscribe'] !=0){?>
                <section class="proTipsNew-4">
                    <img src="images/code-follow.jpg" />
                </section>
                <?php }?>
                <section class="pro-like">
                    <h3 class="title1"><!--猜你喜欢--></h3>
                    <ul>
                        <?php foreach ($pList as $p){?>
                        <li>
                            <a class="img" href="groupon.php?id=<?php echo $info['activityId'];?>"><img src="<?php echo $p['productImage'];?>" /></a>
                            <a class="name" href="groupon.php?id=<?php echo $info['activityId'];?>"><?php echo $p['productName'];?></a>
                            <div class="price">
                                 <a href="javascript:;" class="collect<?php if($p['isCollect']==1){?> active<?php } ?>" data-collect="<?php echo ($p['isCollect']==1)?'1':'0';?>" data-actid="<?php echo $p['activityId'];?>" data-pid="<?php echo $p['productId'];?>"><!--收藏--></a>
                                ￥<span><?php echo $p['price'];?></span>
                            </div>
                        </li>
                        <?php }?>
                    </ul>
                </section>
                
                
    

               
            </div>
			
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

            
            $(document).on("pageInit", "#page-proTips", function(e, pageId, page) {
                //用户头像
                if($(".proTipsNew-2 .group li").length>10){
                    $(".proTipsNew-2 .group li").css("display","none");
                    for(var i=0; i<9; i++){
                        $(".proTipsNew-2 .group li").eq(i).css("display","inline-block");
                    }
                    $(".proTipsNew-2 .group li.more").css("display","inline-block");
                }else{
                    $(".proTipsNew-2 .group li").css("display","inline-block");
                    $(".proTipsNew-2 .group li.more").css("display","none");
                }
                $(".proTipsNew-2 .group li.more").on("click", function(){
                    $(".proTipsNew-2 .group li").css("display","inline-block");
                    $(".proTipsNew-2 .group li.more").css("display","none");
                });

                //查看全部参团详情
                $(".proTipsNew-3 .btn").on("click", function(){
                    if($(".proTipsNew-3").hasClass('active')){
                        $(".proTipsNew-3").removeClass('active');
                    }else{
                        $(".proTipsNew-3").addClass('active');
                    }
                });

                //规则
                $("#rule").on("click", function(){
                    $.popup(".popup-joinrule");
                    $(".popup-overlay").hide();
                });
            });




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
