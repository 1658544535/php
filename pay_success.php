<?php
define('HN1', true);
require_once('./global.php');

$outTradeNo = trim($_GET['outno']);
apiData('queryPayStatus.do', array('outTradeNo'=>$outTradeNo,'payMethod'=>2));
unset($_SESSION['order']);
$state = intval($_GET['state']);
$referUrl = urldecode($_GET['url']);
($referUrl == '') && $referUrl = '/user_orders.php';
//$refUrl = '/user_orders.php';
redirect($referUrl, $state?'支付成功':'支付失败');
exit();
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $site_name;?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="css/sm.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="js/swiper/swiper.min.css">
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
	<script type="text/javascript">
//		history.pushState({}, "", "user_orders.php");
//		history.replaceState(null, '', "user.php");
	</script>
</head>

<body>
	<div style="text-align:center; width:100%; margin-top:30%;">
		<div style="font-size:120%; color:#00f">支付成功</div>
		<div>
			<a href="user_orders.php" style="color:#000; text-decoration:underline; margin-top:10px; display:block;">进入订单列表</a>
		</div>
	</div>
</body>
</html>