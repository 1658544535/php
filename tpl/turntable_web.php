<?php include_once('header_web.php');?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script type="text/javascript">
    var imgUrl = "<?php echo $site;?>images/wxLOGO.png";
    var link = "<?php echo $wxShareInviteUrl;?>";
    var title ="元宵红包";
    var desc = "元宵红包抽奖";
    wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
</script>

<style type="text/css">
    body,.page-group,.page,.content{
        position: relative;
        height: auto;
        overflow: auto;
    }
    .popup{
        position: fixed;
    }
</style>

<body>
    <div class="page-group" id="page-a-lottery">
        <div id="page-nav-bar" class="page page-current">

            <div class="content native-scroll">
                <div class="a-lottery">

                    <div class="turntable">
                        <div style="height: 1px"></div>

                        <!-- <div class="places">
                            <div class="total"><div>目前还剩<span id="places"><?php echo $reWinnerNum;?></span>名额</div></div>
                            <div class="deta">200元还剩1名，100元还剩1名……</div>
                        </div> -->

                        <div class="turntable-main">
                            <div class="bg"></div>
                            <div class="pointer"></div>
                            <div class="adorn"></div>
                        </div>

                        <div class="chance"><?php if($isLogin){?>您还有 <span id="chance"><?php echo $chance;?></span> 次机会<?php }else{ ?><a href="/user_binding.php">请先进行登录</a><?php }?></div>

                        <?php if($isLogin){?>
                            <div class="button1">
                                <a href="/"><img src="images/lottery/btn2.png" alt="进入商城" /></a>
                                <a href="javascript:;" class="turntable-log"><img src="images/lottery/btn3.png" alt="参与记录" /></a>
                            </div>
                        <?php }?>

                    </div>

                    <div class="rule1">
                        <img src="images/lottery/rule1.jpg" />
                    </div>

                    <div class="list">
                        <div class="view">
                            <div class="top">
                                <div class="time">时间</div>
                                <div class="user">帐号</div>
                                <div class="price">奖品</div>
                            </div>
                            <div class="main">
                                <ul id="scroll"></ul>
                                <script type="text/template" id="tpl_list">
                                <%for(var i=0; i<data.length; i++){%>
                                    <li>
                                        <div class="time"><%=data[i]['time']%></div>
                                        <div class="user"><%=data[i]['mobile']%></div>
                                        <div class="price"><%=data[i]['prize']%></div>
                                    </li>
                                <%}%>
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="rule2">
                        <img src="images/lottery/rule2.jpg" />
                    </div>
                    <div style="clear: both;"></div>
                </div>

            </div>
        </div>

        <!-- 提醒登录 -->
        <div class="popup popup-turntable p-t-login">
            <div class="main">
                <a href="javascript:;" class="close-popup">关闭</a>
                <div class="txt tipLogin">抽奖前需要进行登录哦！</div>
                <div class="btn">
                    <a href="/user_binding.php" class="pink">前往登录</a>
                </div>
            </div>
        </div>

        <!-- 点击抽奖按钮后提示 -->
        <div class="popup popup-turntable p-t-again1">
            <div class="main">
                <a href="javascript:;" class="close-popup">关闭</a>
                <h3 class="title1">温馨提示</h3>
                <div class="txt">点击后将减少一次抽奖机会，是否继续？</div>
                <div class="btn">
                    <a href="javascript:;" class="pink turntable-again">继续</a>
                </div>
            </div>
        </div>

        <!-- 中奖, 继续抽奖 -->
        <div class="popup popup-turntable p-t-again2">
            <div class="main">
                <a href="javascript:;" class="close-popup">关闭</a>
                <div class="img"><img src="images/lottery/prize.png" /></div>
                <div class="txt"></div>
                <div class="btn">
                    <a href="javascript:;" class="turntable-log yellow">查看记录</a>
                    <a href="/index.php" class="pink">进入商城</a>
                    <a href="javascript:;" class="turntable-again green">继续抽奖</a>
                </div>
                <div class="tips">
                    <span class="titleColor">温馨提示：</span><br/>
                    1、红包会在第二次抽奖后一同发放<br/>
                    2、如何获得抽奖机会：进入商城，每个订单支付金额超过10元（含10元）并且拼团成功，即可获得多一次抽奖机会
                </div>
            </div>
        </div>

        <!-- 中奖, 无抽奖次数 -->
        <div class="popup popup-turntable p-t-null1">
            <div class="main">
                <a href="javascript:;" class="close-popup">关闭</a>
                <div class="img"><img src="images/lottery/prize.png" /></div>
                <div class="txt"></div>
                <div class="btn">
                    <a href="javascript:;" class="turntable-log yellow">查看记录</a>
                    <a href="/index.php" class="pink">进入商城</a>
                    <!--<a href="javascript:;" class="turntable-share green">邀请好友</a>-->
                </div>
                <div class="tips">
                    <span class="titleColor">温馨提示：</span><br/>
                    1、红包会在第二次抽奖后一同发放<br/>
                    2、如何获得抽奖机会：进入商城，每个订单支付金额超过10元（含10元）并且拼团成功，即可获得多一次抽奖机会
                </div>
            </div>
        </div>

        <!-- 无抽奖次数 -->
        <div class="popup popup-turntable p-t-null2">
            <div class="main">
                <a href="javascript:;" class="close-popup">关闭</a>
                <h3 class="title1" style="margin-top:-0.5rem;">温馨提示</h3>
                <div class="txt t-left titleColor">您的抽奖次数已用完，您可通过以下方式获得次数：</div>
                <div class="txt t-left">1: 每个订单支付金额超过<span class="themeColor">10元（含10元）</span>即可获得多一次抽奖机会</div>
                <!-- <div class="txt t-left">2: 每邀请<span class="themeColor">5个</span>新用户注册并参与，即可获得多一次抽奖机会</div> -->
                <div class="btn">
                    <!-- <a href="javascript:;" class="turntable-share yellow">邀请好友</a> -->
                    <a href="/index.php" class="pink">进入商城</a>
                </div>
            </div>
        </div>

        <!-- 活动已结束 -->
        <div class="popup popup-turntable p-t-over">
            <div class="main">
                <a href="javascript:;" class="close-popup">关闭</a>
                <div class="txt tipLogin">活动已结束 / 活动暂未开始</div>
                <div class="btn">
                    <a href="/index.php" class="pink">进入商城</a>
                </div>
            </div>
        </div>

        <div class="popup popup-share">
            <a href="javascript:;" class="close-popup"></a>
        </div>
        <script>
            $(document).on("pageInit", "#page-a-lottery", function(e, pageId, page) {
                var aid = '<?php echo $lotInfo['id'];?>';
                $(".turntable-main .pointer").on("click", function(){
                    <?php switch ($curLotStatus) {
                        case '100':
                            // 未登录
                            echo '$.popup(".p-t-login");';
                            break;
                        case '1':
                            // 没有信息
                            echo '$(".p-t-over .txt").html("活动已结束");$.popup(".p-t-over")';
                            break;
                        case '2':
                            // 未开始
                            echo '$(".p-t-over .txt").html("活动暂未开始");$.popup(".p-t-over")';
                            break;
                        case '3':
                            // 已结束
                            echo '$(".p-t-over .txt").html("活动已结束");$.popup(".p-t-over")';
                            break;
                        case '4':
                            // 单日参与数满
                            echo '$(".p-t-over .txt").html("单日参与数满");$.popup(".p-t-over")';
                            break;
                        default:
                            // 抽奖
                            echo 'if(parseInt($("#chance").text()) > 0){$.popup(".p-t-again1")}else{$.popup(".p-t-null2")}';
                            break;
                    }?>
                });

                $(".turntable-again").on("click", turntable_start);
                $(".turntable-log").on("click", function(){
                    location.href="/turntable.php?act=log";
                });
                $(".turntable-share").on("click", function(){
                    $.closeModal();
                    $.popup(".popup-share");
                });
                // 转盘
                function turntable_start(){
                    $.closeModal();
                    var chance = parseInt($("#chance").text()) - 1;
                    if(chance <= -1){
                        // 无抽奖次数
                        $.popup(".p-t-null2");
                        return false;
                    }
                    $.showIndicator();
                    $.ajax({
                        url: '/turntable.php?act=lottery',
                        dataType: 'json',
                        success: function(res){
                            switch (res.status) {
                                case 0:
                                    // 未登录
                                    $.popup(".p-t-login");
                                    break;
                                case 1:
                                    // 中奖
                                    var angle = parseInt(res.data.angle);     // 最终角度
                                    var o_angle = $(".turntable-main .bg").data("angle");
                                    if(!!o_angle){                  // 旋转圈数
                                        var angle = angle + 360*(parseInt(o_angle/360)+3);
                                    }else{
                                        angle += 360*3;
                                    }
                                    var angle_css = 'rotate(-'+ angle +'deg)';
                                    jQuery(".turntable-main .bg").css({
                                        "transform": angle_css,
                                        "-webkit-transform": angle_css
                                    }).attr({"data-angle": angle});
                                    setTimeout(function(){
                                        sendRed(res.data.id, res.info);
                                    }, 2000);
                                    break;
                                case 2:
                                    // 无抽奖次数
                                    $.popup(".p-t-null2");
                                    $("#chance").html(0);
                                    break;
                                case 3:
                                case 4:
                                case 5:
                                    // 活动暂未开始
                                    // 活动已结束
                                    // 今日名额已完
                                    $(".p-t-over .txt").html(res.info);
                                    $.popup(".p-t-over");
                                    break;
                            }
                        },
                        error: function(){
                            $.toast('请求失败');
                        },
                        complete: function(){
                            $.hideIndicator();
                        }
                    });
                }

                // 发红包
                function sendRed(_id, _title){
                    var chance = parseInt($("#chance").text()) - 1,
                        places = parseInt($("#places").text()) - 1;
                    $(".p-t-null1 .img img,.p-t-again2 .img img").attr("src", setPrizeImg(_id));
                    $(".p-t-null1 .txt,.p-t-again2 .txt").html('恭喜您获得 <span class="prizeTxt">' + _title + '</span>');
                    if(chance == 0){
                        // 中奖, 无抽奖次数
                        $.popup(".p-t-null1");
                        $("#chance").html(0);
                        $("#places").html(places);
                    }else if(chance >= 1){
                        // 中奖, 继续抽奖
                        $.popup(".p-t-again2");
                        $("#chance").html(chance);
                        $("#places").html(places);
                    }
                    $.ajax({
                        url: '/turntable.php?act=send&id='+aid,
                        error: function(){
                            $.toast('领取失败');
                        }
                    });
                }

                // 中奖图片
                function setPrizeImg(_id){
                    var src = 'images/lottery/prize/';
                    switch (_id) {
                        case '1':
                            src += '1.png';
                            break;
                        case '2':
                            src += '2.png';
                            break;
                        case '3':
                            src += '3.png';
                            break;
                        case '4':
                            src += '5.png';
                            break;
                        case '5':
                            src += '20.png';
                            break;
                        case '6':
                            src += '50.png';
                            break;
                        case '7':
                            src += '100.png';
                            break;
                        case '8':
                            src += '200.png';
                            break;
                        default:
                            src += '1.png';
                            break;
                    }
                    return src;
                }

                // 获奖列表
                $.ajax({
                    url: '/turntable.php?act=list',
                    dataType: 'json',
                    success: function(res){
                        var bt = baidu.template;
                        baidu.template.ESCAPE = false;
                        var html=bt('tpl_list', {data: res});
                        html += html;
                        $("#scroll").html(html);
                        var mainHei = parseFloat($("#scroll").height())/2;
                        function rep(){
                            var _top = parseFloat($("#scroll").css("top"))-20;

                            jQuery("#scroll").animate({
                                top: _top
                            }, 1000, 'linear', function(){
                                if(_top <= -mainHei){
                                    $("#scroll").css({top: 0});
                                }
                                rep();
                            });
                        }
                        rep();
                    }
                });
            })
        </script>
    </div>
</body>

</html>
