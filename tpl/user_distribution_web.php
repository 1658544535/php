<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<title><?php echo $site_name;?></title>
    <link href="css/index4.css" rel="stylesheet" type="text/css" />
    <link href="/css/common.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="/js/wxshare.js"></script>
	<script>
		wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
	</script>
	<style>
		/*body{background-color:#F7F8F8;}*/
	.index-wrapper dl{
		background:#fff;

	}
		.apply dd {
			padding:10px 5px 0;
		}

		.apply dd label, .apply dd p{
			font-size:14px;
		}

		.apply dd textarea{
			margin-left:90px;
			width:60%;
			padding:5px;
			color:#666;
		}

		.form-item-con{border-bottom:1px solid #f2f2f2;}
		.addressWarp{width:90%;}
		.addressWarp li .left { width:75px; font-size:15px;}
		.addressWarp .input { width:68%; font-size:15px; border-bottom:0;}
		.red_btn{border-radius:5px !important;}
		.addressWarp .btn_warp{}
		#person_code_img{width:80px; height:80px; position:absolute; filter:alpha(opacity=0); -moz-opacity:0; -khtml-opacity:0; opacity:0;}
		.uploadicon{display:inline-block; margin-left:12px;}
	</style>

</head>

<body>
<div id="header">
		<dl id="title_warp">
			<dd>
				<a href="<?php echo $return_url; ?>">
					<img src="/images/index/icon-back.png" />
				</a>
			</dd>
			<dd class="page-header-title">申请分销</dd>
		   <dd><!--<img src="/images/index/icon-back.png" />--></dd>
		</dl>
	</div>



<div class="index-wrapper">
<div class="nr_warp" style="background:#fff;">
	<form action="user_distribution" method="post" onsubmit="return tgSubmit()" class="apply"  enctype="multipart/form-data">
		<input type="hidden" name="act" value="post" />
		<input type="hidden" name="user_id" value="<?php echo $userid;?>" />
		<div class="addressWarp">
			<ul>
				<li>
					<div class="form-item-con">
						<div class="left">姓名</div>
						<div class="right">
							<input id="name" name="name" type="text" class="input" placeholder="请填写姓名"/>
						</div>
					</div>
				</li>
				<li>
					<div class="form-item-con">
						<div class="left">性别</div>
						<div class="right">
							<select name="sex" class="input">
								<option value='0' >请选择</option>
								<option value='1' >男</option>
								<option value='2' >女</option>
							 </select>
						</div>
					</div>
				</li>

				<li>
					<div class="form-item-con">
						<div class="left">身份证号码</div>
						<div class="right">
							<input id="person_code" name="person_code" type="text" class="input" placeholder="请填写身份证号码"/>
						</div>
					</div>
				</li>

				<li style="height:auto;">
					<div class="form-item-con" style="border-bottom:0;">
						<div class="left" style="margin-top:30px;">身份证图片</div>
						<div class="right">
							<input id="person_code_img" name="person_code_img" type="file" class="input" />
							<div class="uploadicon">
								<img src="/images/fileupload.png" width="80" />
							</div>
						</div>
					</div>
				</li>
			</ul>

			<div class="btn_warp" style="margin-top:40px;">
				<input name=""  style=""  type="submit" value="提交" class="red_btn btn" />
			</div>
		</div>

    </div>
    </form>

</div>

</br>
</br>
</br>
<?php include "footer_web.php";?>
</br>
</br>
</br>
<?php include "footer_menu_web_tmp.php"; ?>

<script type="text/javascript">


function isPerson_code(a)
{
    var reg = /^\d{6}(18|19|20)?\d{2}(0[1-9]|1[12])(0[1-9]|[12]\d|3[01])\d{3}(\d|X|x)$/;
    return reg.test(a);
}




function isInt(a)
{
    var reg = /^(\d)+$/;
    return reg.test(a);
}

function tgSubmit(){
	var name=$("#name").val();
	if($.trim(name) == ""){
		alert('请填写姓名');
		return false;
	}


	var person_code=$("#person_code").val();
	if($.trim(person_code) == "" ){
		alert('请填写身份证号码');
		return false;
	}

	if(!isPerson_code(person_code)){
		alert('身份证格式有误！');
		return false;
	}

    var person_code_img=$("#person_code_img").val();
	if($.trim(person_code_img) == ""){
		alert('请上传身份证图片');
		return false;
	}
	return true;
}
</script>

</body>
</html>
