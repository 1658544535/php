<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $site_name;?></title>
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
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">选择地址</h1>
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
            <%if(data["data"].length>0){%>
                <%for(var i=0;i<data["data"].length; i++){%>
                    <li data-id="<%=data["data"][i].addId%>" data-name="<%=data["data"][i].name%>" data-tel="<%=data["data"][i].tel%>" data-address="<%=data["data"][i].address%>">
                        <div class="txt">
                            <div class="info">
                                <span class="phone a-t-1"><%=data["data"][i].tel%></span>
                                <span class="a-t-2"><%=data["data"][i].name%></span>
                            </div>
                            <div class="address a-t-4"><%=data["data"][i].address%></div>
                        </div>
                        <div class="option">
							<%if(data["data"][i].isDefault==1){%>
	                            <a href="javascript:;" data-id="<%=data["data"][i].addId%>" class="default active"><i></i>默认</a>
							<%}%>
                            <a href="javascript:;"><i></i>&nbsp;</a>
                        </div>
                    </li>
                <%}%>
            <%}else{%>
                <div class="tips-null">暂无地址</div>
            <%}%>
            </script>


			<script type="text/javascript">
			$(document).on("pageInit", "#page-address", function(e, pageId, page) {
		    	var _apiUrl = "api_action.php?act=";

				$(document).on("click", ".user-address-add a", function(){
					$(".popup-address input").not('input[type="submit"]').val('');
					$(".popup-address textarea").val('');
					$("input[name='id']").val(0);
					$.popup('.popup-address');
				});

				$(document).on("submit", ".popup-address form", function(e){
					var _this = $(this);
					e.preventDefault();
					
					if($.trim(_this.find("input.p-a-2").val()) == ""){
						$.toast("请填写收货人");
						return;
					}
					var _tel = _this.find("input.p-a-1").val();
					var _re = /((^1\d{10}$)|(^(\d{3,4}-)?\d{7,8}$))/;
					if($.trim(_tel) == ""){
						$.toast("请填写联系方式");
						return;
					}else if(!_re.test(_tel)){
						$.toast("请正确填写联系方式");
						return;
					}
					if($.trim(_this.find("#city-picker-value").val()) == ""){
						$.toast("请选择省市区");
						return;
					}
					if($.trim(_this.find(".p-a-4").val()) == ""){
						$.toast("请填写详细地址");
						return;
					}

					$.ajax({
						url: _apiUrl+'address_edit',
						data: _this.serialize(),
						dataType: 'json',
						type: 'POST',
						success: function(){
							location.reload();
						},
						failure: function(){
							$.toast("操作失败");
						}
					});
				});

				$(document).on("click", "ul.list-container li", function(){
					var _this = $(this);
					var addr = {"id":_this.attr("data-id"),"name":_this.attr("data-name"),"tel":_this.attr("data-tel"),"address":_this.attr("data-address")};
					document.cookie = "orderaddr="+encodeURIComponent(JSON.stringify(addr));
					location.href = "orders.php?act=address_add&from=orders&aids="+addr.id;
				});
		    });
			</script>
        </div>

		<div class="popup popup-address">
            <div>
                <a href="javascript:;" class="close-popup"></a>
                <form action="" method="" accept-charset="utf-8">
                    <ul>
                        <li>
                            <span class="label">收货人:</span>
                            <div class="main"><input type="text" name="name" class="txt p-a-2" placeholder="请输入收货人" /></div>
                        </li>
                        <li>
                            <span class="label">联系方式:</span>
                            <div class="main"><input type="text" name="tel" class="txt p-a-1" placeholder="请输入联系方式" /></div>
                        </li>
                        <li>
                            <span class="label">收货地址:</span>
                            <div class="main">
                                <input id="city-picker" type="text" class="txt p-a-3" placeholder="请选择省市区" value="" readonly />
                                <input id="city-picker-value" type="hidden" name="area" />
                                <textarea rows="2" name="addr" class="txt p-a-4" placeholder="请输入详细地址"></textarea>
                            </div>
                        </li>
                    </ul>
                    <input type="submit" class="go" value="提交">
                </form>
            </div>
        </div>

        <script type="text/javascript" src="js/lArea/LArea.js" charset="utf-8"></script>
        <script>
			var areaData = <?php echo $jsonArea;?>;
            var area = new LArea();
            area.init({
                'trigger': '#city-picker',//触发选择控件的文本框，同时选择完毕后name属性输出到该位置
                'valueTo':'#city-picker-value',//选择完毕后id属性输出到该位置
                'keys':{id:'id',name:'name'},//绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
                'type':1,//数据源类型
                'data':areaData.data//数据源
            });
        </script>
    </div>
</body>

</html>





