<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<meta content="telephone=no" name="format-detection" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" type="text/css" href="/js/iscroll/iscroll.css"/>
<link rel="stylesheet" href="css/swiper.min.css">
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script src="js/iscroll/iscroll.js" type="text/javascript"></script>
<script src="js/swiper.jquery.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
<script type="text/javascript">
    var myScroll;
    function loaded() {
        myScroll = new iScroll('wrapper', {
            snap: true,
            momentum: false,
            hScrollbar: false,
            onScrollEnd: function () {
				$('#indicator > li.active').removeAttr("class");
				$('#indicator > li:nth-child(' + (this.currPageX+1) + ')').addClass("active");
            }
        });

    }
    document.addEventListener('DOMContentLoaded', loaded, false);
</script>
</head>
<body class="keBody" style=" backgroud:#d0d0d0;">


<div class="index_warp">
	<div class="index_header">
		<a href="class.php" class="float_r h_class"></a>
	</div>

	<a name="top"></a>
	<!-- <div class="tabs" id="nav_warp">
		<div class="swiper-wrapper">
			<div class="swiper-slide active">上新</div>
			<?php foreach( $objNavigation as $_kc => $category ){ ?>
				<div class="swiper-slide<?php if($_kc+1==0){?> active<?php } ?>"><?php echo $category->name; ?></div>
			<?php } ?>
		</div>
	</div> -->

	<div id="tabs-container" class="swiper-container">
		<div class="swiper-wrapper">
			<div class="swiper-slide">
				<div class="content-slide">
					<?php  include_once('index_new.php') ?>
				</div>
			</div>

			<?php foreach( $activities as $key => $info ){ ?>
				<div class="swiper-slide">
					<div class="content-slide">
						<div class="scene_list">
							<ul>
								<?php if( isset($activities[$key]) ){ ?>
									<?php foreach($activities[$key] as $actiItem){ ?>
										<li><a href="/special_detail.php?aid=<?php echo $actiItem->activity_id;?>">
											<div class="scene_img"><img class="img-lazy" data-ori="<?php echo $site_image.'specialShow/'.$actiItem->banner;?>" /></div>
											<h3 class="scene_name">
												<?php echo ( $actiItem->discount > 0 ) ? $actiItem->discount . '折' : ''; ?>
												<?php echo $actiItem->title;?>
											</h3>
											<p class="scene_discount">
												<?php if( $actiItem->discount_type == 1 ){ ?>
														<i class="green">减</i>
												<?php }elseif( $actiItem->discount_type == 2 ){ ?>
														<i class="red">折</i>
												<?php } ?>
												<span><?php echo $actiItem->tip; ?></span>
											</p>
											<p class="scene_date"><?php echo '剩' . $actiItem->date_tip; ?></p>
										</a></li>
									<?php } ?>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			<?php } ?>

		</div>
	</div>
</div>


<?php include "footer_web.php"; ?>
<?php include "footer_menu_web_tmp.php"; ?>
<style type="text/css">
	#active-join{position:absolute; top:0; z-index:20000; width:100%; height:100%; display:none;}
	#active-join #active-mark{z-index:20001; width:100%; height:100%; background-color:rgba(51,51,51,0.5); position:absolute;}
	#active-join .active-img{z-index:20002; position:relative; margin-top:80px; text-align:center;}
	#active-join .active-img #active-close{z-index:20003;/*float:right; margin-right:5px;*/ width:6%; position:absolute;/* right:10px;*/ left:50%; margin-left:50px; top:50px;}
	#active-join .active-img a{display:block;}
	#active-join .active-img a img{width:80%;}
</style>
<div id="active-join">
	<div id="active-mark" onclick="hideActiveIn()"></div>
	<div class="active-img">
		<div id="active-close" onclick="hideActiveIn()"><img src="/images/close1.png" /></div>
		<a href="/page.php?type=first_order">
			<img src="/images/active/sdzx.png" />
		</a>
	</div>
</div>

<script type="text/javascript">
var screenW = $(document).width();
window.onload = function() {
	var mySwiperTab = new Swiper('#nav_warp',{
		freeMode : true,
		slidesPerView : 'auto'
	});

	var swiperMap = {};
	var tabsSwiper = new Swiper('#tabs-container',{
		speed:500,
		noSwiping:true,
//		lazyLoading:true,
//		lazyLoadingOnTransitionStart:true,
		onSlideChangeStart: function(swiper){
			$(".tabs .active").removeClass('active');
			$(".tabs .swiper-slide").eq(tabsSwiper.activeIndex).addClass('active');
			var preIndex = swiper.previousIndex;
			if(typeof(swiperMap[preIndex]) == "undefined") swiperMap[preIndex] = $(swiper.slides[preIndex]).height();
		},
		onSlideChangeEnd: function(swiper){
			var index = swiper.activeIndex;

			//导航在当前可视区域右边是位移
			var tabBarRightPos = screenW - mySwiperTab.translate;
			var tabBarLeftPos = screenW - Math.abs(screenW + mySwiperTab.translate);
			//滑动后的下一屏对应tab的位移
			var nextTab = $(".tabs .swiper-slide.active");
			if((tabBarRightPos < nextTab.position().left + nextTab.outerWidth()) || ((tabBarRightPos != tabBarLeftPos) && (tabBarLeftPos > nextTab.position().left))){
				mySwiperTab.slideTo(index);
			}
			location.href = "#top";
			if(typeof(swiperMap[index])=="undefined"){
				var slideImg = $(swiper.slides[index]).find("img.img-lazy");
				if(slideImg.length > 0){
					slideImg.each(function(){
						var _this = $(this);
						if(_this.attr("hadload") != "true") _this.attr("src", _this.attr("data-ori")).attr("hadload", "true");
						_this.bind("load", function(){
							swiperMap[index] = $(swiper.slides[index]).height();
						});
					});
				}else{
					swiperMap[index] = $(swiper.slides[index]).height();
				}
			}
			swiper.container.height(swiperMap[index]);
			$("#tabs-container").height($("#tabs-container .swiper-slide-active .content-slide").outerHeight(true))
		}
	});
	$("#tabs-container").height($("#tabs-container .swiper-slide-active .content-slide").outerHeight(true))
	$(".tabs .swiper-slide").on('touchstart mousedown',function(e){
		e.preventDefault();
		$(".tabs .active").removeClass('active');
		$(this).addClass('active');
		tabsSwiper.slideTo($(this).index());
	});

	<?php if(empty($curActiTime)){ ?>
		$("#active-subject").text("活动暂未开始");
	<?php }elseif($curActiTime > 0){ ?>
		$("#active-subject").text("<?php echo $curActiTime['subject'];?>");
		downcount(<?php echo $curActiTime;?>);
	<?php } ?>
}

var nextRTime = <?php echo $nextActiTime;?>;
function downcount(_diff){
	if(_diff > 0){
		showTime(_diff);
		setTimeout(function(){downcount(--_diff);}, 1000);
	}else if(_diff == 0){
		if(nextRTime == 0){
			$("#countdown").hide();
			$("#active-subject").text("活动暂未开始");
		}else{
			if(typeof(nextSK) != "undefined") $("#active-subject").text(nextSK.subject);
			downcount(nextRTime);
			nextRTime = 0;
		}
	}
}

function showTime(_diff){
	var _hour = parseInt(_diff / 3600);
	_diff = _diff % 3600;
	var _minute = parseInt(_diff / 60);
	var _second = _diff % 60;
	_hour = (_hour < 10) ? "0"+_hour : _hour;
	_minute = (_minute < 10) ? "0"+_minute : _minute;
	_second = (_second < 10) ? "0"+_second : _second;
	$("#countdown").html('<span class="cdtime">'+_hour+'</span> : <span class="cdtime">'+_minute+'</span> : <span class="cdtime">'+_second+'</span>').show();
}

function showActiveIn(){
	$("#active-join").css({"top":$("body").scrollTop()}).show();
	$("body").on("touchmove", function(evt){
		evt.preventDefault();
	}).css({"overflow-y":"hidden"});
}

function hideActiveIn(){
	$("#active-join").hide();
	$("body").off("touchmove").css({"overflow-y":"auto"});
}
</script>

</body>
</html>
