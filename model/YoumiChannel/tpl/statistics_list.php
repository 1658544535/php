<!doctype html>
<html>
	<head>
		<title>Line Chart</title>
		<script src="<?php echo $this->nowModel ?>js/Chart.min.js"></script>
	</head>
	<body>
		<div style="width:60%; float:left; margin:30px;">
			<h3><?php echo date( 'Y-m' ) ?>当月记录</h3></br>
			<?php if ( $from == "statistics" ){ ?>
				<div>
					<dl style="float:right; border:1px dashed #ccc; padding:15px; background:#fcfcfc;">
						<dd style="color:rgb(99,175,60)">今日注册数</dd>
						<dd style="color:rgb(255,175,60)">安卓注册数</dd>
						<dd style="color:rgb(34,165,195)">苹果注册数</dd>
						<dd style="color:rgb(180,180,180)">正常注册数</dd>
					</dl>
				</div>
			<?php } ?>
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
				},
				{
					label: "安卓注册数",
					fillColor : "rgba(255,175,60,0.05)",
					strokeColor : "rgba(255,175,60,1)",
					pointColor : "rgba(255,175,60,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : <?php echo $num3 ?>
				},
				{
					label: "苹果注册数",
					fillColor : "rgba(34,165,195,0.05)",
					strokeColor : "rgba(34,165,195,1)",
					pointColor : "rgba(34,165,195,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : <?php echo $num4 ?>
				},
				{
					label: "正常注册数",
					fillColor : "rgba(180,180,180,0.05)",
					strokeColor : "rgba(180,180,180,0.8)",
					pointColor : "rgba(180,180,180,0.8)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(180,180,180,1)",
					data : <?php echo $num5 ?>
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
