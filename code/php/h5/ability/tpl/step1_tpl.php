<!doctype html>
<html lang="zh">
<head>
	<meta charset="utf-8">
	<!--IOS中Safari允许全屏浏览-->
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta content="email=no" name="format-detection" />
	<meta content="telephone=no" name="format-detection">
	<title>您的宝宝会是下一个“洪荒之力”吗？</title>
	<link rel="stylesheet" type="text/css" href="<?php echo __CURRENT_TPL_URL__;?>/js/swiper/swiper.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo __CURRENT_TPL_URL__;?>/css/style.css" />
	<script src="<?php echo __CURRENT_TPL_URL__;?>/js/flexible.js"></script>
	<?php include_once(CURRENT_TPL_DIR.'share.php'); ?>
</head>

<body>
    <div class="wrap">

    	<header class="test1-title">
			<i class="test1-title-num">1</i>
			<h1 class="test1-title-txt">选择宝宝年龄</h1>
		</header>

		<form id="step1Form" action="<?php echo __CURRENT_ROOT_URL__;?>/?act=1" method="post">
			<input id="age" type="hidden" name="age" />
			<section class="test1-slide">
				<div class="swiper-container gallery-top">
			        <div class="swiper-wrapper">
			            <div class="swiper-slide" style="background-image:url(<?php echo __CURRENT_TPL_URL__;?>/images/baby/0-3.png)"></div>
			            <div class="swiper-slide" style="background-image:url(<?php echo __CURRENT_TPL_URL__;?>/images/baby/3-6.png)"></div>
			            <div class="swiper-slide" style="background-image:url(<?php echo __CURRENT_TPL_URL__;?>/images/baby/6-9.png)"></div>
			            <div class="swiper-slide" style="background-image:url(<?php echo __CURRENT_TPL_URL__;?>/images/baby/9-12.png)"></div>
			            <div class="swiper-slide" style="background-image:url(<?php echo __CURRENT_TPL_URL__;?>/images/baby/13-15.png)"></div>
			            <div class="swiper-slide" style="background-image:url(<?php echo __CURRENT_TPL_URL__;?>/images/baby/16-18.png)"></div>
			            <div class="swiper-slide" style="background-image:url(<?php echo __CURRENT_TPL_URL__;?>/images/baby/18-21.png)"></div>
			            <div class="swiper-slide" style="background-image:url(<?php echo __CURRENT_TPL_URL__;?>/images/baby/22-24.png)"></div>
			            <div class="swiper-slide" style="background-image:url(<?php echo __CURRENT_TPL_URL__;?>/images/baby/25-27.png)"></div>
			            <div class="swiper-slide" style="background-image:url(<?php echo __CURRENT_TPL_URL__;?>/images/baby/28-30.png)"></div>
			            <div class="swiper-slide" style="background-image:url(<?php echo __CURRENT_TPL_URL__;?>/images/baby/31-33.png)"></div>
			            <div class="swiper-slide" style="background-image:url(<?php echo __CURRENT_TPL_URL__;?>/images/baby/34-36.png)"></div>
			        </div>
			    </div>
			    <div class="swiper-container gallery-thumbs">
			        <div class="swiper-wrapper">
			            <div attr-age="1" class="swiper-slide">0-3月</div>
			            <div attr-age="2" class="swiper-slide">4-6月</div>
			            <div attr-age="3" class="swiper-slide">7-9月</div>
			            <div attr-age="4" class="swiper-slide">10-12月</div>
			            <div attr-age="5" class="swiper-slide">13-15月</div>
			            <div attr-age="6" class="swiper-slide">16-18月</div>
			            <div attr-age="7" class="swiper-slide">19-21月</div>
			            <div attr-age="8" class="swiper-slide">22-24月</div>
			            <div attr-age="9" class="swiper-slide">25-27月</div>
			            <div attr-age="10" class="swiper-slide">28-30月</div>
			            <div attr-age="11" class="swiper-slide">31-33月</div>
			            <div attr-age="12" class="swiper-slide">34-36月</div>
			        </div>
			    </div>
			    <div class="gallery-btn">
			    	<div class="swiper-button-next"></div>
	        		<div class="swiper-button-prev"></div>
			    </div>
			</section>

			<a class="test1-next" onclick="$('#step1Form').submit();"></a>
		</form>

    </div>
	<script src="<?php echo __CURRENT_TPL_URL__;?>/js/jquery-2.1.4.min.js"></script>
	<script src="<?php echo __CURRENT_TPL_URL__;?>/js/swiper/swiper.min.js"></script>
	<script>
		$(function(){
			var initial = 5;			//初始显示第几个
			var galleryTop = new Swiper('.gallery-top', {
		        pagination: '.swiper-pagination',
		        effect: 'flip',
		        grabCursor: true,
		        nextButton: '.swiper-button-next',
		        prevButton: '.swiper-button-prev',
		        onSlideChangeStart: function(){
		        	var index = galleryTop.activeIndex;
		        	setSlide(index);
		        },
		        onTouchEnd: function(){
		        	var index = galleryTop.activeIndex;
		        	setSlide(index);
		        },
		        onSlideChangeEnd: function(){
		        	var index = galleryTop.activeIndex;
		        	var ageNum = $(".gallery-thumbs .swiper-slide").eq(index).attr("attr-age");
		        	$("#age").val(ageNum);
		        }
		    });
		    var galleryThumbs = new Swiper('.gallery-thumbs', {
		        spaceBetween: 10,
		        centeredSlides: true,
		        slidesPerView: 'auto',
		        touchRatio: 0.2,
		        slideToClickedSlide: true
		    });
		    galleryTop.params.control = galleryThumbs;
		    galleryThumbs.params.control = galleryTop;
		    galleryTop.slideTo(initial, 0, function(){
		    	var ageNum = $(".gallery-thumbs .swiper-slide").eq(initial).attr("attr-age");
		        $("#age").val(ageNum);
		    });
		});
	    function setSlide(index){
	    	var firstNum = index-2;
        	$(".gallery-thumbs .swiper-slide").removeClass("swiper-slide-first");
        	if(firstNum>=0){
        		$(".gallery-thumbs .swiper-slide").eq(firstNum).addClass("swiper-slide-first");
        	}
	    }
	</script>
	<?php include_once(CURRENT_TPL_DIR.'statistics.php'); ?>
</body>
</html>
