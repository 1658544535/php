<?php
$curDir = dirname(__FILE__).'/';
$data = include_once($curDir.'data/dingyuehao_invite_code.php');
$receiveTotal = 0;
foreach($data as $v){
	!empty($v['openid']) && $receiveTotal++;
}
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>订阅号邀请码</title>
	</head>
	<body>
		<div>邀请码总数：<?php echo count($data);?></div>
		<div>已领取数量：<?php echo $receiveTotal;?></div>
	</body>
</html>
