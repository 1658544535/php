<?php
/*
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<meta content="telephone=no" name="format-detection" />
<title><?php echo $site_name;?></title>
<link href="css/index4.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>

<script>
	function del(id)
	{
		if(window.confirm('确定删除该地址记录？'))
		{
			location.href='address.php?act=del&id='+id;
		}
	}

	function set_default(id)
	{
		location.href='address.php?act=defaults&aid='+id;
	}


</script>

</head>

<body>

	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title">地址管理</p>
	    <a id="add_del" href="javascript:;" class="header_txtBtn hide">删除</a>
	    <a id="add_edit" href="javascript:;" class="header_txtBtn">编辑</a>
	</div>

	<div class="nr_warp">
		<?php  if (  $addressList == NULL ){ ?>
			<div class="address_empty" >
				<dl>
					<dd><img src="/images/address/empty_icon.png" width="80" /></dd>
					<dd>您还没有设置收货地址哦！</dd>
					<dd>
						<a href="address?act=add">
							<img src="/images/address/btn_icon.png" width="85" />
						</a>
					</dd>
				</dl>
			</div>
		<?php }else{ ?>
			<div class="address_list_warp">
				<dl>
					<?php foreach ( $addressList as $get_address ){  ?>
						<dd>
							<div class="list_checkbox hide"><input type="checkbox" /></div>
							<a href="/address.php?act=edit&from=<?php echo $from; ?>&aids=<?php echo $get_address->id; ?>">
								<?php
									$address_is_default 	  = ($get_address->is_default == 1) ? "<span style='color:#fff; background:#f9c03b; padding:0px 3px; margin-right:5px;font-size:10px;'>默认</span> " : "";
									$alladdress				  = "<div style='font-size:12px; line-height:30px;'>". $address_is_default ."<span style='font-size:14px;color:#666;'>".$get_address->consignee."</span><span style='float:right;'>".$get_address->consignee_phone."</span></div>";
									$alladdress 			 .= "<div style='font-size:12px; margin-bottom:5px;'>" .  $get_address->desc . "</div>";
									echo $alladdress;
								?>
							</a>
						</dd>
					<?php } ?>
				</dl>
              </div>
		<?php } ?>
	</div>

	<?php if(count($addressList) > 0){ ?>
	<div class="add_address_nav">
		<a href="address?act=add&from=<?php echo $from; ?>&return_url=<?php echo $returnUrl; ?>">添加新地址</a>
	</div>
	<?php } ?>

	<?php include "footer_web.php";?>

	<script>
		$(function(){
			$("#add_edit").on("click",function(){
				var _this = $(this);
				if(_this.html() == "编辑"){
					_this.html("完成");
					$("#add_del,.list_checkbox").removeClass("hide");
				}else{
					_this.html("编辑");
					$("#add_del,.list_checkbox").addClass("hide");
				}
			});

			$(".list_checkbox input").on("change",function(){
				var _this = $(this);
				if(_this.is(":checked")){
					_this.parents(".list_checkbox").addClass("active");
				}else{
					_this.parents(".list_checkbox").removeClass("active");
				}
			})
		})
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
    <div class="page-group" id="page-address">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">我的地址</h1>
            </header>

            <div class="content native-scroll" style="bottom:2.5rem;">

                <section class="user-address pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="api_action.php?act=address">
                    <ul class="list-container"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                </section>

            </div>

            <div class="user-address-add">
                <a href="javascript:;">添加新地址</a>
            </div>

            <script id='tpl_pull' type="text/template">
                <%for(var i=0,len=data["data"].length;i<len; i++){%>
                    <li data-id="<%=data["data"][i].addId%>">
                        <div class="txt">
                            <div class="info">
                                <span class="phone"><%=data["data"][i].tel%></span>
                                <span><%=data["data"][i].name%></span>
                            </div>
                            <div class="address"><%=data["data"][i].address%></div>
                        </div>
                        <div class="option">
                            <a href="javascript:;" data-id="<%=data["data"][i].addId%>" class="default"><i></i>设为默认</a>
                            <a href="javascript:;" data-id="<%=data["data"][i].addId%>" class="edit"><i></i>编辑</a>
                            <a href="javascript:;" data-id="<%=data["data"][i].addId%>" class="del"><i></i>删除</a>
                        </div>
                    </li>
                <%}%>
            </script>

			<script type="text/javascript">
			$(document).on("pageInit", "#page-address", function(e, pageId, page) {
		    	var _apiUrl = "api_action.php?act=";

		    	$(document).off("click", "ul.list-container li a.default").on("click", "ul.list-container li a.default", function(){
					var _id = $(this).attr("data-id");
				});

		    	$(document).off("click", "ul.list-container li a.del").on("click", "ul.list-container li a.del", function(){
					var _id = $(this).attr("data-id");
					$.confirm("确定要删除此地址吗？", function(){
						$.post(_apiUrl+"address_del", {"id":_id}, function(r){
							if(r.code == 1){
								$("ul.list-container li[data-id='"+_id+"']").remove();
							}else{
								$.toast(r.msg);
							}
						}, "json");
					});
				});
		    });
			</script>

        </div>
    </div>
</body>

</html>

