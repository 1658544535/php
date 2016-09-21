<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>

<link href="/css/common.css" rel="stylesheet" type="text/css" />
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
        if (!loaded && (parseInt(hght / cmu) * fmu < top) && <?php echo ($shopList['PageCount'] - 1);?> > 0) {
            $("#progressIndicator").show();
            index++;
            cmu++;
            fmu++;
            page++;
            if (index >= <?php echo ($shopList['PageCount'] - 1);?>) loaded = true;
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


</script>

</head>

<body>
	<div id="header">
		<dl id="title_warp">
			<dd>
				<a href="/">
					<img src="/images/index/icon-back.png" />
				</a>
			</dd>
			<dd>品牌街</dd>
			<dd><!--<img src="/images/index/icon-back.png" />--></dd>
		</dl>
	</div>

	<div class="nr_warp">
		<div class="shop_class">
	    	<dl>
	    		<dd>
	            	<a href="shop" <?php if( ! isset($_GET['type'])){ echo "style='color:#df434e; border-bottom:2px solid #df434e;'"; } ?> >全部</a>
	            </dd>

	        	<dd>
	            	<a href="shop?type=1" <?php if( isset($_GET['type']) && $_GET['type']==1){ echo "style='color:#df434e; border-bottom:2px solid #df434e;'"; } ?> >遥控</a>
	            </dd>

	        	<dd>
	        		<a href="shop?type=2" <?php if( isset($_GET['type']) && $_GET['type']==2){ echo "style='color:#df434e; border-bottom:2px solid #df434e;'"; } ?> >早教</a>
	        	</dd>

	            <dd>
	            	<a href="shop?type=3" <?php if( isset($_GET['type']) && $_GET['type']==3){ echo "style='color:#df434e; border-bottom:2px solid #df434e;'"; } ?> >过家家</a>
	            </dd>

	            <dd>
	            	<a href="shop?type=4" <?php if( isset($_GET['type']) && $_GET['type']==4){ echo "style='color:#df434e; border-bottom:2px solid #df434e;'"; } ?> >童车</a>
	            </dd>

	            <dd>
	            	<a href="shop?type=5" <?php if( isset($_GET['type']) && $_GET['type']==5){ echo "style='color:#df434e; border-bottom:2px solid #df434e;'"; } ?> >益智</a>
	            </dd>

	            <dd>
	            	<a href="shop?type=6" <?php if( isset($_GET['type']) && $_GET['type']==6){ echo "style='color:#df434e; border-bottom:2px solid #df434e;'"; } ?> >其他</a>
	            </dd>
	            <div class="clear"></div>
	        </dl>
		</div>

	    <div class="product_block_warp">
	        <dl class="shop_warp">
		        <?php
					$i = 0;
					foreach($shopList as $shop)
					{
						$main_category = preg_split( '#:#', $shop->main_category );
						$main_category=$db->get_var("select name from sys_dict where type ='main_category' and value='".$main_category[1]."' ");
//				    	$province=$db->get_var("select name from sys_area  where id = '".$shop->province."' ");
//						$city=$db->get_var("select name from sys_area  where id = '".$shop->city."' ");
//						$address=$province . $city;
				?>

		        	<a href="shop_detail?id=<?php echo $shop->id;?>">
						<dd>
				        	<div class="p_img_warp">
				        		<img src="<?php echo $site_image?>shop/<?php echo $shop->images;?>" alt=""/>
				        	</div>
				        	<div class="p_desc_warp">
					            <p>主营：<?php echo $main_category;?></p>
					            <p>地址：<?php echo $shop->address;?></p>
					            <p><?php echo mb_substr($shop->name , 0 , 20 ,'utf-8');?></p>
				        	</div>
				        </dd>
					</a>
				<?php $i++; } ?>
				<div class="clear"></div>
	        </dl>
	    </div>

		<div id="comments"></div><br/>

		<div class="clear"></div>

		<div id="progressIndicator" style="width:320px;text-align: center; display: none;">
			<img width="85" height="85" src="images/ajax-loader-85.gif" alt="">
			<span id="scrollStats" style="font-size: 70%; width: 80px; text-align: center; position: absolute; bottom: 25px; left: 2px;"></span>
		</div>
	</div>

	<?php include "footer_web.php"; ?>
	</br>
	</br>
	</br>
	</br>
    <?php include "footer_menu_web_tmp.php"; ?>



<script>
$(".drop").hide();
$(".nav02 ul li").click(function () {
$(this).find(".drop").slideToggle(200);
});
</script>
</body>
</html>
