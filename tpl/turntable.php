<?php include_once('header_web.php');?>
<?php include_once('wxshare_web.php');?>

<style type="text/css">
    
</style>

<body>
    <div class="page-group" id="page-lottery">
        <div id="page-nav-bar" class="page page-current">

            <div class="content native-scroll">
                <div class="a-lottery">

                    <div class="turntable">
                        <div style="height: 1px"></div>

                        <div class="places">
                            <div class="total"><div>目前还剩<span>1</span>名额</div></div>
                            <div class="deta">200元还剩1名，100元还剩1名……</div>
                        </div>

                        <div class="turntable-main">
                            <div class="bg"></div>
                            <div class="pointer"></div>
                            <div class="adorn"></div>
                        </div>

                        <div class="chance">您还有 0 次机会</div>

                        <div class="button1">
                            <a href="#"><img src="images/lottery/btn2.png" alt="进入商城" /></a>
                            <a href="#"><img src="images/lottery/btn3.png" alt="参与记录" /></a>
                        </div>

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
                </div>

            </div>
        </div>
        <script>
            $(document).on("pageInit", "#page-lottery", function(e, pageId, page) {
                // 没有登录
                <?php if(!$isLogin){?>
                    $.alert('抽奖前需要进行登录哦！', function(){
                        location.href="/user_binding.php";
                    })
                <?php }?>

                $(".turntable-main .pointer").on("click", turntable_start);
                // 转盘
                function turntable_start(){
                    $.showIndicator();
                    $.ajax({
                        url: '/turntable.php?act=lottery',
                        data: {},
                        dataType: 'json',
                        success: function(res){
                            switch (res.status) {
                                case 1:                             // 成功
                                    var angle = res.data.angle;     // 最终角度
                                    angle += 360*2;                 // 旋转圈数
                                    var angle_css = 'rotate('+ angle +'deg)';
                                    jQuery(".turntable-main .bg").css({
                                        "transform": angle_css,
                                        "-webkit-transform": angle_css
                                    })
                                    setTimeout(sendRed, 2000);
                                    break;
                                default:
                                    $.toast(res.info);
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
                function sendRed(){
                    $.showIndicator();
                    $.ajax({
                        url: '/turntable.php?act=send&id=1',
                        dataType: 'json',
                        success: function(res){

                        },
                        error: function(){
                            $.toast('领取失败');
                        },
                        complete: function(){
                            $.hideIndicator();
                        }
                    });
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
                            var _top = parseFloat($("#scroll").css("top"))-10;

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
