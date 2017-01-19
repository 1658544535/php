<?php
set_time_limit(0);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$vcode = $_POST['vcode'];
	$vcode = explode("\r\n", $vcode);
	$arr = array();
	foreach($vcode as $v){
		if($v != ''){
			$arr[$v.''] = array('vcode'=>$v);
		}
	}

	$dataFile = dirname(__FILE__).'/data/dingyuehao_invite_code.php';
	$data = include($dataFile);
	$keys = array_keys($data);
	$i = 0;
	$new = array();
	$exist = array();
	foreach($arr as $k => $v){
		if(in_array($v['vcode'], $keys)){
			$exist[] = $v['vcode'];
		}else{
			$data[$k] = $v;
			$i++;
		}
	}
	if($i){
		file_put_contents($dataFile, "<?php\r\nreturn ".var_export($data, true).";\r\n?>");
	}
	echo '增加的邀请码数量：'.$i.'<br />';
	if(!empty($exist)){
		echo '<br />以下邀请码在添加之前已经存在：共'.count($exist).'个<br />';
		foreach($exist as $v){
			echo '<div>'.$v.'</div>';
		}
	}
	exit;
}
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="Author" content="">
		<meta name="Keywords" content="">
		<meta name="Description" content="">
		<title>添加邀请码</title>
	</head>
	<body>
		<div>输入邀请码，一行一个</div>
		<form action="" method="post">
			<textarea name="vcode" rows="50" cols="20"></textarea>
			<input type="submit" name="btn" value="提交" />
		</form>
	</body>
</html>