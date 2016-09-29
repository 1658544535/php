<?php
/*
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
                        ￥<span class="nowPrice"><?php echo $info['producrtPrice'];?></span>
                        <span class="oldPrice">￥<?php echo $info['alonePrice'];?></span>
                    </div>
                    <div class="name"><?php echo $info['productName'];?></div>
                    <div class="txt"><?php echo $info['title'];?></div>
                    <div class="tips"><img src="images/deta-tips.png" /></div>
                </section>
				
				<?php if(!empty($info['waitGroupList'])){ ?>
                <section class="deta-group">
                    <h3 class="title1">欢迎您直接参与其他小伙伴发起的拼团</h3>
                    <ul class="list">
						<?php foreach($info['waitGroupList'] as $_active){ ?>
						<li>
                            <a class="btn" href="groupon_join.php?id=<?php echo $_active['groupRecId'];?>&pid=<?php echo $info['productId'];?>">参团&nbsp;&gt;</a>
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
						<a class="one" href="order_alone.php?id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>" id="btn-alone">
							 <p>￥<b><?php echo $info['alonePrice'];?></b></p>
							 <p>单独购买</p>
						</a>
						<?php if($info['isGroupFree']){ ?>
							<a class="more" href="order_free.php?id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>" id="btn-groupon">
								 <p>￥<b>0.00</b></p>
								 <p>0元开团</p>
							</a>
						<?php }else{ ?>
							<a class="more" href="order_groupon.php?id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>" id="btn-groupon">
								 <p>￥<b><?php echo $info['producrtPrice'];?></b></p>
								 <p><?php echo $info['groupNum'];?>人团</p>
							</a>
						<?php } ?>
					<?php } ?>
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
			</script>
        </div>
    </div>
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</body>

</html>
*/
?>














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
                        ￥<span class="nowPrice"><?php echo $info['producrtPrice'];?></span>
                        <span class="oldPrice">￥<?php echo $info['alonePrice'];?></span>
                    </div>
                    <div class="name"><?php echo $info['productName'];?></div>
                    <div class="txt"><?php echo $info['title'];?></div>
                    <div class="tips"><img src="images/deta-tips.png" /></div>
                </section>

				<?php if(!empty($info['waitGroupList'])){ ?>
                <section class="deta-group">
                    <h3 class="title1">欢迎您直接参与其他小伙伴发起的拼团</h3>
                    <ul class="list">
						<?php foreach($info['waitGroupList'] as $_active){ ?>
						<li>
                            <a class="btn" href="groupon_join.php?id=<?php echo $_active['groupRecId'];?>&pid=<?php echo $info['productId'];?>">参团&nbsp;&gt;</a>
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
						<a class="one" href="order_alone.php?id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>" id="btn-alone">
							 <p>￥<b><?php echo $info['alonePrice'];?></b></p>
							 <p>单独购买</p>
						</a>
						<?php if($info['isGroupFree']){ ?>
							<a class="more" href="order_free.php?id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>" id="btn-groupon">
								 <p>￥<b>0.00</b></p>
								 <p>0元开团</p>
							</a>
						<?php }else{ ?>
							<a class="more" href="order_groupon.php?id=<?php echo $grouponId;?>&pid=<?php echo $info['productId'];?>" id="btn-groupon">
								 <p>￥<b><?php echo $info['producrtPrice'];?></b></p>
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
                $(".deta-footer .one, .deta-footer .more").on("click", function(){
                    $(".popup-sku").attr("data-type", $(this).attr("data-type"));
                    $.popup(".popup-sku");
                });

                //sku
                $(document).on('click','.sku_color',function(){
                    if($(this).hasClass("disable")) return false;
                    var val = $(this).attr('data-sid');
                    var now_val = $('#sku-color').attr("data-sid");
                    $('.sku_color').removeClass("active");

                    if ( now_val != val ){
                        $(this).addClass('active');
                        $('#sku-color').attr("data-sid", val);
                    }else{
                        $('#sku-color').attr("data-sid", '');
                        $('.popup-sku').attr('data-sku', '');
                        val = 0;
                    }
                    updatePrice();
                    var html = '';

                    $.ajax({
                        url: '/product_detail.php',
                        data:{
                            "pid": "<?php echo $objProductInfo->id;?>",
                            "sid": val,
                            "act": "sku_format"
                        },
                        dataType:'json',
                        success: function(result){

                            if ( result.code < 1 ){
                                toast(result.msg);
                            }else{
                                $.each(result.data,function(k,v){
                                    if ( v.has == 1 ){
                                        if ( $('#sku-format').attr("data-sid") == v.Id ){
                                            html +=     "<a class='sku_format active' data-sid='"+ v.Id +"'>" + v.value + "</a>";
                                        }else{
                                            html +=     "<a class='sku_format' data-sid='"+ v.Id +"' >" + v.value + "</a>";
                                        }
                                    }else{
                                        html +=     "<a class='disable'>" + v.value + "</a>";
                                    }
                                })

                                $('#sku-format .list').html(html);
                            }
                        }
                    })
                })

                $(document).on('click','.sku_format',function(){
                    if($(this).hasClass("disable")) return false;
                    var val = $(this).attr('data-sid');
                    var now_val = $('#sku-format').attr("data-sid");
                    $('.sku_format').removeClass("active");

                    if ( now_val != val ){
                        $(this).addClass('active');
                        $('#sku-format').attr("data-sid", val);
                    }else{
                        $('#sku-format').attr("data-sid", '');
                        $('.popup-sku').attr('data-sku', '');
                        val = 0;
                    }
                    updatePrice();
                    var html = '';

                    $.ajax({
                        url: '/product_detail.php',
                        data: {
                            "pid": "<?php echo $objProductInfo->id;?>",
                            "sid": val,
                            "act": "sku_color",
                            "acid": "<?php echo $activeId;?>"
                        },
                        dataType:'json',
                        success: function(result){
                            if ( result.code < 1 ){
                                toast(result.msg);
                            }
                            else{
                                $.each(result.data,function(k,v){
                                    if ( v.has == 1 ){
                                        if ( $('#sku-color').attr("data-sid") == v.Id ){
                                            html +=     "<a class='sku_color active' data-sid='"+ v.Id +"'>" + v.value + "</a>";
                                        }else{
                                            html +=     "<a class='sku_color' data-sid='"+ v.Id +"' >" + v.value + "</a>";
                                        }
                                    }else{
                                        html +=     "<a class='disable'>" + v.value + "</a>";
                                    }
                                })

                                $('#sku-color .list').html(html);
                            }
                        }
                    })
                })

                //数量
                $(".quantity .minus").on("click", function(){
                    var num = parseInt($(this).next().val());
                    if(num>1){
                        $(this).next().val(--num);
                    }else{
                        return false;
                    }
                });
                $(".quantity .plus").on("click", function(){
                    var num = parseInt($(this).prev().val());
                    $(this).prev().val(++num)
                });

                //购买
                $("#sku").on("click", function(){
                    var info = {
                        id          : "<?php echo $objProductInfo->id;?>",
                        type        : $(".popup-sku").attr("data-type"),
                        sku_id      : $(".popup-sku").attr("data-sku")
                    };

                    $.ajax({
                        url:'',
                        data:info,
                        type:'POST',
                        dataType: 'json',
                        error: function(){
                            toast('请求超时，请重新添加');
                        },
                        success: function(result){
                            if( result.code < 1){
                                toast( result.msg );
                            }
                            else{
                                
                            }
                        }
                    });
                });

                function updatePrice(){
                    var skuColorId = $("#sku-color").attr("data-sid");
                    var skuFormatId = $("#sku-format").attr("data-sid");
                    var url = "/product_detail.php";
                    var data = {"act":"price","pid":"<?php echo $objProductInfo->id;?>","scid":skuColorId,"sfid":skuFormatId};
                    $.get(url, data, function(r){
                        if(r.code > 0){
                            $("#sku-price").text(r.data.price);
                            $('.popup-sku').attr('data-sku', r.data.skuid);

                            var chooseTxt = '';
                            if($(".sku_box a#choose").length<=0){
                                chooseTxt = '请选择颜色和套餐类型';
                            }else{
                                $(".sku_box a.active").each(function(index, el) {
                                    var txt = $(el).html();
                                    txt = '“' + txt + '”';
                                    chooseTxt += txt;
                                });
                                chooseTxt = "已选择" + chooseTxt;
                            }
                            
                            $("#sku-choose").html(chooseTxt);
                        }
                    }, "json");
                    
                }
            });
        </script>
<!--
        <div class="popup popup-sku" style="display:none">
            <div>
                <a href="#" class="close-popup"></a>
                <div class="info">
                    <div class="img"><img src="" /></div>
                    <div class="main">
                        <div class="name"><?php echo $info['products']['productName'];?></div>
                        <div class="price">￥<span id="sku-price">49.9</span></div>
                        <div class="skuTxt" id="sku-choose">请选择颜色和套餐类型</div>
                    </div>
                </div>
                <div class="sku-item" id="sku-color">
                    <h4 class="title1">颜色</h4>
                    <div class="list">
                        <a href="javascript:;" class="sku_color" data-sid="c1">红色</a>
                        <a href="javascript:;" class="sku_color" data-sid="c2">红色</a>
                        <a href="javascript:;" class="sku_color" data-sid="c3">红色</a>
                    </div>
                </div>
                <div class="sku-item" id="sku-format">
                    <h4 class="title1">颜色</h4>
                    <div class="list">
                        <a href="javascript:;" class="sku_format" data-sid="s1">啥啥</a>
                        <a href="javascript:;" class="sku_format" data-sid="s2">啥啥</a>
                        <a href="javascript:;" class="sku_format" data-sid="s3">啥啥</a>
                    </div>
                </div>
                <div class="sku-number">
                    <span class="label">购买数量</span>
                    <div class="quantity">
                        <span class="minus">-</span>
                        <input type="text" value="1" />
                        <span class="plus">+</span>
                    </div>
                </div>
                <a id="buy" class="go">确定</a>
            </div>
        </div>
-->
    </div>
</body>

</html>








