<!doctype html>
<html>
	<head>
		<title>Line Chart</title>
		<script src="<?php echo $this->nowModel ?>js/Chart.min.js"></script>
	</head>
	<body>
		<div style="width:60%; float:left; margin:30px;">
			<h3><?php echo date( 'Y-m' ) ?>当月记录</h3></br>
			<div>
				<canvas id="canvas" height="200" width="600"></canvas>
			</div>
		</div>


	<script>
		var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
		var lineChartData = {
			labels : <?php echo $day ?>,
			datasets : [
				{
					label: "今日注册数",
					fillColor : "rgba(99,175,60,0.05)",
					strokeColor : "rgba(99,175,60,1)",
					pointColor : "rgba(99,175,60,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : <?php echo $num ?>
				}
			]

		}

	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myLine = new Chart(ctx).Line(lineChartData, {
			responsive: true
		});
	}


	</script>
	</body>
</html>
