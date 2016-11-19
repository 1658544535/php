<?php include_once('header_notice_web.php');?>
<link rel="stylesheet" href="css/sm-extend.min.css">
<script type='text/javascript' src='js/sui/sm-extend.min.js' charset='utf-8'></script>

<body>
    <div class="page-group" id="page-evaluate">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="lottery_new.php?type=2">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">评价列表</h1>
            </header>

            <div class="content native-scroll">
                <section class="evaluate-pro">
                    <div class="img"><img src="<?php echo $LotteryCommentList['productImage'];?>" /></div>
                    <div class="name"><?php echo $LotteryCommentList['productName'];?></div>
                </section>

                <section class="evaluate-list pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="ajaxtpl/ajax_lottery_comment.php?aid=<?php echo $aId;?>">
                    <ul class="list-container"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                </section>
            </div>
        
            <script id='tpl_pull' type="text/template">
                <%if(data["data"].length>0){%>
                    <%for(var i=0;i<data["data"].length; i++){%>
                        <li>
                            <div class="header">
                                <div class="img">
                                  <%if(data["data"][i]["userImage"] !=''){%> 
                                    <img src="<%=data["data"][i]["userImage"]%>" />
                                  <%}else{%>
                                    <img src="/images/def_user.png" />
                                  <%}%>
                                </div>
                                <div class="info">
                                    <div class="name"><%=data["data"][i]["userName"]%></div>
                                    <div class="time"><%=data["data"][i]["commentTime"]%></div>
                                </div>
                            </div>
                            <div class="txt"><%=data["data"][i]["commentText"]%></div>
                           <%if(data["data"][i]["commentImage"]["image"] !=''){%>
                            <div class="imgs">
                                <%for(var j=0;j<data["data"][i]["commentImage"].length; j++){%>
                                <div><img src="<%=data["data"][i]["commentImage"][j]["image"]%>" /></div>
                                <%}%>
                            </div>
                           <%}%> 
                       </li>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="tips-null">暂无评价</div>
                <%}%>
            </script>

        </div>

    </div>
</body>

</html>
