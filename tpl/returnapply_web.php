<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/js/localResizeIMG4/lrz.bundle.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
<style>
	.order_pro_list li h3{background:none;padding:8px 0;font-weight:normal;color:#000;font-size:14px;}
</style>
</head>
<body>
	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title">申请退款</p>
	</div>

	<div class="user_edit refund_list">
	    <form action="/orders" method="post" onsubmit="return tgSubmit()">
	        <input type="hidden" name="act" value="refund_save" />
			<input type="hidden" name="oid" value="<?php echo $ProductInfo->id;?>" />
	        <ul>
	            <li>
	                <label class="user_edit_label">退款原因</label>
	                <div class="user_edit_item">
	                    <p id="refund_reason" class="user_edit_select" data-title="请选择退款原因">请选择退款原因</p>
	                    <select id="type" name="refund_type">
	                        <option value='1'>不喜欢</option>
	                        <option value='2'>质量不好</option>
	                        <option value='3'>尺码不对</option>
	                        <option value='4'>颜色不对</option>
	                        <option value='5'>其他</option>
	                    </select>
	                </div>
	            </li>
	            <li>
	                <label class="user_edit_label">退款数量</label>
	                <div class="user_edit_item">
	                    <input id="num" name="num" type="text" placeholder="请填写退款数量" />
	                </div>
	            </li>
	            <li>
	                <label class="user_edit_label">退款说明</label>
	                <div class="user_edit_item">
	                    <input name="reason" id="reason" type="text" placeholder="" />
	                </div>
	            </li>
<!--
	            <li>
	                <label class="user_edit_label" style="padding-top:17px;">上传凭证</label>
	                <div class="user_edit_item">
	                    <input id="avatar" type="file" capture="camera" />
	                    <img id="avatarImg" src="../images/btn_add_picture.png" width="50" height="50" />
	                </div>
	            </li>
-->
	        </ul>

	        <div class="order_pro_list order_list_new">
				<ul>
					<li>
						<h3>订单信息</h3>
						<table border="0" cellpadding="0" cellspacing="0">
							<tbody><tr>
								<td width="80">
									<img src="<?php echo $site_image .'/product/small/' . $ProductInfo->product_image; ?>">
								</td>
								<td class="order_pro_title"><?php echo $ProductInfo->product_name; ?></td>
								<td width="50" align="right">
									<p style="color:#333;">￥<?php echo $ProductInfo->stock_price; ?></p>
									<span><?php echo $ProductInfo->num; ?>件</span>
								</td>
							</tr>
						</tbody></table>
					</li>
				</ul>
			</div>

			<div class="user_footer_btn">
				<input type="submit" value="提交申请" />
			</div>
	    </form>
	</div>

	<?php include "footer_web.php";?>

<script type="text/javascript">
function tgSubmit(){
	var type=$("#refund_reason").html();
	if($.trim(type) == "请选择退款原因"){
		alert('请选择退款原因');
		return false;
	}
	var refund_num=$("#num").val();
	if($.trim(refund_num) == ""){
		alert('请填写退款数量');
		return false;
	}
	var reason=$("#reason").val();
	if($.trim(reason) == ""){
		alert('请填写退款说明');
		return false;
	}
	var avatar=$("#avatar").val();
	if($.trim(avatar) == ""){
		alert('请上传凭证');
		return false;
	}

	return true;
}
</script>
<script type="text/javascript">
$(function(){
	document.querySelector('#avatar').addEventListener('change', function () {
        var that = this;

        lrz(that.files[0], {
            width: 200,
            height: 200
        }).then(function (rst) {
            $("#avatarImg").attr("src", rst.base64);
            $("#avatarFile").val(rst.base64);
            $("#avatarType").val(rst.origin.type);
            $("#avatarFileName").val(rst.origin.name);
            $("#avatarFileSize").val(rst.origin.size);
            $("#avatarFileLen").val(rst.base64Len);
        });
    });

    $(".user_edit_select").on("click",function(){
        var _this = $(this);
        var aHtml = '<div class="m_select" id="m_select">'
                  +    '<div class="m_select_bg" onclick="m_select_close()"></div>'
                  +    '<div class="m_select_main animate_moveUp">'
                  +        '<dl>'
                  +           '<dt>'+ $(this).attr("data-title") +'</dt>';

        _this.next().find("option").each(function(index, el) {
            aHtml +=       '<dd onclick="m_select_choose(this,'+ index +')"data-aim="#' + _this.attr("id") + '"> '+ $(el).html() +'</dd>'
        });

            aHtml +=        '</dl>'
                  +        '<a href="javascript:m_select_close();" class="m_select_close">取消</a>'
                  +    '</div>'
                  +'</div>';
        $("body").append(aHtml);
    });
});
function m_select_choose(obj,index){
    var aim = $(obj).attr("data-aim");
    $(aim).html($(obj).html());
    $(aim).next().find("option").attr("selected",false);
    $(aim).next().find("option").eq(index).attr("selected",true);
    m_select_close()
}
function m_select_close(){
    $(".m_select_main").removeClass("animate_moveUp").addClass("animate_moveDown");
    setTimeout(function(){
        $("#m_select").remove();
    },200);
}
</script>

</body>
</html>
