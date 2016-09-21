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
	<div class="nr_warp" style="margin-bottom:100px;">
       <dl class="hongbao_tabs">
            <a href="/user_hongbao.php?return_url=<?php echo $return_url;?>">
                <dd>全部红包</dd>
            </a>
            <a href="/user_hongbao.php?return_url=<?php echo $return_url;?>&act=red">
                <dd id="active_tab">邀请码</dd>
            </a>
             <div class="clear"></div>
        </dl>
        <div class="form-cpn">
            <div class="cpn-input">
                <input type="text" name="cpnno" id="cpnno" class="input-no" placeholder="请输入邀请码" value="" />
            </div>
            <div class="cpn-btn">
                <input type="button" name="active" class="btn-active" value="激活" id="btn-active"  />
            </div>

            <div class="clear"></div>
        </div>
    </div>


        <?php include "footer_web.php"; ?>
    </br>
    </br>
    </br>
    <?php include "footer_menu_web_tmp.php"; ?>
    <script language="javascript">

        $('#btn-active').click(function(){
        	var code = $.trim($('#cpnno').val());

        	if( code == "")
            {
                alert("请输入邀请码");
            }
            else
            {

                var _btn = $("#btn-active");

				$.ajax({
					url: "/user_hongbao.php?act=active&code=" + code,
					dataType:'json',
					success:function(r){
						alert(r.msg);

						if ( r.code == 1 )
						{
							var _btnColor = _btn.css("background-color");
          					_btn.attr("disabled", "disabled").val("提交中").css({"background-color":"#ccc"});

                			location.reload();
						}
					}
				})
            }
        })

    </script>
</body>
</html>