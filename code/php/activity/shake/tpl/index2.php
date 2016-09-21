<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<script src="<?php echo $site; ?>js/jquery.min.js"></script>
	<script>


		var SHAKE_THRESHOLD = 800;
		var last_update = 0;
        var x = y = z = last_x = last_y = last_z = 0;
        var isPartake = false;

		function shake_option()
		{
			if (window.DeviceMotionEvent)
			 {
	        	window.addEventListener('devicemotion', deviceMotionHandler, false);
	    	 }
	    	 else
	    	 {
	         	alert('是时候升级下您的手机了！');
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
		            	get_result();
		            	window.removeEventListener('devicemotion', deviceMotionHandler, false);
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
					else if ( data.code == '-103' )
					{
						$('#page1').hide();
						$('#page2').show();
						$('#page2>h1').text(data.data.name);
						$('#page2>h3').text(data.data.introduce);
						$('#page2>img').attr('src','<?php echo $site; ?>images/' + data.data.image);
					}
					else if ( data.code == '-102' )
					{
						location.href = '<?php echo $site?>index.php?act=share';
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
		})

	</script>



	<style>
		*{ padding:0; margin:0; }
		#bg { margin:0 auto; background:#000; margin:0 auto; max-width:600px; position:relative; }
		img{ display:block; max-width:100%;  }
		#horse{ position:absolute; top:34%; left:25%; width:100%; }
		#horse img{ display:block; max-width:58%; }



	</style>

	<link type="text/css" href="http://csshake.surge.sh/csshake.min.css">
	<link type="text/css" href="http://csshake.surge.sh/csshake-slow.min.css">


</head>
<body>

	<div id="bg">
		<img src='<?php echo $site ?>images/bg.png' />

		<div id="horse" class="preview-item shake shake-constant">
			<img src='<?php echo $site ?>images/horse.png' />
		</div>
	</div>



</body>
</html>