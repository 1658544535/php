<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
<!--IOS中Safari允许全屏浏览-->
<meta content="yes" name="apple-mobile-web-app-capable">
<!--IOS中Safari顶端状态条样式-->
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<title>我的奖品</title>
<style>
    html,body{width:100%;margin:0;padding:0;background:#f9d3e3;font-family:"Microsoft YaHei";}
    a{-webkit-tap-highlight-color:rgba(0,0,0,0);}
    .record_list{margin:10px;padding:0;font-size:14px;color:#595757;}
    .record_list li{position:relative;overflow:hidden;margin-bottom:5px;background:url(images/record.png) no-repeat;background-size:100% auto;list-style:none;}
    .r_img{float:left;position:relative;width:22%;padding-bottom:22%;}
    .r_img img{position:absolute;width:90%;height:90%;top:5%;left:5%;}
    .r_info{position:absolute;top:0;left:0;height:100%;margin-left:30%;width:70%;}
    .record_pro{width:94%;color:#595757;font-size:15px;padding-top:7.6%;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;}
    .record_time{position:absolute;width:94%;left:0;bottom:0;margin:0;padding-bottom:7.6%;font-family:arial;color:#727171;font-size:12px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;}
    @media screen and (max-width: 360px) {
        .record_pro{padding-top:7%;font-size:13px;}
        .record_time{padding-bottom:7%;font-size:11px;}
    }
    .empty img{width:100%;margin-top:40%;}

    .record_time{overflow:inherit;}
    .record_time a{position:absolute;right:0;top:-3px;padding:2px 0;width:66px;text-align:center;font-size:13px;color:#e73c7b;border:1px solid #e73c7b;border-radius:5px;text-decoration:none;background:#fff;cursor:pointer;}
    .record_time a.confirmed{color:#b4b5b5;border-color:#b4b5b5;}
</style>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo WEBLINK . "?oid=" . $_SESSION['shake_info']['openid'] . "&unid=" . $_SESSION['shake_info']['unionid'];?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
</head>

<body>
	<?php if ( $arrRecord == null ){ ?>
		<div class="empty">
		    <img src="images/empty.png" />
		</div>
	<?php }else{ ?>
		<ul class="record_list">
		    <?php foreach( $arrRecord as $arr ){ ?>
		    	 <li>
			        <div class="r_img"><img src="upfiles/<?php echo $arr->image; ?>" /></div>
			        <div class="r_info">
			            <div class="record_pro"><?php echo $arr->name; ?></div>
			            <p class="record_time">
			                <?php echo date('Y-m-d H:i:s',$arr->addtime); ?>

			                <?php if ( $arr->is_used == 1 ){  ?>
			                	<a class="confirmed">已兑换</a>
			                <?php }else{ ?>
			               		<a href="#" onclick="used(<?php echo $arr->spr_id ?>)" >确认兑换</a>
			                <?php } ?>
			            </p>
			        </div>
			    </li>
		    <?php } ?>
		</ul>
	<?php } ?>


<script>
	function used(id)
	{
		if ( confirm('是否确认兑换？') )
		{
			location.href="index.php?act=record_save&id=" + id;
		}

	}
</script>

</body>
</html>


