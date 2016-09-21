<a href="#wheel" class="wheel-button nw"><span></span></a>
<ul id="wheel" data-angle="[95,310]" class="wheel">
	<li class="item"><a href="javascript:;" class="wheel_top"></a></li>
	<li class="item"><a href="index.php" class="wheel_index"></a></li>
	<!-- <li class="item"><a href="scene.php" class="wheel_scene"></a></li> -->
	<li class="item"><a href="cart.php" class="wheel_cart"></a></li>
	<li class="item"><a href="user.php" class="wheel_user"></a></li>
</ul>
<script src="/js/lazy/jquery.lazyload.min.js" type="text/javascript"></script>
<script src="js/wheelMenu/jquery.wheelmenu.min.js"></script>
<script>
	$(function(){

		if($("img.lazyload")[0]){
			$("img.lazyload").lazyload();
		}

		$(".wheel-button").wheelmenu({
		  trigger: "click", // 触发事件，可以是: "click" 或者 "hover". 默认值: "click"
		  animation: "fly", // 动画效果，可以是: "fade" 或者 "fly". 默认值: "fade"
		  animationSpeed: "fast", // 动画速度，可以是: "instant", "fast", "medium", 或者 "slow". 默认值: "medium"
		  angle: "all", // 菜单的显示角度，可以是: "all", "N", "NE", "E", "SE", "S", "SW", "W", "NW", 或者数组 [0, 360]. 默认值: "all" or [0, 360]
		});

		$('.wheel_top').click(function(){
			$('html,body').animate({scrollTop: '0px'}, 800);
			$(".wheel-button").trigger("click");
		});

	})
</script>

