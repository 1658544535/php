<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
<!--IOS中Safari允许全屏浏览-->
<meta content="yes" name="apple-mobile-web-app-capable">
<!--IOS中Safari顶端状态条样式-->
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<title>web</title>
<style>
html,body{margin:0 auto;padding:0;font-family:Helvetica;font-size:12px;background:#eeefef;}
a,input{-webkit-tap-highlight-color:rgba(0,0,0,0);text-decoration:none;}
input{-webkit-appearance:none;border-radius:0;}

#header{position:relative;background:#fff;width:100%;height:40px;line-height:40px;border-bottom:1px solid #ddd;text-align:center}
.header_back{position:absolute;left:0;top:0;width:40px;height:40px;background:url(../images/header_btn.png) no-repeat center -40px;background-size:40px auto;z-index:3;}
.header_title{margin:0 40px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;font-size:14px;color:#333;}

.banner,.banner img,.title,.title img{display:block;width:100%;}
.list_num3{margin-bottom:9px;padding:10px 5px 0;background:#fff;overflow:hidden;}
.list_num2{margin:0 5px;overflow:hidden;}
.list_num3 ul{margin:0;padding:0;overflow:hidden;}
.list_num2 ul{padding:0;margin:0;overflow:hidden;margin:0 0 -6px;}
.list_num3 li{float:left;width:33.3333%;list-style:none;box-sizing:border-box;padding:0 5px;}
.pro_info{display:block;padding-bottom:6px;background:#fff;color:#333;font-size:12px;text-decoration:none;}
.pro_info p{height:32px;line-height:16px;margin:16px 14px 0 12px;padding:0;overflow : hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;}
.list_num3 .pro_info p{margin:8px 0 0px 0;}
.pro_info p.tm{background:url(images/active_tm.png) no-repeat left 1px;background-size:35px auto;text-indent:41px;}
.pro_price{padding:2px 0 10px;background:#fff;overflow:hidden;}
.list_num3 .pro_price{padding-left:0;}
.new_price{display:inline-block;vertical-align:bottom;padding-right:2px;color:#e73c7b;font-size:18px;font-weight:bold;line-height:20px;}
.list_num3 li .new_price{font-weight:normal;font-size:17px;}
.old_price{display:inline-block;vertical-align:bottom;color:#969696;font-size:10px;text-decoration:line-through;}
.pro_price font{float:right;background:#e73c7b;color:#fff;border-radius:10px;padding:0 8px;text-decoration:none;line-height:20px;}
.price_tips{display:inline-block;vertical-align:bottom;border:1px solid #e73c7b;color:#e73c7b;font-size:10px;border-radius:3px;padding:0 10px;text-decoration:none;line-height:20px;}

.list_num2 li{float:left;width:50%;list-style:none;box-sizing:border-box;padding:0 3px 6px;overflow:hidden;}
.list_num2 li .pro_info p{font-size:14px;line-height:20px;height:40px;}
.list_num2 li .new_price{font-size:20px;}
.list_num2 li .pro_price{padding-top:6px;}
.list_num2 li .pro_price font{float:none;display:block;margin:7px 0 0;padding:4px 0;border-radius:4px;font-size:13px;background:#e73c7b;color:#fff;text-align:center;}

.pro_info_img{position:relative;padding-bottom:100%;overflow:hidden;}
.pro_info_img img{position:absolute;width:100%;}

@media screen and (min-width:414px){
	html{font-size:13px;}
	.pro_info p{font-size:13px;line-height:20px;height:40px;}
	.list_num2 li .pro_info p{font-size:16px;line-height:21px;height:42px;}
	.pro_info p.tm{background-size:40px auto;text-indent:46px;}
	.new_price{font-size:22px;}
	.list_num3 li .new_price{font-weight:normal;font-size:18px;}
	.old_price{font-size:14px;}
	.pro_price font{font-size:13px;}
	.list_num2 li .pro_price font{font-size:14px;font-weight:bold;}
}
@media screen and (max-width:350px){
    .list_num3 li .new_price{margin-left:-3px;font-size:14px;}
    .list_num3 li .pro_price font{font-size:12px;padding:0 5px;}
    .list_num2 li .pro_info p{margin:10px 10px 0 10px;}
    .list_num2 li .pro_price{padding-top:0;}
}
</style>
</head>

<body>
    <div id="header">
        <a href="javascript:history.back(-1);" class="header_back"></a>
        <p class="header_title">web</p>
    </div>

    <div class="banner">
        <img src="<?php echo $site_image; ?>notice/<?php echo $objActivityTimeInfo->banner; ?>" alt="" />
    </div>

    <div class="title">
        <img src="<?php echo $site_image; ?>notice/<?php echo $objActivityTimeInfo->titlePic; ?>" alt="" />
    </div>

	<?php if ( $objActivityTimeProductTop != NULL ){ ?>
	    <div class="list_num3">
	        <ul>
	        	<?php foreach( $objActivityTimeProductTop as $ActivityTimeProductTop ){ ?>
		            <li>
		                <a href="/product_detail.php?type=3&pid=<?php echo $ActivityTimeProductTop->productId; ?>">
		                    <span class="pro_info" href="/product_detail.php?type=3&pid=<?php echo $ActivityTimeProductTop->productId; ?>">
		                        <div class="pro_info_img"><img src="<?php echo $site_image . 'product/small/' . $ActivityTimeProductTop->image; ?>" /></div>
		                        <p><?php echo $ActivityTimeProductTop->productName; ?></p>
		                    </span>
		                    <div class="pro_price">
		                        <span class="new_price">￥<?php echo sprintf('%.1f',$ActivityTimeProductTop->activePrice); ?></span>
		                        <font>抢购</font>
		                    </div>
		                </a>
		            </li>
	            <?php } ?>
	        </ul>
	    </div>
    <?php } ?>

	<?php if ( isset($ActivityTimeProductList[1]) ){ ?>
	    <div class="list_num2">
	        <ul>
	        	<?php foreach( $ActivityTimeProductList[1]['Info'] as $ProductInfo ){ ?>
		            <li>
		                 <a href="/product_detail.php?type=3&pid=<?php echo $ProductInfo->productId; ?>">
		                    <span class="pro_info">
		                        <div class="pro_info_img"><img src="<?php echo $site_image . 'product/small/' . $ProductInfo->image; ?>" /></div>
		                        <p class="tm"><?php echo $ProductInfo->productName; ?></p>
		                    </span>
		                    <div class="pro_price">
		                        <span class="new_price">￥<?php echo $ProductInfo->activePrice; ?></span>
		                        <span class="old_price">￥<?php echo $ProductInfo->sellPrice; ?></span>
		                        <font>立即抢购</font>
		                    </div>
		                </a>
		            </li>
	             <?php } ?>
	        </ul>
	    </div>
    <?php } ?>

	<?php if ( isset($ActivityTimeProductList[2]) ){ ?>
	    <div class="title">
	        <img src="<?php echo $site_image; ?>notice/<?php echo $ActivityTimeProductList[2]['img']; ?>" alt="" />
	    </div>

	    <div class="list_num2">
	        <ul>
	            <?php foreach( $ActivityTimeProductList[2]['Info'] as $ProductInfo ){ ?>
		            <li>
		                 <a href="/product_detail.php?type=3&pid=<?php echo $ProductInfo->productId; ?>">
		                    <span class="pro_info">
		                        <div class="pro_info_img"><img src="<?php echo $site_image . 'product/small/' . $ProductInfo->image; ?>" /></div>
		                        <p class="tm"><?php echo $ProductInfo->productName; ?></p>
		                    </span>
		                    <div class="pro_price">
		                        <span class="new_price">￥<?php echo $ProductInfo->activePrice; ?></span>
		                        <span class="old_price">￥<?php echo $ProductInfo->sellPrice; ?></span>
		                        <font>立即抢购</font>
		                    </div>
		                </a>
		            </li>
	             <?php } ?>
	        </ul>
	    </div>
    <?php } ?>

    <?php if ( isset($ActivityTimeProductList[3]) ){ ?>
	    <div class="title">
	        <img src="<?php echo $site_image; ?>notice/<?php echo $ActivityTimeProductList[2]['img']; ?>" alt="" />
	    </div>

	    <div class="list_num2">
	        <ul>
	            <?php foreach( $ActivityTimeProductList[3]['Info'] as $ProductInfo ){ ?>
		            <li>
		                 <a href="/product_detail.php?type=3&pid=<?php echo $ProductInfo->productId; ?>">
		                    <span class="pro_info">
		                        <div class="pro_info_img"><img src="<?php echo $site_image . 'product/small/' . $ProductInfo->image; ?>" /></div>
		                        <p class="tm"><?php echo $ProductInfo->productName; ?></p>
		                    </span>
		                    <div class="pro_price">
		                        <span class="new_price">￥<?php echo $ProductInfo->activePrice; ?></span>
		                        <span class="old_price">￥<?php echo $ProductInfo->sellPrice; ?></span>
		                        <font>立即抢购</font>
		                    </div>
		                </a>
		            </li>
	             <?php } ?>
	        </ul>
	    </div>
    <?php } ?>


</body>
</html>
