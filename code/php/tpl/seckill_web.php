<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="js/jquery.faragoImageAccordion.js"></script>
<script src="/js/lazy/jquery.lazyload.min.js" type="text/javascript"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
    wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
<style type="text/css">
    .clear{clear:both;}
    .sk_nav{height:33px; width:100%; font-family:"黑体"; line-height:20px;}
    .sk_nav li{width:24.7%; display:inline-block; text-align:center; float:left; background-color:#595757; padding:4px 0; color:#fff; border-right:1px #3e3a39 solid;}
    .sk_nav li:last-child{border-right:0;}
    .sk_nav li.cur{/*border-bottom:2px solid #E60749;*/ background-color:#e61e58;}
    .sk_nav li .main{font-size:16px;}
    .sk_nav li .tip{font-size:12px;}
    .sk_nav li.cur .main{}
    .nr_warp{}
    .banner{width:100%;}
    #list-panel .hide{display:none;}
    #list-panel li{border-bottom:1px solid #ccc; width:90%; margin:10px auto 0; padding-bottom:5px; position:relative;}
    #list-panel li a{display:block;}
    #list-panel li a .proavatar{width:100px; float:left; margin-right:15px; position:relative;}
    #list-panel li a .proavatar .selledtip{position:absolute; padding:35px 20px; background-color:rgba(51,51,51,0.5); font-size:18px; border-radius:60px; color:#fff; text-align:center; margin:0 auto;}
    #list-panel li a .pname{font-family:"黑体,Regular"; color:#666; font-size:14px; line-height:130%; height:35px; overflow:hidden; margin-bottom:30px;}
    #list-panel li a .pdiscount{color:#fff; background-color:#E60749; width:40px; margin-left:120px; text-align:center; border-radius:5px; padding:2px;}
    #list-panel li a .pprice{color:#E60749; font-size:14px;}
    #list-panel li a .buyratio{position:absolute; right:0; bottom:35px;}
    #list-panel li a .buyratio .ratio-container{width:80px; border:1px #ED797F solid; border-radius:3px; color:#000; font-size:12px; position:relative;}
    #list-panel li a .buyratio .ratio-container.full{border-color:#B4B4B4;}
    #list-panel li a .buyratio .ratio-container .ratio-bar{background-color:#ED797F; position:relative; width:0; display:block; height:20px; line-height:20px;}
    #list-panel li a .buyratio .ratio-container .ratio-bar.full{background-color:#B4B4B4;}
    #list-panel li a .buyratio .ratio-container .ratio-bar .ratio-tip{position:absolute; width:80px; text-align:center;font-size:10px;}
    #list-panel li a .btnop{right:0; display:block; position:absolute; bottom:5px; border-radius:5px; width:80px; text-align:center; padding:5px 0; background-color:#E60749; color:#fff; border:1px #E60749 solid;}
    #list-panel li a .btnop.full{background-color:#fff; color:#E60749;}
    #btn-next{width:100%; background-color:#E5E5E5; color:#9C9D9D; font-size:16px; text-align:center; padding:10px 0; display:block;}
    .staticbar{background-color:#e6e6e6; color:#595757; padding:8px 10px; font-size:16px;text-align:center;}
    .staticbar .static{float:left;}
    .staticbar .contime{float:right;}
    .staticbar .contime .timenum{background-color:#898989; color:#fff; display:inline-block; padding:2px 3px; margin:0px 2px; border-radius:5px;}
</style>
</head>

<body>

<div id="header">
    <a href="index.php" class="header_back"></a>
    <p class="header_title">限量购</p>
</div>

<?php if ($tabInfo != NULL){ ?>
	<div class="sk_nav">
	    <ul>
	        <?php foreach( $tabInfo as  $k=>$info ){ ?>
	            <li class="<?php echo $k == $tabIndexs ? 'cur':'';?>" onclick="location.href='/seckill.php?ti=<?php echo $info->id; ?>'">
	                <div class="main"><?php echo $info->title; ?></div>
	                <div class="tip">
	                    <?php echo $info->tip; ?>
	                </div>
	            </li>
	        <?php } ?>
	    </ul>
	</div>

	<div class="clear"></div>

	<div class="staticbar">
	    <div id="curstatic"><?php echo $nowSeckillInfo->tip; ?></div>
	    <div class="contime" id="contime" style="display:none">
	        <span id="timestatic"><?php echo $nowSeckillInfo->actiStateTexts; ?></span> <span id="retime"><span class="timenum">00</span>:<span class="timenum">00</span>:<span class="timenum">00</span></span>
	    </div>
	    <div class="clear"></div>
	</div>


	<?php if( !empty(  $nowSeckillInfo->banner ) ){ ?>
		<div class="banner">
		    <img src="<?php echo $site_image.'activity/' . $nowSeckillInfo->banner; ?>" />
		</div>
	<?php } ?>


	<div class="nr_warp">
	    <ul id="list-panel">

	        <?php if ( $objSeckillProduct['list'] == NULL ){ ?>
	       		<div style="text-align:center; margin:20px;">暂时没有产品</div>
	        <?php }else{ ?>
	        	<?php foreach( $objSeckillProduct['list'] as $product ){ ?>
			        <?php if ( $nowSeckillInfo->status == 'doing' ){ ?>
				        <li>
				            <a href="<?php echo $product->activity_stock > 0 ? $_url . $product->product_id . '&aid=' . $tabIndexs : 'javascript:void(0);' ;?>">
				                <div class="proavatar">
				                    <?php if( $product->activity_stock == 0 ){ ?><div class="selledtip">已售罄</div><?php } ?>
				                    <img class="lazyload" data-original="<?php echo $site_image?>/product/small/<?php echo $product->image;?>" />
				                </div>
				                <p class="pname"><?php echo $product->product_name;?></p>
				                <p class="pdiscount"><?php echo $product->tips; ?></p>
				                <p class="pprice">￥<?php echo sprintf( '%.1f',$product->active_price);?></p>
				                <div class="buyratio">
				                    <div class="ratio-container">
				                        <div class="ratio-bar" style="width:<?php echo $product->sales; ?>%">
				                            <span class="ratio-tip">已售<?php echo $product->sales; ?>%</span>
				                        </div>
				                    </div>
				                </div>
				                <?php if ( $product->activity_stock > 0 ){ ?>
				                	<span class="btnop">去抢购</span>
				                <?php } ?>
				            </a>
				            <div class="clear"></div>
				        </li>
					<?php }else{ ?>
						<li>
				            <a href="<?php echo $_url . $product->product_id . '&aid=' . $tabIndexs ;?>">
				                <div class="proavatar">
				                    <img class="lazyload" data-original="<?php echo $site_image?>/product/small/<?php echo $product->image;?>" />
				                </div>
				                <p class="pname"><?php echo $product->product_name;?></p>
				                <p class="pprice">￥<?php echo sprintf( '%.1f',$product->active_price);?></p>
				                <span class="btnop full">即将开抢</span>
				            </a>
				            <div class="clear"></div>
				        </li>
					<?php } ?>
				<?php } ?>
	        <?php } ?>
	    </ul>
	</div>
<?php } ?>

<?php include "footer_web.php"; ?>

<script language="javascript">
	$(function(){
	    downcount(<?php echo $nowSeckillInfo->curOverTimeDiff; ?>);
	});

	function downcount(_diff){
	    if(_diff > 0){
	        showTime(_diff);
	        setTimeout(function(){downcount(--_diff);}, 1000);
	    }else if(_diff == 0){
	        <?php if( $nowSeckillInfo->status == 'doing' ){ ?>
	            window.location.href = "/seckill.php?ti=<?php echo $nextIndexs;?>";
	        <?php }else{ ?>
	            window.location.reload();
	        <?php } ?>
	    }
	}

	function showTime(_diff){
	    var _hour = parseInt(_diff / 3600);
	    _diff = _diff % 3600;
	    var _minute = parseInt(_diff / 60);
	    var _second = _diff % 60;
	    _hour = (_hour < 10) ? "0"+_hour : _hour;
	    _minute = (_minute < 10) ? "0"+_minute : _minute;
	    _second = (_second < 10) ? "0"+_second : _second;
	    $("#retime").html('<span class="timenum">'+_hour+'</span>:<span class="timenum">'+_minute+'</span>:<span class="timenum">'+_second+'</span>');
	    $("#contime").show();
	}
</script>

</body>
</html>