<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>淘竹马福利社</title>
    <link href="/css/common.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript" src="/js/wxshare.js"></script>
    <style type="text/css">
        img{display:block;}
        #bg,#bg2{display: none; position: fixed; top: 0%; left: 0%; width: 100%; height: 100%; background: url(images/guide_bg.png); z-index: 1001;}
    </style>
    <script language="javascript">
        wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', 'http://weixinm2c.taozhuma.com/images/wxshareicon.jpg', '<?php echo $SHARP_URL;?>', '淘竹马福利社', '首单专享，满80送80' );
        function showDIv(){
            document.getElementById('bg').style.display = "block";
        }
        function hideDiv(){
            document.getElementById('bg').style.display = "none";
        }
        function showFriendDIv(){
            document.getElementById('bg2').style.display = "block";
        }
        function hideFriendDIv(){
            document.getElementById('bg2').style.display = "none";
        }
    </script>
</head>
<body>
    <div class="nr_warp">
        <div><img src="/images/active/sdzx/sdzx_01.png"></div>
        <div><img src="/images/active/sdzx/sdzx_02.png"></div>
        <div><img src="/images/active/sdzx/sdzx_03.png"></div>
        <div><img src="/images/active/sdzx/sdzx_04.png"></div>
        <div><img src="/images/active/sdzx/sdzx_05.png"></div>
        <div><img src="/images/active/sdzx/sdzx_06.png"></div>
        <div><img src="/images/active/sdzx/sdzx_07.png"></div>
        <div><img src="/images/active/sdzx/sdzx_08.png"></div>
        <div><img src="/images/active/sdzx/sdzx_09.png"></div>
        <div><img src="/images/active/sdzx/sdzx_10.png"></div>
        <div><img src="/images/active/sdzx/sdzx_11.png"></div>
        <div><img src="/images/active/sdzx/sdzx_12.png"></div>
        <div><img src="/images/active/sdzx/sdzx_13.png"></div>
        <div>
            <a href="javascript:;" onclick="showFriendDIv()">
                <img src="/images/active/sdzx/sdzx_14.png">
            </a>
        </div>
        <div><img src="/images/active/sdzx/sdzx_15.png"></div>
    </div>

    <div id="bg" onclick="hideDiv();">
        <img src="images/guide.png" style="position: fixed; top: 0; right: 16px;">
    </div>
    <div id="bg2" onclick="hideFriendDIv();" style="display: none;">
        <img src="images/wxshare.png" style="position: fixed; top: 0; right: 16px;">
    </div>

    <?php include "footer_web.php";?>
</body>
</html>
