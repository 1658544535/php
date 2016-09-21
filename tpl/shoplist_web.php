<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="css/index3.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<link href="css/all.css" rel="stylesheet" type="text/css" />
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
        if (!loaded && (parseInt(hght / cmu) * fmu < top) && <?php echo ($shopList['DataSet'] - 1);?> > 0) {
            $("#progressIndicator").show();
            index++;
            cmu++;
            fmu++;
            page++;
            if (index >= <?php echo ($shopList['DataSet'] - 1);?>) loaded = true;
            $.get("ajaxtpl/ajax_product_new.php?category_id=<?php echo $type;?>&key=<?php echo $key;?>&page="+page,
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
<div class="list-nav"><a href="index" class="member-nav-L"></a><a href="user" class="member-nav-R2"></a></div>
	<div class="shop-class">
    	<ul>
        	<li>
        		<a href="shop?type=2"><img src="images/image/zj_yy_pic.png" width="158" height="59"/></a>
        	</li>
            <li class="pic_right">
            	<a href="shop?type=3"><img src="images/image/gjj_pic.png"  width="158" height="59" /></a>
            </li>
            <li>
            	<a href="shop?type=1"><img src="images/image/ykdd_pic.png"  width="158" height="59" /></a>
            </li>
            <li class="pic_right">
            	<a href="shop?type=4"><img src="images/image/tcwj_pic.png"  width="158" height="59"/></a>
            </li>
            <li>
            	<a href="shop?type=5"><img src="images/image/yzwj_pic.png"  width="158" height="59"/></a>
            </li>
            <li class="pic_right">
            	<a href="shop?type=6"><img src="images/image/qt_pic.png"  width="158" height="59"/></a>
            </li>
            <div class="clear"></div>
        </ul>
	</div>

    <div class="product_block_list">
        <ul>
	        <?php
				$i = 0;
				foreach($shopList['DataSet'] as $shop)
				{
					$main_category=$db->get_var("select name from sys_dict where type ='main_category'and value='".$shop->main_category."' ");
			    	$province=$db->get_var("select name from sys_area  where id = '".$shop->province."' ");
					$city=$db->get_var("select name from sys_area  where id = '".$shop->city."' ");
					$address=$province.$city;
			?>

	        	<a href="shop_detail?id=<?php echo $shop->id;?>">
					<li>
			        	<div>
			        		<img style="position:relative" src="<?php echo $site_image?>shop/<?php echo $shop->images;?>" alt="" width="154px" height="154px" class="product_02-Pic-color02"/>
			        	</div>
			        	<div class="product_02-Pic-txt">
				        	<span style="font-size:14px;color:#404040;text-align:center;"><?php echo mb_substr($shop->name , 0 , 20 ,'utf-8');?></span>
				            <p class="product_02-Pic-txt02">主营：<?php echo $main_category;?></p>
				            <span style="font-size:12px;color:#404040;">所在区域：<?php echo $address;?></span>
			        	</div>
			        </li>
				</a>
			<?php $i++; } ?>
			<div class="clear"></div>
        </ul>
    </div>

    <div id="comments"></div><br/>
     <div class="clear"></div>
	<div id="progressIndicator" style="width:320px;text-align: center; display: none;">
		<img width="85" height="85" src="images/ajax-loader-85.gif" alt="">
		<span id="scrollStats" style="font-size: 70%; width: 80px; text-align: center; position: absolute; bottom: 25px; left: 2px;"></span>
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
