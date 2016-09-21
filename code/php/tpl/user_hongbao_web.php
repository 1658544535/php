<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <title><?php echo $site_name;?></title>
    <link href="/css/index4.css" rel="stylesheet" type="text/css" />
    <link href="/css/common.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript" src="/js/wxshare.js"></script>
    <style type="text/css">
        .order_tabs dd{width:33%;}
        .order_list{padding-bottom:0;}
        .order_list .order_list_title{border-bottom:0;}
        .coupon_detail{font-size:14px; padding:0 10px 5px;}

		html{-webkit-text-size-adjust:none;}
        .clear{clear:both;}
        .panel-help{color:#E61D58; font-family:黑体; font-size:14px;}
        .coupon_tabs a dd{width:32.9%;}
        .form-cpn{margin:10px 5px;}
        .form-cpn *{font-family:黑体;}
        .form-cpn .cpn-input{float:left; width:70%;}
        .form-cpn .cpn-input .input-no{border:1px #D8D8D8 solid; border-radius:5px; font-size:16px; width:95%; padding:8px 0 8px 8px; color:#000;}
        .form-cpn .cpn-btn{float:right; width:30%; text-align:right;}
        .form-cpn .cpn-btn .btn-active{background-color:#E61D58; color:#fff; border:0; font-size:18px; border-radius:5px; width:90%; text-align:center; padding:8px;}
        .coupon-item{margin:0 5px 10px; color:#fff; position:relative;}
        .coupon-item *{font-size:18px; font-family:黑体;}
        .coupon-item .cpn-bg{position:relative; z-index:-1;}
        .coupon-item .cpn-info{position:absolute; width:66%; height:100%;}
        .coupon-item .cpn-info .cpn-base{margin-top:10px;}
        .coupon-item .cpn-info .cpn-base .cpn-money{margin-left:10px; font-size:26px;}
        .coupon-item .cpn-info .cpn-base .cpn-no{position:absolute; right:2px; font-size:16px;}
        .coupon-item .cpn-info .cpn-base .cpn-no.unvalid{color:#aaabab;}
        .coupon-item .cpn-info .cpn-binfo{position:absolute; bottom:10px; left:10px;}
        .coupon-item .cpn-info .cpn-binfo .cpn-rule{margin-top:10px;}
        .coupon-item .cpn-state{position:absolute; right:10px; bottom:10px; width:34%; text-align:right;}
        .coupon-item .cpn-state .cpn-state-icon{width:80%; position:absolute; right:0; bottom:0;}
        .coupon-item .cpn-state .cpn-state-icon img{width:100%;}
        .coupon-item .cpn-state .cpn-valid-tip{}

    </style>
    <script>
        wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
    </script>
</head>
<body>
    <div id="header">
		<dl id="title_warp">
			<dd>
				<a href="<?php echo $return_url; ?>" class="back">
					<img src="/images/index/icon-back.png" />
				</a>
			</dd>
			<dd class="page-header-title">红包</dd>
			<dd><!--<img src="/images/index/icon-back.png" />--></dd>
		</dl>
	</div>

	<div class="nr_warp">
	    <dl class="hongbao_tabs">
            <a href="/user_hongbao.php?return_url=<?php echo $return_url;?>">
                <dd id="active_tab">全部红包</dd>
            </a>

            <a href="/user_hongbao.php?return_url=<?php echo $return_url;?>&act=red">
                <dd>邀请码</dd>
            </a>

            <div class="clear"></div>
        </dl>

	    <div class="order-wrapper">
	        <?php if(empty($list['DataSet'])){ ?>
	            <div class="order_empty" >
					<dl>
						<dd><img src="/images/order/orderlist_icon.png" width="100" /></dd>
						<dd>暂无红包</dd>
					</dl>
				</div>
	        <?php }else{ ?>
	            <?php foreach($list['DataSet'] as $_hongbao){ ?>
	                <div class="order_list">
	                    <div class="order_list_title">
	                        <?php echo $_hongbao->remark;?>
	                        <span class="status_desc"<?php if($_hongbao->money < 0){?> style="color:#999"<?php } ?>>
	                            <?php echo $_hongbao->money/100;?>元
	                        </span>
	                    </div>
	                    <div class="coupon_detail"><?php echo date('Y-m-d H:i:s', $_hongbao->log_time);?></div>
	                </div>
	            <?php } ?>
	            <div id="page" name="page"></div>
	            <?php if( is_array($list['DataSet'])){ ?>
	                <div id="load_btn" style="margin-top:10px; cursor:pointer; background:#e3e3e3; height:40px; line-height:40px; width:100%; text-align:center" onclick="loadMore();">点击加载</div>
	            <?php } ?>
	        <?php } ?>
	    </div>
	</div>

    <?php include "footer_web.php"; ?>
    </br>
    </br>
    </br>
    <?php include "footer_menu_web_tmp.php"; ?>

    <script language="javascript">
        var page = 1;
        var allpage = <?php echo $list['PageCount']; ?>;
        function loadMore(){
            if(page < allpage){
                $("#progressIndicator").show();
                page++;
                $.get("ajaxtpl/ajax_user_hongbao.php?page="+page, function(data){
                    $("#page").before(data);
                    $("#progressIndicator").hide();
                });
            }else{
                alert('已经到达底部！');
                $("#load_btn").hide();
            }
        }
    </script>
</body>
</html>