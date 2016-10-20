<?php
define('HN1', true);
require_once('./global.php');
?>
<!DOCTYPE html>
<html>

<head>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="/js/wxshare.js"></script>
	<script type="text/javascript">
	var imgUrl = "http://pinwx.taozhuma.com/images/wxLOGO.png";
	var link  =  "http://pinwx.taozhuma.com/free.php?id=<?php echo $_GET['id'];?>";
	var title = "我在拼得好发现海量免费玩具，仅剩<?php echo $_GET['n'];?>份，点击马上领取！";
	var desc  = "就要这么壕|好货免费，玩具任领。";
	wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
</script>
</head>
</html>
