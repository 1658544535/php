<?php
session_start();

//$mobile = isset($_GET['m']) ? trim($_GET['m']) : '';
$productId = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
$orderNo = isset($_GET['ono']) ? trim($_GET['ono']) : '';

$curUser = $_SESSION['userinfo'];
if(!empty($curUser)){
	$ctTel = $curUser->loginname;
	$ctNickname = $curUser->name;
	$ctAvatar = $curUser->image;
}

$comment = array();
$productId && $comment[] = '商品id：'.$productId;
$orderNo && $comment[] = '订单编号：'.$orderNo;
$ctComment = empty($comment) ? '' : implode('，', $comment);
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>拼得好客服</title>
		<script type='text/javascript'>
		(function(m, ei, q, i, a, j, s) {
			m[i] = m[i] || function() {
				(m[i].a = m[i].a || []).push(arguments)
			};
			j = ei.createElement(q),
				s = ei.getElementsByTagName(q)[0];
			j.async = true;
			j.charset = 'UTF-8';
			j.src = '//static.meiqia.com/dist/meiqia.js';
			s.parentNode.insertBefore(j, s);
		})(window, document, 'script', '_MEIQIA');
		_MEIQIA('entId', 36305);

		var customData = {};
		<?php if($ctTel){ ?>customData["tel"] = "<?php echo $ctTel;?>";<?php } ?>
		<?php if($ctNickname){ ?>customData["name"] = "<?php echo $ctNickname;?>";<?php } ?>
		<?php if($ctAvatar){ ?>customData["avatar"] = "<?php echo $ctAvatar;?>";<?php } ?>
		customData["comment"] = "<?php echo $ctComment;?>";

		// 传递顾客信息
		_MEIQIA('metadata', customData);

		// 初始化成功时的回调
		_MEIQIA('allSet', function(){
			_MEIQIA('showPanel');
		});
	</script>
	</head>
	<body>
		
	</body>
</html>
