<!doctype html>
<html lang="zh">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
	<meta content="telephone=no" name="format-detection" />
	<title><?php echo $site_name;?></title>
	<style type="text/css">
	html,body{height:100%; margin:0; padding:0;}
	.iframeBox{-webkit-overflow-scrolling:touch;width:100%;height:100%;}
    #weiframe{width:100%;height:100%;}
	</style>
	<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
</head>

<body>
	<div class="iframeBox">
		<iframe id="weiframe" src="" frameborder="0" scrolling="<?php echo $apple ? 'no' : 'yes';?>"></iframe>
	</div>
	<script type="text/javascript">
	document.domain='taozhuma.com';
	var _domain = "<?php echo $site;?>";
	var frameUrl = "<?php echo $frameUrl;?>&_rand=<?php echo rand();?>";
	$(function(){
		$("#weiframe").attr("src", frameUrl);
	});
	var winWidth = $(window).width();
	$("#weiframe").width(winWidth).load(function(){
		// alert("iframe加载完毕");
		var _frame = $("#weiframe").contents();
		var _body = _frame.find("body");
		_frame.find("head").append('<base target="_parent" />');
		$("#weiframe").width(winWidth);
//		$(".iframeBox").height(_body.height());

		_body.find("a").each(function(){
			var _a = $(this);
			var _hrefJson = eval("("+_a.attr("href")+")");
			if(typeof(_hrefJson) == "object"){
				var _href;
				switch(_hrefJson.type){
					case "goods":
						_href = _domain+"product_detail?type=3&pid="+_hrefJson.goodsId+"&aid="+_hrefJson.activityId;
						break;
				}
				_a.attr({"href":_href});
			}
		});

		_body.find("#goodsList").find("li.goodDetail").each(function(e){
			e.preventDefault;
			var _this = $(this);
			var _href = _domain+"product_detail?type=3&pid="+_this.attr("data-goodid")+"&aid="+_this.attr("data-activityid");
			_this.on("click", function(){
				window.location.href = _href;
			});
		});
	});
	</script>
</body>
</html>