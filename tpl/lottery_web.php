<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <title><?php echo $site_name;?></title>
    <link href="/css/common.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .webpage{display:block; width:100%; background-image:url("/images/lottery/turntable/ly-rotate-stati2.png"); background-size:100% 100%; text-align:center;}
        .webpage .pbg-bg{width:100%;}
        .webpage .subject{text-align:center; padding-top:20px;}
        .webpage .subject .subimg{width:60%;}
        .ly-plate{display:block; width:100%;}
        .ly-plate .rotate-bg{display:block; width:100%; position:relative; background-image:url("/images/lottery/turntable/ly-plate.png"); background-size:100% 100%;}
        .ly-plate .rotate-bg .ly-plate-bg{width:100%;}
        .ly-plate .rotate-bg .lottery-star{position:absolute; width:44%; height:44%; top:28.3%; left:28.3%;}
        .webpage .btntip{font-size:16px; padding:20px 0;}
    </style>
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript" src="/js/wxshare.js"></script>
    <script language="javascript">
        var wxcbs = {
            "shareAppMessage": {
                "success": "doShare"
            },
            "shareTimeline": {
                "success": "doShare"
            }
        };
        wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>', wxcbs);
    </script>
</head>

<body>
    <div class="list-nav">
        <a href="<?php echo $_GET['return_url'] ?>" class="back"></a>
        <div class="member-nav-M">转盘抽奖</div>
    </div>

    <div class="webpage">
        <div class="subject"><img class="subimg" src="/images/lottery/turntable/ly-rotate-static1.png" /></div>
        <div class="ly-plate">
            <div class="rotate-bg">
                <canvas class="ly-plate-bg" width="480px" height="480px"></canvas>
                <img src="/images/lottery/turntable/ly-rotate-static.png" id="lotteryBtn" class="lottery-star">
            </div>
        </div>

        <div class="btntip">
            <p>2015&nbsp;&nbsp;粤ICP备13081564号&nbsp;&nbsp;<a href="http://mp.weixin.qq.com/s?__biz=MzA3NDAxOTk0Mw==&mid=214550738&idx=1&sn=3777dc409c19099a25b9a7dc0be9eb24#rd" style="color:#df434e;">关注淘竹马</a></p>
            <p>全国免费专线：400-150-1677</p>
        </div>
    </div>

    </br>
    </br>
    </br>

    <?php include "footer_menu_web_tmp.php"; ?>

    <script type="text/javascript" src="js/jQueryRotate.2.2.js"></script>
    <script type="text/javascript" src="js/jquery.easing.min.js"></script>
    <script language="javascript">
        $(function(){
            $("#lotteryBtn").bind("click", function(){
                <?php if(!$lotInfo){ ?>
                    alert("活动已停止");
                <?php }elseif(!$lotInfo->status){ ?>
                    alert("活动没有开始");
                <?php }elseif($lotInfo->start_time > $curTime){ ?>
                    alert("活动尚未开始");
                <?php }elseif($lotInfo->end_time < $curTime){ ?>
                    alert("活动已经结束");
                <?php }elseif(empty($user)){ ?>
                    alert("请先登录");
                    location.href = "/login?dir=lottery.php";
                <?php }elseif(empty($user->openid)){ ?>
                    alert("请先关注");
                <?php }elseif(!$canLot){ ?>
                    alert("今天的抽奖机会已用完");
                <?php }else{ ?>
                    lottery();
                <?php } ?>
            });
        });

        function doShare(){
            $.post("/lottery.php?act=2");
            alert("分享了");
        }

        <?php if(!empty($user->openid)){ ?>
        function lottery(){
            var startBtn = $("#lotteryBtn");
            startBtn.rotate({
                angle: 0,
                duration:3000,
                animateTo:3600,
                easing: $.easing.easeOutSine
            });
            $.ajax({
                type: 'POST',
                url: '/lottery.php?act=1',
                dataType: 'json',
                cache: false,
                data: {},
                error: function(){
                    alert("出错了");
                    startBtn.stopRotate();
                    return false;
                },
                success:function(json){
                    if(json.state == "1"){
                        var a = json.data.pos; //角度
                        var p = json.data.prize; //奖项
                        startBtn.rotate({
                            duration:3000, //转动时间
                            animateTo:3600+a, //转动角度
                            easing: $.easing.easeOutSine,
                            callback: function(){
                                if($.inArray(json.data.ptype, [0,1]) > -1) p = "恭喜获取"+p;
                                alert(p);
                                startBtn.stopRotate();
                            }
                        });
                    }else{
                        alert(json.msg);
                        startBtn.stopRotate();
                    }
                }
            });
        }
        <?php } ?>
    </script>
</body>
</html>