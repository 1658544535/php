<?php
define('HN1', true);
require_once('./global.php');
$linkid  = CheckDatas( 'id', '' );
$couponInfo = apiData('aCouponInfoApi.do',array('linkId'=>$linkid));
$couponInfo = $couponInfo['result'];

?>
<!DOCTYPE html>
	<html>
		<head>
			<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
				<script type="text/javascript" src="/js/wxshare.js"></script>
				<script type="text/javascript">
				    <?php if($couponInfo['isProduct'] ==1){?>
						var imgUrl = "<?php echo $couponInfo['productImage'];?>";
						var link   = "<?php echo $site;?>coupon_action.php?linkid=<?php echo $linkid;?>&aid=<?php echo $couponInfo['activityId'] ;?>";
						var title  = "购买立减<?php echo $couponInfo['m'];?>元";
						var desc   = "<?php echo $couponInfo['productSketch'];?>";
					<?php }else{?>
						var imgUrl = "<?php echo $site;?>images/wxLOGO.png";
						var link   = "<?php echo $site;?>coupon_action.php?linkid=<?php echo $linkid;?>";
						var title  = "全场商品购买立减<?php echo $couponInfo['m'];?>元";
						var desc   = "全场商品大降价";
					<?php }?>
				wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
			</script>
		</head>
	</html>
