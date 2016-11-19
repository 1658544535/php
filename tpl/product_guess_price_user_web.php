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

             
                <section class="guessJoinList clickbox"  data-href="ajaxtpl/ajax_product_guess_price.php?act=user&gid=<?php echo $gId;?>">
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
            </script>
        </div>
    </div>
</body>

</html>
