<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>

<style>
	.accordion{ max-width:600px; }
	@media (min-width: 400px) {
		#accordion .link img{ width:40px; }
		#accordion .link span{ font-size:14px; }
	}

	@media (max-width: 400px) {
		#accordion .link img{ width:35px; }
		#accordion .link span{ font-size:12px; }
	}
	.submenu li{text-align:left;}
	.submenu a{margin-left:20px;}
	.accordion .link{padding-left:13px;}
	#accordion .link span{font-size:15px; margin-left:20px;}
	.search_history li>a{padding:0;color:#666;font-size:14px;margin:0;text-align:left;}
</style>

</head>

<body>

<div id="header">
	<form action="product" method="get" id="search">
		<input type="hidden" name="act" value="search" />
		<a href="<?php echo $return_url; ?>" class="header_back"></a>
		<div class="header_search">
			<div class="header_search_main" style="width:100%">
				<input type="search" name="key" placeholder="搜索商品" />
			</div>
		</div>
		<a href="javascript:;" class="header_search_txt header_txtBtn">搜索</a>
	</form>
</div>

<div class="search_history">
	<ul></ul>
	<a href="javascript:;">清除搜索记录</a>
</div>

<?php include "footer_web.php";?>


<script type="text/javascript" src="js/classToggle.js"></script>
<script>
$(".drop").hide();
$(".nav02 ul li").click(function () {
	$(this).find(".drop").slideToggle(200);
});

$(function(){
	$(".header_search input").trigger("focus");
	$(".header_search_close").fadeIn(200);
	$(".search_history").addClass("active");

	$(".header_search_txt").on("click",function(){
		$("#search").submit();
	})
	$(document).delegate(".search_history ul li","click",function(){
		var txt = $(this).html();
		$(".header_search_main input").val(txt);
	});

	//搜索历史
	writeHistory();
	$("#search").on("submit",function(){
		if(!localStorage.search_history){
			localStorage.search_history = "";
		}
		var txt = $(".header_search_main input").val();
		var history = localStorage.search_history.split("@#/");
		var ifAdd = true;
		for(var i = 0; i < history.length-1; i++){
			if(history[i] == txt){
				ifAdd = false;
			}
		}
		ifAdd ? localStorage.search_history += txt + "@#/" : "";
	});
	$(".search_history a").on("click",function(){
		localStorage.search_history = "";
		writeHistory();
	});
	function writeHistory(){
		var historyHtml = "";
		if(localStorage.search_history){
			var history = localStorage.search_history.split("@#/");
			for(var i = 0; i < history.length-1; i++){
				historyHtml += "<li><a href='/product?act=search&key="+ history[i] +"'>"+ history[i] +"</a></li>"
			}
			$(".search_history ul").html(historyHtml);
		}else{
			$(".search_history ul").html(historyHtml);
		}
	}
});

</script>
</body>
</html>
