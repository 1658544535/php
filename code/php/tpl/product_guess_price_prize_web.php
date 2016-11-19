<?php include_once('header_notice_web.php');?>
<?php include_once('wxshare_web.php');?>

<body>
    <div class="page-group" id="page-guessJoinList">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">参与用户列表</h1>
            </header>
            <?php include_once('footer_nav_web.php');?>

      

            <div class="content native-scroll">

                <div class="freeList-tips">共有<span class="themeColor"><?php echo $num['result']['joinNum'];?>位</span>用户参与此活动</div>

                <div class="guessTab" data-href="ajaxtpl/ajax_product_guess_price.php?act=prize&gid=<?php echo $gId;?>">
                    <ul>
                        <li data-tip="以下用户赢得奖品" data-type="1">一等奖</li>
                        <li data-tip="以下用户获得抵扣券" data-type="2">二等奖</li>
                        <li data-tip="以下用户获得抵扣券" data-type="3">三等奖</li>
                    </ul>
                </div>

                <section class="guessJoinList clickbox" >
                    <ul class="list-container"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                    <div class="bin-btn clickbtn">
                        <input type="button" value="更多">
                    </div>
                </section>

            </div>

            <script id='tpl_click' type="text/template">
                <%if(data["data"].length>0){%>
                    <%for(var i=0;i<data["data"].length; i++){%>
                        <li><a href="javascript:;">
                            <div class="img">
                               <%if(data["data"][i]["userImage"] !=''){%>
                                 <img src="<%=data["data"][i]["userImage"]%>" />
                               <%}else{%>
                                 <img src="/images/def_user.png" />
                               <%}%>
                            </div>
                            <div class="info">
                                <div class="name"><%=data["data"][i]["userName"]%></div>
                                <div class="price"><p>出价</p><p class="themeColor">￥<span class="real"><%=data["data"][i]["userPrice"]%></span></p></div>
                                <div class="time"><%=data["data"][i]["joinTime"]%></div>
                            </div>
                        </a></li>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="tips-null">暂无获奖用户</div>
                <%}%>
            </script>
        </div>
    </div>
</body>

</html>
