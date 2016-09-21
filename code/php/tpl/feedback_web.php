<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
</head>

<body>

<div id="header">
    <a href="javascript:history.go(-1);" class="header_back"></a>
    <p class="header_title">投诉建议</p>
</div>

<form action="feedback.php" method="post" onsubmit="return tgSubmit()"  enctype="multipart/form-data">
	<input type="hidden" name="act" value="post" />
	<input type="hidden" name="user_id" value="<?php echo $userid;?>" />
	<div class="feedback_tab">
		<ul>
			<li class="fb active"></li>
			<li class="ts"></li>
		</ul>
		<div class="txt">
			<textarea rows="6" id='content' name="content"></textarea>
		</div>
		<select name="type" id="type" class="hide">
			<option value="1" selected="selected">投　 诉</option>
			<option value="2">建　 议</option>
		</select>
	</div>
	
	<div class="addressWarp">
		<ul>
			<li>
				<div class="left">联系邮箱</div>
				<div class="right">
					<input id="email" name="email" type="text" class="input" placeholder="请填写邮箱"/>
				</div>
			</li>
			<li>
				<div class="left">联系电话</div>
				<div class="right">
					<input id="telephone" name="telephone" type="text" class="input" placeholder="请填联系电话"/>
				</div>
			</li>
		</ul>
	</div>
	<div class="user_footer_btn">
		<input name=""  style=""  type="submit" value="提　交" class="red_btn btn" />
	</div>
</form>

<?php include "footer_web.php";?>


<script type="text/javascript">


function isTelephone(a)
{
    var reg = /^(\d{11})$/;
    return reg.test(a);
}

function isEmail(a)
{
    var reg = /^[A-Za-zd]+([-_.][A-Za-zd]+)*@([A-Za-zd]+[-.])+[A-Za-zd]{2,5}$/;
    return reg.test(a);
}


function isInt(a)
{
    var reg = /^(\d)+$/;
    return reg.test(a);
}

function tgSubmit(){

var email=$("#email").val();
	if($.trim(email) == ""){
		alert('请填写邮箱');
		return false;
	}
    if(!isEmail(email))
	{
		alert('邮箱格式有误！');
		return false;
	}


var telephone=$("#telephone").val();
	if($.trim(telephone) == "")
	{
		alert('请填写联系电话');
		return false;
	}

	if(!isTelephone(telephone))
	{
		alert('联系电话格式有误！');
		return false;
	}


	return true;
}
$(function(){
	$(".feedback_tab ul li").on("click",function(){
		var index = $(".feedback_tab ul li").index(this);
		$(".feedback_tab ul li").removeClass("active").eq(index).addClass("active");
		$("#type option").attr("selected",false).eq(index).attr("selected",true)
	})
});
</script>

</body>
</html>
