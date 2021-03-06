<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/js/selectdate/mobile-select-date.min.css" />
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script type="text/javascript" src="/js/zepto_selarea.min.js"></script>
<script type="text/javascript" src="/js/dialog.min.js"></script>
<script type="text/javascript" src="/js/mobile-select-area.min.js"></script>

<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>

<script type="text/javascript">
function del(id){
	if(window.confirm('确定删除该地址记录？')){
		location.href='address_info.php?act=del&id[]='+id;
	}
}
</script>
</head>
<body>

	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title">新增地址</p>
    	<a href="javascript:$('#address_add').submit();" class="header_txtBtn">保存</a>
	</div>

	<form id="address_add" action="address" method="post" onsubmit="return tgSubmit()">
		<input type="hidden" name="act" value="add_save" />
		<input type="hidden" name="from" value="<?php echo $from; ?>" />
		<div class="addressWarp">
			<ul>
				<li>
					<div class="left">收货人</div>
					<div class="right">
						<input id="shipping_firstname" name="shipping_firstname" type="text" class="input" placeholder="请输入收货人姓名"/>
					</div>
				</li>
				<li>
					<div class="left">手机号码</div>
					<div class="right">
						<input id="telephone" name="telephone" type="text" class="input" placeholder="请输入11位手机号码"/>
					</div>
				</li>
				<li>
					<div class="left">邮政编码</div>
					<div class="right">
						<input id="s_postcode" name="postcode" type="text" value="" class="input" placeholder="请输入邮政编码"/>
					</div>
				</li>
				<li>
					<div class="left">地区</div>
					<div class="right">
						<input type="text" class="input" id="areashow" value="" placeholder="省、市、区" />
						<input type="hidden" id="areavalue" name="areavalue" value="" />
					</div>
					<input type="hidden" id="s_province" name="s_province" value="" />
					<input type="hidden" id="s_city" name="s_city" value="" />
					<input type="hidden" id="s_county" name="s_county" value="" />
				</li>
				<li class="big-height">
					<div class="left">详细地址</div>
					<div class="right">
						<textarea rows="6" id='address' name="address" class="input" style="margin-top:10px;"></textarea>
					</div>
				</li>
			</ul>

		</div>
	</form>

<?php include "footer_web.php";?>


<script type="text/javascript">

	function tgSubmit(){
		var shipping=$("#shipping_firstname").val();
		if($.trim(shipping) == ""){
			alert('请输入收货人');
			return false;
		}

		var telephone=$("#telephone").val();
		if($.trim(telephone) == ""){
			alert('请输入手机号码');
			return false;
		}

		if(!isInt(telephone)){
			alert('手机号码必须为11位数字');
			return false;
		}

		var area_idstr = $('#areavalue').val();
		if($.trim(area_idstr) == ""){
			alert('请选择地区');
			return false;
		}

		var address=$("#address").val();
		if($.trim(address) == ""){
			alert('请输入新地址');
			return false;
		}

		var s_postcode=$("#s_postcode").val();
		if($.trim(s_postcode) == ""){
			alert('请填写邮编');
			return false;
		}

		return true;
	}

	function isInt(a)
	{
	    var reg = /^(\d{11})$/;
	    return reg.test(a);
	}

	$(function(){
		var selectArea = new MobileSelectArea();
		selectArea.init({
			trigger:'#areashow',
			value:$('#areavalue').val(),
			data:'/data/area.json',
			callback: function(obj){
				var areaIds = $("#areavalue").val().split(",");
				$("#s_province").val(areaIds[0]);
				$("#s_city").val(areaIds[1]);
				$("#s_county").val(areaIds[2]);
			}
		});
	});

</script>
</body>
</html>
