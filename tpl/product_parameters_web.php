<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<link href="css/index3.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
</head>

<body>

	<div id="header">
		<!--<a href="/product_detail?product_id=<?php echo $_GET['product_id']; ?>"class="back"></a>-->
		<div id="text">商品参数</div>
	</div>

	<div class="nr_warp">

		<dl class="favs_tabs">
			<a href="/product_description?type=desc&product_id=<?php echo $_GET['product_id']; ?>">
				<dd class="small" id="<?php echo ($_GET['type'] == 'desc' ) ? 'active_tab' : '' ?>">商品详情</dd>
			</a>
			<a href="/product_description?type=param&product_id=<?php echo $_GET['product_id']; ?>">
				<dd class="small" id="<?php echo ($_GET['type'] == 'param' ) ? 'active_tab' : '' ?>">商品参数</dd>
			</a>
			<a href="/comment_product?type=comment&product_id=<?php echo $_GET['product_id']; ?>">
				<dd class="small" id="<?php echo ($_GET['type'] == 'comment' ) ? 'active_tab' : '' ?>">商品评论</dd>
			</a>
			<div class="clear"></div>
		</dl>

		<div class="product_parameters">

			<ul>
				<!--
				<li>
					<label>产品名称</label>
					<p><?php echo $obj->product_name;?></p>
				</li>
				-->
	            <li>
					<label>产品货号</label>
					<p><?php echo $obj->product_num;?></p>
				</li>

				<li>
					<label>品牌</label>
					<p><?php echo $brand;?></p>
				</li>

				<li>
					<label>产地</label>
					<p><?php echo $obj->location;?></p>
				</li>

				<li>
					<label>是否电动</label>
					<p><?php echo ($obj->is_power == 1) ? '是' : '否';?></p>
				</li>

				<li>
					<label>包装方式</label>
					<p><?php echo $pack;?></p>
				</li>


				<li>
					<label>是否包邮</label>
					<p><?php echo ($obj->postage_type == 1) ? '是' : '否';?></p>
				</li>

				<li>
					<label>材质</label>
					<p><?php echo $texture;?></p>
				</li>

				<li>
					<label>适用年龄</label>
					<p><?php echo $age;?></p>
				</li>

					<li>
						<label>最低零售价</label>
						<p>￥<?php echo $obj->lowest_price;?></p>
					</li>

					<li>
						<label>建议零售价</label>
						<p>￥<?php echo $obj->selling_price;?></p>
					</li>

				<li>
					<label>重量</label>
					<p><?php echo $obj->weight;?>kg</p>
				</li>
			</ul>
		</div>
	</div>

	<?php include "footer_web.php"; ?>
	</br>
	</br>
	</br>
	</br>
	<?php include "footer_menu_web_tmp.php"; ?>

</body>
</html>
