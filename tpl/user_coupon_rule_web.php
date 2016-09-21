<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>

<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>

<script type="text/javascript">
function del(id){
	if(window.confirm('确定删除该地址记录？')){
		location.href='address_info.php?act=del&id[]='+id;
	}
}
</script>
</head>
<body style="background:#fff;">

	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title">使用规则</p>
	</div>

	<dl class="coupon_rule">
		<dt>什么是代金券？</dt>
		<dd>代金券是淘竹马提供给用户专享的优惠措施，下单时可直接抵扣相应的订单金额。</dd>

		<dt>代金券如何获得？</dt>
		<dd>淘竹马会员通过“买赠、活动参与、积分兑换”等形式可以获得相应的代金券，用于购买支付的减免。</dd>

		<dt>满返的代金券，会在什么时候送到我的账户？</dt>
		<dd>单笔交易完成支付60分钟后未取消订单，即刻发送至您的淘竹马账户。</dd>

		<dt>如何使用代金券？</dt>
		<dd>您可在订单结算页面选择支付方式时通过“可用现金券”选项使用一张符合条件的代金券，抵扣相应的金额。</dd>

		<dt>可以同时使用多张代金券吗？</dt>
		<dd>单笔订单只能使用一张符合条件的代金券。</dd>

		<dt>代金券可以反复使用吗？</dt>
		<dd>单张代金券只能使用一次，在订单支付成功后该代金券即刻失效。</dd>

		<dt>代金券使用有什么其他限制？</dt>
		<dd>代金券的使用时限和订单限额详见每张代金券上的文字描述。如提交订单使用代金券，未立即付款，代金券会失效。</dd>

		<dt>申请退款时代金券如何结算？</dt>
		<dd>如果单笔订单的金额因为其中的商品退款而导致不满足代金券的使用，需扣除代金券相应的金额。</dd>
	</dl>

	<?php include "footer_web.php";?>

</body>
</html>
