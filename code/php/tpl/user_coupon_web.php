<?php
/*
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<meta name="format-detection" content="telephone=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<style type="text/css">
    html{-webkit-text-size-adjust:none;}
    .clear{clear:both;}
    .panel-help{color:#E61D58; font-family:黑体; font-size:14px;}
    .coupon_tabs a dd{width:32.9%;}
    .form-cpn{margin:10px 5px;}
    .form-cpn *{font-family:黑体;}
    .form-cpn .cpn-input{float:left; width:70%;}
    .form-cpn .cpn-input .input-no{border:1px #D8D8D8 solid; border-radius:5px; font-size:14px; width:95%; padding:8px 0 8px 8px; color:#000;}
    .form-cpn .cpn-btn{float:right; width:30%; text-align:right;}
    .form-cpn .cpn-btn .btn-active{background-color:#E61D58; color:#fff; border:0; font-size:18px; border-radius:5px; width:90%; text-align:center; padding:6px 8px;}
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
        <a href="javascript:history.go(-1);" class="header_back"></a>
        <p class="header_title">优惠券</p>
        <!-- <a href="#" class="header_txtBtn" style="width:70px;">使用规则</a> -->
    </div>

    <div class="nr_warp" style="margin-top:10px;">
        <div class="form-cpn">
            <form action="/user_info.php?act=coupon_active" method="post" onsubmit="return activeCpnNo(this)">
                <div class="cpn-input">
                    <input type="text" name="cpnno" id="cpnno" class="input-no" placeholder="请输入优惠券券号" value="" />
                </div>
                <div class="cpn-btn">
                    <input type="submit" name="active" class="btn-active" value="激活" id="btn-active" />
                </div>
            </form>
            <div class="clear"></div>
        </div>

        <div class="order-wrapper">
            <?php if( $objUserCouponList == NULL ){ ?>
                <div class="order_empty" >
                    <dl>
                        <dd><img src="/images/nocpn.png" width="100" /></dd>
                        <dd style="color:#999">没有券</dd>
                        <!--  <dd>首单满88送88</dd>-->
                    </dl>
                </div>
            <?php }else{ ?>
                <?php
                $cpnBG = array(0=>'/images/coupon/tzm-295.png', 1=>'/images/coupon/tzm-294.png');
                $noColor = array(0=>'unvalid', 1=>'');
                ?>
                <?php foreach( $objUserCouponList as $_coupon){ ?>
                    <?php
	                    $_stateIcon = '';
	                    if($_coupon->used)
	                    {
	                        $_stateIcon = '/images/coupon/tzm-296.png';
	                    }
	                    elseif($_coupon->userconpon_valid_etime < $time)
	                    {
	                        $_stateIcon = '/images/coupon/tzm-297.png';
	                    }
                    ?>

					<?php if( $from == 'order_comfire' ){ ?>
						<a href="/orders.php?act=coupon_add&cid=<?php echo $_coupon->coupon_no; ?>">
					<?php }else{ ?>
						<a href="javascript:void(0);">
					<?php } ?>
	                    <div class="coupon-item">
	                        <div class="cpn-info">
	                            <div class="cpn-base">
	                                <span class="cpn-money">￥<?php echo $_coupon->money;?></span>
	                                <span class="cpn-no <?php echo $noColor[$_coupon->useStatus];?>"><?php echo $_coupon->coupon_no;?></span>
	                            </div>
	                            <div class="cpn-binfo">
	                                <div class="cpn-name"><?php echo $_coupon->name;?></div>
	                                <?php if(isset($_coupon->rule) && $_coupon->rule){ ?><div class="cpn-rule"><?php echo $_coupon->rule;?></div><?php } ?>
	                            </div>
	                        </div>
	                        <div class="cpn-state">
	                            <?php if($_stateIcon){ ?><div class="cpn-state-icon"><img src="<?php echo $_stateIcon;?>" /></div><?php } ?>
	                            <div class="cpn-valid-tip">有效期</div>
	                            <div><?php echo $_coupon->validEndTime;?></div>
	                        </div>
	                        <img class="cpn-bg" src="<?php echo $cpnBG[$_coupon->useStatus];?>" />
	                        <div class="clear"></div>
	                    </div>
	                </a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

    <?php include "footer_web.php"; ?>
    <script language="javascript">


        function activeCpnNo(obj){

            if($.trim($("#cpnno").val()) == ""){
                alert("请输入代金券券号");
            }else{
                var _btn = $("#btn-active");
                var _obj = $(obj);
                var _btnColor = _btn.css("background-color");
                _btn.attr("disabled", "disabled").val("提交中").css({"background-color":"#ccc"});
                $.post(_obj.attr("action"), _obj.serialize(), function(r){
                    _btn.removeAttr("disabled").val("激活").css({"background-color":_btnColor});
                    alert(r.msg);
                    if(r.code == "1") window.location.reload();
                }, "json");
            }
            return false;
        }
    </script>
</body>
</html>
*/
?>







<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>淘竹马</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="css/sm.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="js/swiper/swiper.min.css">
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/baiduTemplate.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
</head>

<body>
    <div class="page-group" id="page-coupon">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">优惠券</h1>
            </header>

            <div class="content native-scroll">

                <section class="user-tab user-tab3" data-href="ajaxtpl/ajax_user_coupon_new.php">
                    <ul>
                        <li data-type="1"><a href="javascript:;">未使用</a></li>
                        <li data-type="2"><a href="javascript:;">已过期</a></li>
                        <li data-type="3"><a href="javascript:;">已使用</a></li>
                    </ul>
                </section>

                <section class="user-coupon clickbox infinite-scroll infinite-scroll-bottom" data-distance="30">
                    <ul class="list-container"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                </section>

            </div>

            <script id='tpl_pull_tab' type="text/template">
            <%if(data["data"].length>0){%>
                <%for(var i=0;i<data["data"].length; i++){%>
                    <li>
                        <div class="freeCoupon">
                            <div class="info">
                                <div class="name"><%=data["data"][0]["couponList"][i]["couponName"]%><span>(团长免费开团)</span></div>
                                <div class="tips">点击选择团免商品</div>
                                <div class="time">有效期: <%=data["data"][0]["couponList"][i]["validStime"]%>-<%=data["data"][0]["couponList"][i]["validEtime"]%></div>
                            </div>
                            <div class="price"><div>￥<span>0</span></div></div>
                            <div class="overdue"><!--已过期--></div>
                        </div>
                    </li>
                <%}%>
            <%}else{%>
                <li class="null"></li>
            <%}%>
            </script>

        </div>
    </div>
</body>

</html>
