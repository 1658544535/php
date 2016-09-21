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
            $.get("ajaxtpl/ajax_product_new.php?category_id=<?php echo $type;?>&key=<?php echo $key;?>&pid=<?php echo $types;?>&is_new=<?php echo $is_new;?>&sell=<?php echo $sell;?>&is_introduce=<?php echo $is_introduce;?>&page="+page,
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
	<div id="header">
		<!--<a href="javascript:window.history.back(-1);" class="back"></a>-->
		<div id="text">今日新品</div>
	</div>

	<div class="product_block_list">
	<?php if(is_array($productList)) {?>
        <ul>
			<?php foreach($productList as $product){ ?>
	        	<a href="product_detail?product_id=<?php echo $product->id;?>">
					<li>
						<!--
						<div  style="width:154px;height:154px;overflow:hidden;">
							<img src="<?php echo $site_image?>/product/small/<?php echo $product->image;?>" alt="" width="154px" height="154px" class="product_02-Pic-color02"/>
						</div>
						-->
						<div>
							<img src="<?php echo $site_image?>/product/small/<?php echo $product->image;?>" alt="" class="product_02-Pic-color02"/>
						</div>

						<div class="product_02-Pic-txt">
							<span style="font-size:14px;color:#404040;">
							<?php
								$v=&$product->product_name;  //以$v代表‘长描述’
								mb_internal_encoding('utf8');//以utf8编码的页面为例
								echo (mb_strlen($v)>8) ? mb_substr($v,0,8).'...' : $v;
							?>
							</span>
							<?php if( $user != null && $user_type == 3 ){ ?>
								<p class="product_02-Pic-txt02">￥<?php echo $product->distribution_price;?></p>
							<?php } ?>
						</div>
					</li>
				</a>
			<?php } ?>
			<div class='clear'></div>
        </ul>
    <?php }else{?>
  				<p style="text-align:center;line-height:50px;font-size:12px;color:#df434e">今日暂无新品</p>
    <?php }?>
    </div>

	<?php include "footer_web.php"; ?>
	</br>
	</br>
	</br>
	<?php include "footer_menu_web_tmp.php"; ?>


</body>
</html>
