<?php include_once('header_notice_web.php');?>

<body>
    <div class="page-group" id="page-lotteryresult">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">中奖结果</h1>
            </header>

            <div class="content native-scroll">

                <section class="lotteryresult-pro">
                    <div class="img"><img src="<?php echo $winInfo['productImage'];?>" /></div>
                    <div class="info">
                        <div class="name"><?php echo $winInfo['productName'];?></div>
                        <div class="price">￥<span><?php echo $winInfo['productPrice'];?></span></div>
                        <div class="btn">已开奖</div>
                    </div>
                </section>

                <section class="deta-group pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="ajaxtpl/ajax_lottery_win.php?attId=<?php echo $attId;?>&aid=<?php echo $aId;?>&type=<?php echo $Type ;?>">
                    <h3 class="title1">获奖用户列表</h3>
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
                      <%for(var j=0;j<data["data"][i]["groupList"].length; j++){%>
						<%if(data["data"][i]["groupList"][j]["isHead"] ==1){%>
							<li class="head">
								<div class="img">
                                    <%if(data["data"][i]["groupList"][j]["userlogo"] !=''){%>
                                     <img src="<%=data["data"][i]["groupList"][j]["userlogo"]%>" /><span class="head"></span>
                                    <%}else{%>
                                     <img src="/images/def_user.png" /><span class="head"></span>
                                    <%}%>                              
                                </div>
						<%}else{%>
							<li>
								<div class="img">
                                   <%if(data["data"][i]["groupList"][j]["userlogo"] !=''){%>
                                     <img src="<%=data["data"][i]["groupList"][j]["userlogo"]%>" />
                                   <%}else{%>
                                     <img src="/images/def_user.png" />                                  
                                   <%}%>
                                </div>
						<%}%>
                            <div class="info">
                                <div class="name"><%=data["data"][i]["groupList"][j]["name"]%></div>
                                <div class="time"><%=data["data"][i]["groupList"][j]["attendTime"]%></div>
                            </div>
                        </li>
                    <%}%>
                 <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="tips-null">暂无获奖信息</div>
                <%}%>
             
              <?php if($attId  !=''){?>
                <div class="bin-btn clickbtn">
                    <a href="lottery_new.php?act=winning&aid=<?php echo $winInfo['activityId'] ;?>&type=<?php echo $Type;?>">点击查看全部中奖信息</a>
                </div>
               <?php }?>
              </script>

        </div>
    </div>
</body>

</html>
