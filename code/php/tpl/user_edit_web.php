<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/js/selectdate/mobile-select-date.min.css" />
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script type="text/javascript" src="/js/selectdate/zepto.min.js"></script>
<script type="text/javascript" src="/js/dialog.min.js"></script>
<script type="text/javascript" src="/js/selectdate/mobile-select-date.min.js"></script>
<script type="text/javascript" src="/js/localResizeIMG4/lrz.bundle.js"></script>
<script>
    wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>
</head>

<body>
<div id="header">
    <a href="user.php" class="header_back"></a>
    <p class="header_title">个人资料编辑</p>
    <a href="javascript:$('#user_edit').submit();" class="header_txtBtn">保存</a>
</div>

<div class="user_edit">
    <form id="user_edit" action="/user_info" method="post" onsubmit="return doSubmit()" class="apply" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="<?php echo $userid;?>" />
        <input type="hidden" name="act" value="user_info_save" />
        <ul>
            <li>
                
                <div class="user_edit_item" style="margin-left:0;">
                    <input id="avatar" type="file" capture="camera" />
                    <?php
                    if($user->image == ''){
                        $avatarSrc = 'images/user/photo.png';
                    }else{
                        if(preg_match('#^http://.*#', $user->image)){
                            $avatarSrc = $user->image;
                        }else{
                            $avatarSrc = $site_image.'userlogo/'.$user->image;
                        }
                    }
                    ?>
                    <img id="avatarImg" src="<?php echo $avatarSrc; ?>" width="50" height="50" />
                    <input type="hidden" name="avatar" id="avatarFile" value="" />
                    <input type="hidden" name="avatarType" id="avatarType" value="" />
                    <input type="hidden" name="avatarFileName" id="avatarFileName" value="" />
                    <input type="hidden" name="avatarFileSize" id="avatarFileSize" value="" />
                    <input type="hidden" name="avatarFileLen" id="avatarFileLen" value="" />
                </div>
            </li>
        </ul>
        <ul>
            <li>
                <label class="user_edit_label">昵　　称</label>
                <div class="user_edit_item">
                    <input id="name" name="name" type="text" placeholder="请输入昵称" value="<?php echo $user->name;?>" />
                </div>
            </li>
            <li>
                <label class="user_edit_label">性　　别</label>
                <div class="user_edit_item">
                    <p id="parent_sex" class="user_edit_select" data-title="请选择性别">男</p>
                    <select name="sex">
                        <option value='1' <?php echo isset($selSex[1]) ? $selSex[1] : '';?>>男</option>
                        <option value='2' <?php echo isset($selSex[2]) ? $selSex[2] : '';?>>女</option>
                    </select>
                </div>
            </li>

             <li>
                <label class="user_edit_label">宝宝生日</label>
                <div class="user_edit_item">
                    <input id="baby_birthday" name="baby_birthday" type="text" value="<?php echo $userInfo->baby_birthday;?>" placeholder="请选择宝宝生日日期" />
                </div>
            </li>
            
            
            <li>
                <label class="user_edit_label">宝宝性别</label>
                <div class="user_edit_item">
                    <p id="child_sex" class="user_edit_select" data-title="请选择性别">小王子</p>
                    <select name="baby_sex" class="input">
                        <option value='1' <?php echo isset($selBabySex[1]) ? $selBabySex[1] : '';?>>小王子</option>
                        <option value='2' <?php echo isset($selBabySex[2]) ? $selBabySex[2] : '';?>>小公主</option>
                        <!--<option value='3' <?php echo isset($selBabySex[3]) ? $selBabySex[3] : '';?>>孕育中</option>-->
                    </select>
                </div>
            </li>
           
            
        </ul>
    </form>
</div>

<?php include "footer_web.php";?>

<script type="text/javascript">
    $(function(){
        var selectDate = new MobileSelectDate();
        selectDate.init({
            trigger:'#birth',
            value:'<?php echo str_replace('-', '/', $userInfo->birthday);?>',
            min:'1990/01/01',
            max:'<?php echo date('Y-m-d', time());?>',
            callback:function(obj){
                var _objBirth = $("#birth");
                _objBirth.val(_objBirth.val().replace(/\//g,"-"));
            }
        });

        var babySelDate = new MobileSelectDate();
        babySelDate.init({
            trigger:'#baby_birthday',
            value:'<?php echo str_replace('-', '/', $userInfo->birthday);?>',
            min:'<?php echo date('Y/m/d', strtotime('-5 years'));?>',
            max:'<?php echo date('Y/m/d', strtotime('+1 year'));?>',
            callback:function(obj){
                var _objBirth = $("#baby_birthday");
                _objBirth.val(_objBirth.val().replace(/\//g,"-"));
            }
        });
    });

    function doSubmit(){
        if($("#name").val() == ""){
            alert("请填写昵称");
            return false;
        }

        var isBirth = true;
        var birth = $("#baby_birthday").val();
        console.log(birth)
        var arrBirth = birth.split("-");
        for(var i=0,_len=arrBirth.length; i<_len; i++){
            if(arrBirth[i] == ""){
                isBirth = false;
                break;
            }
        }
        if(!isBirth){
            alert("请正确选择出生日期");
            return false;
        }
    }

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


    $(function(){
        $(".user_edit_select").each(function(index, el) {
            var initValue = $(el).next().find("option:selected").html();
            $(el).html(initValue);
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
