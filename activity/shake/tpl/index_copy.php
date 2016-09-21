<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<script src="<?php echo $site; ?>js/jquery.min.js"></script>
	<script>

		var SHAKE_THRESHOLD = 800;
		var last_update = 0;
        var x = y = z = last_x = last_y = last_z = 0;

		function shake_option()
		{
			if (window.DeviceMotionEvent)
			 {
	        	window.addEventListener('devicemotion', deviceMotionHandler, false);
	    	 }
	    	 else
	    	 {
	         	alert('你的手机太差了，扔掉买个新的吧。');
	    	 }
		}


		function deviceMotionHandler(eventData)
		{
			var acceleration = eventData.accelerationIncludingGravity;
			var curTime = new Date().getTime();

			if ((curTime - last_update) > 200)
			{
				var diffTime = curTime - last_update;
				last_update = curTime;
				x = acceleration.x;
				y = acceleration.y;
				z = acceleration.z;
				var speed = Math.abs(x + y + z - last_x - last_y - last_z) / diffTime * 10000;
				var status = document.getElementById("status");

				if ( speed > SHAKE_THRESHOLD )
				{
					location.href = "<?php echo $site ?>index.php?act=get_result";
				}
				last_x = x;
				last_y = y;
				last_z = z;
			}
		}

		function loadMsg()
		{
			$.ajax({
				url:'<?php echo $site; ?>api.php?act=get_activity_info',
				type:'POST',
				dataType: 'json',
				success:function(data){
					$('#page1>h1').text( '活动：' + data.data.title );
					$('#page1>h3').text( "有效期：" + data.data.starttime + " - " + data.data.endtime );
					if ( data.data.enable == 0 )
					{
						$('#start_game').hide();
						$('#page1>h3').text( "该活动已结束" );
					}
				},
				error:function(){
					alert('请求超时，请重新添加');
				}
			})
		}

		function get_result()
		{
			$.ajax({
				url:'<?php echo $site; ?>api.php?act=get_activity_result',
				type:'POST',
				dataType: 'json',
				success:function(data){
					if ( data.code > 0 )
					{
						$('#page1').hide();
						$('#page2').show();
						$('#page2>h1').text("您获得了：" + data.data.name);
						$('#page2>h3').text("奖品介绍：" + data.data.introduce);
						$('#page2>img').attr('src','<?php echo $IMAGE_URL;?>' + data.data.image);
					}
					else
					{
						alert( data.msg );
					}
				},
				error:function(){
					alert('请求超时，请重新添加');
				}

			})
		}

		$(function(){
			loadMsg();
			shake_option();
			$('#page2').hide();

			$('#start_game').on('click',function(){
				$.ajax({
					url:'<?php echo $site; ?>api.php?act=get_activity_result',
					type:'POST',
					dataType: 'json',
					success:function(data){
						if ( data.code > 0 )
						{
							$('#page1').hide();
							$('#page2').show();
							$('#page2>h1').text("您获得了：" + data.data.name);
							$('#page2>h3').text("奖品介绍：" + data.data.introduce);
							$('#page2>img').attr('src','<?php echo $IMAGE_URL;?>' + data.data.image);
						}
						else
						{
							alert( data.msg );
						}
					},
					error:function(){
						alert('请求超时，请重新添加');
					}

				})
			})
		})



	</script>
</head>
<body>
	<a href="javascript:void(0)" id="start_game" >点击进行抽奖</a>

	<div id="page1" >
		<h1></h1>
		<h3></h3>
	</div>

	<div id="page2" >
		<h1></h1>
		<h3></h3>
		<img src="" width="200" />
	</div>
</body>
</html>