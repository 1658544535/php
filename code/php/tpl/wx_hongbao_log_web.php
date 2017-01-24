<?php include_once('header_notice_web.php');?>
<body>
    <div class="page-group" id="page-record">
        <div id="page-nav-bar" class="page page-current">

            <div class="content record">
                <section class="header">
                    <img src="images/record/header.png" />
                    <p class="total">已有<span class="txt"><?php echo $showNum;?></span>人领取新春红包</p>
                </section>

                <section class="view">
                    <div class="top">
                        <div class="time">领取时间</div>
                        <div class="user">领取用户</div>
                        <div class="price">金额</div>
                    </div>
                    <div class="main">
                        <ul id="scroll">
                            <?php foreach ($list as $item){?>
                                <li>
                                    <div class="time"><?php echo $item['timestr'];?></div>
                                    <div class="user"><?php echo $item['name'];?></div>
                                    <div class="price">￥<?php echo $item['money'];?></div>
                                </li>
                            <?php }?>
                        </ul>
                    </div>
                </section>

                <section class="footer">本活动在法律范围内最终解释权归拼得好所有</section>
            </div>
            <script>
                $(document).on("pageInit", "#page-record", function(e, pageId, page){
                    var reHtml = $("#scroll").html();
                    $("#scroll").append(reHtml);
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
                })
            </script>

        </div>
    </div>
</body>

</html>
