<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="css/index3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<link href="css/all.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.faragoImageAccordion.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo WEBLINK;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
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
	<div class="shop-hose">
    	<div class="dpj_list clearfix">
        	<ul class="dpj_ul clearfix">
            	<li><a href="shoplist?type=2"><img src="images/image/zj_yy_pic.png" width="149" height="56"/></a></li>
                <li class="pic_right"><a href="shoplist?type=3"><img src="images/image/gjj_pic.png"  width="149" height="56" /></a></li>
                <li><a href="shoplist?type=1"><img src="images/image/ykdd_pic.png"  width="149" height="53" /></a></li>
                <li class="pic_right"><a href="shoplist?type=4"><img src="images/image/tcwj_pic.png"  width="149" height="53"/></a></li>
                <li><a href="shoplist?type=5"><img src="images/image/yzwj_pic.png"  width="149" height="56"/></a></li>
                <li class="pic_right"><a href="shoplist?type=6"><img src="images/image/qt_pic.png"  width="149" height="56"/></a></li>

            </ul>
            <div class="dpj_shop_list clearfix">
            	<ul>
<?php foreach($shopList as $shop){
	$main_category=$db->get_var("select name from sys_dict where type ='main_category'and value='".$shop->main_category."' ");
    $productList=$db->get_results("select * from product where user_id ='".$shop->user_id."'and is_new='1' order by sorting desc ");

	 ?>

                <li>
                    <div class="dpj_shop_pro clearfix">
                         <div><a href="shop_detail?id=<?php echo $shop->id;?>"></div>
                        <div><img src="<?php echo $site_image?>shop/<?php echo $shop->images;?>" width="147" height="110" /></div>
                        <div style="font-size:14px;color:#404040;">店铺名：<?php echo $shop->name;?></div>
                        <div style="font-size:14px;color:#404040;">主打：<?php echo $main_category;?></div>

                    </div>
                 </li>
                          <?php } ?>

            </div>
        </div>
    </div>
    <?php include "footer_menu_web_tmp.php"; ?>
<script>
$(".drop").hide();
$(".nav02 ul li").click(function () {
$(this).find(".drop").slideToggle(200);
});
</script>
</body>
</html>
