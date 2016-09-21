<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
<title>场景</title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<style>
.wrapper{position:relative;width:100%;height:100%;margin:0 auto;box-sizing:border-box;}
.top{padding-bottom:2%;background:#fff;}
.top img{width:100%;}
.top_price,.top_info{margin:2% 4% 0;font-size:14px;color:#666;}
.top_price{position:relative;padding:0 10px;border-left:4px solid #d2d4d3;}
.top_nowPrice{font-size:20px;color:#ce0549;}
.top_oldPrice{font-size:14px;color:#999;}
.top_oldPrice font{text-decoration:line-through;}
.top_price strong{position:absolute;right:0;top:5px;font-size:15px;color:#ce0549;border:2px solid #ce0549;border-radius:20px;padding:5px 20px;font-weight:normal;}
.top_info{margin-top:0;}
.top_info img{max-width:100%;height:auto;}
.list{width:98%;margin:2% auto 4%;font-size:14px;overflow:hidden;}
.list li{float:left;width:48%;margin:1%;border:1px solid #ddd;background-color:#fff;}
.list li div.pro_pic{position:relative;padding-bottom:100%;border-bottom:1px solid #ddd;overflow:hidden;}
.list li div.pro_pic img{position:absolute;width:100%;left:0;top:0;}
.list_big{background:#fff;}
.list_big li{padding:2% 0;}
.list_big li .list_big_title{padding:4% 4% 0;font-size:18px;color:#222;font-weight:normal;}
.list_big li .list_big_title i{display:inline-block;margin-right:5px;border-radius:50%;width:22px;height:22px;background:#ce0549;color:#fff;font-style:normal;text-align:center;line-height:22px;}
.list_big li img{width:100%;}
.pro_title{height:40px;margin:4%;overflow : hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;line-height:20px;color:#666;}
.pro_info{text-align:right;padding:4%;color:#999;height:35px;}
.pro_price{float:left;color:#ce0549;font-size:16px;}

.remaining{position:relative;z-index:2;float:right;margin:-30px 5px 0 0;padding:2px 10px;border-radius:20px;color:#fff;font-size:14px;line-height:20px;text-indent:20px;background:url(remaining.png);background-position:10px center;background-size:16px 16px;background-color:rgba(0,0,0,0.4);background-repeat:no-repeat;}
</style>
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
</head>
<body>
<div id="header">
    <a href="javascript:history.go(-1);" class="header_back"></a>
    <p class="header_title"><?php echo $objSceneInfo->name; ?></p>
</div>
<div class="wrapper">
    <div class="top">
        <div class="top_info">
        	<?php echo $SceneIntroduction; ?>
        </div>
    </div>
    <ul class="list_big">

    	<?php if(  isset($objSceneProduct['introduce']) && $objSceneProduct['introduce'] != NULL ){  $i=1; ?>
	    	<?php foreach( $objSceneProduct['introduce'] as $Product ){  ?>
		    	<?php $url = "/product_detail.php?type=2&pid=" . $Product->product_id; ?>
		    	<li>
		            <a href="<?php echo $url; ?>">
		            	<h3 class="list_big_title"><i><?php echo $i; ?></i><?php echo $Product->title; ?></h3>
		                <p class="top_info"><?php echo $Product->introduction; ?></p>
		                <div class="pro_pic"><img src="<?php echo $site_image; ?>product/<?php echo $Product->image; ?>" /></div>
		                <div class="top_price">
		                    <span class="top_nowPrice">￥<?php echo $Product->active_price; ?></span>
		                    <br>
		                    <span class="top_oldPrice">&nbsp;价格<font>￥<?php echo $Product->sell_price; ?></font></span>
		                    <a href="<?php echo $url; ?>">
		                    	<strong id="buy">去购买</strong>
		                    </a>
		                </div>
		            </a>
		        </li>
	        <?php ++$i; } ?>
         <?php } ?>

    </ul>
	<ul class="list">
		<?php if( $objSceneProduct['no_introduce'] != NULL ){ ?>
			<?php foreach( $objSceneProduct['no_introduce'] as $k=>$Product ){ ?>
				<?php $url = "/product_detail.php?type=2&pid=" . $Product->product_id; ?>
		    	<li>
		        	<a href="<?php echo $url; ?>">
		            	<div class="pro_pic"><img src="<?php echo $site_image; ?>product/small/<?php echo $Product->image; ?>" /></div>
		                <p class="pro_title"><?php echo $Product->title; ?></p>
		                <div class="pro_info">
		                	<span class="pro_price">￥<?php echo $Product->active_price; ?></span>
		                </div>
		            </a>
		        </li>
		     <?php } ?>
        <?php } ?>
    </ul>


</div>

<?php include "footer_web.php";?>
</body>
</html>
