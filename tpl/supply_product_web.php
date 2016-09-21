<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="css/index3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="js/jquery.faragoImageAccordion.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
<script type="text/javascript">
$(function() {
	$("#imageAccordion").imageAccordion({
        imageSpeed: "fast",
        titleSpeed: "slow"
    });
    $("a.link_ajaxLoadIA").click(function() {
        var $this = $(this);
        var $ia = $("#imageAccordion");
        $ia.html("Loading...");
        $ia.load($this.attr("href") + "?abc=" + Math.random(), {
            cache: false
        },
        function() {
            $ia.imageAccordion({
                imageSpeed: "fast",
                titleSpeed: "slow"
            })
        });
        return false
    });
    var $trigger = $("#accordionMenu ul li.mainType");
    $trigger.hover(function() {
        $trigger.removeClass("hover");
        $("div.subList").hide();
        $(this).addClass("hover").find("div.subList").show()
    },
    function() {
        $trigger.removeClass("hover");
        $("div.subList").hide()
    });
    var loaded = false;
    var index = 0;
    var cmu = 2;
    var fmu = 1;
    var page = 1;
    function show() {
        var hght = $("#body").height();
        var top = $(window).scrollTop();
        if (!loaded && (parseInt(hght / cmu) * fmu < top) && <?php echo ($productList['PageCount'] - 1);?> > 0) {
            $("#progressIndicator").show();
            index++;
            cmu++;
            fmu++;
            page++;
            if (index >= <?php echo ($productList['PageCount'] - 1);?>) loaded = true;
            $.get("ajaxtpl/ajax_product3.php?category_id=<?php echo $type;?>&page="+page,
            function(data) {
                if (index == 1) $("#comments").html(data);
                else $("#comments").after(data);
                $("#progressIndicator").hide()
            })
        }
    };
    $(window).scroll(show);

    var time=$("#time").val();
	if(!time){
		time=='1';
	}
	$("#buynum11").html(time);
});

function buy_now(product_id){
	$.ajax({
		url:'cart.php?act=add&userid=<?php echo $userid;?>&product_id='+product_id,
		type:'POST',
		dataType: 'string',
		error: function(){
     		alert('请求超时，请重新添加');
    	},
    	success: function(result){
			var a = result.indexOf('<!DOCTYPE');
    		if(a > 0){
    			alert(result.substr(0,a));
    		}else{
    			var time=$("#time").val();
				if(!time){
					time=='1';
				}
    			time=Number(time)+Number(1);
    			$("#time").val(parseInt($("#time").val()) + 1);
            	$("#buynum11").html(time);
    		}
    	}
	});
}
function addFavor(product_id){
    $.ajax({
		url:'/member/favorites.php?act=add&userid=<?php echo $userid;?>&product_id='+product_id,
		type:'POST',
		dataType: 'string',
		error: function(){
     		alert('请求超时，请重新添加');
    	},
    	success: function(result){
			alert('收藏成功');
    	}
	});
}
</script>
</head>

<body>
<div class="list-nav">


	<a href="index" class="member-nav-L"></a>
   <a href="user" class="add-nav-L"
   <?php if($hot==1){echo "style=\"float:left;\"";}else{echo "style=\"float:right;\""; }?>
  ></a>
    <div class="member-nav-M"><?php if($hot==1){echo "今日推荐";}?></div>
</div>
<div style="background-color: #d0d0d0;padding: 1px 0 0px 0;text-align: center;">
	<div class="product_02">
        <ul>
<?php foreach($productList['DataSet'] as $product){ ?>
        	<li><div class="product_02-Pic"><a href="product_detail?product_id=<?php echo $product->id;?>">
        	<div  style="width:154px;height:154px;overflow:hidden;"><img src="product/small/<?php echo $product->image;?>" alt="" width="154px" height="154px" class="product_02-Pic-color02"/></div></a>
        	<div class="product_02-Pic-txt"><a href="product_detail?product_id=<?php echo $product->id;?>">
        		<span style="font-size:14px;color:#404040;"><?php echo mb_substr($product->product_name , 0 , 20 ,'utf-8');?></span>
        	</a></div></div></li>
<?php } ?>
        </ul>
    </div>
     <div id="comments"></div><br/>
     <div class="clear"></div>
	<div id="progressIndicator" style="width:320px;text-align: center; display: none;">
		<img width="85" height="85" src="images/ajax-loader-85.gif" alt=""> <span id="scrollStats" style="font-size: 70%; width: 80px; text-align: center; position: absolute; bottom: 25px; left: 2px;"></span>
	</div>
</div>
<div style="height: 60px;"/>
<div>
<?php include "footer_menu_web_tmp.php"; ?>
<script>
$(".drop").hide();
$(".nav02 ul li").click(function () {
$(this).find(".drop").slideToggle(200);
});
</script>
</body>
</html>
