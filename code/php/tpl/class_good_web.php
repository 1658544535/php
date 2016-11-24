<?php include_once('header_notice_web.php');?>
<?php include_once('wxshare_web.php');?>

<body>
    <div class="page-group" id="page-classGood">
        <div id="page-nav-bar" class="page page-current">
        
        	<header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="index.php">
                    <span class="icon icon-back"></span>
                </a>
                <?php if($level ==3){?>
                <h1 class="title"><?php echo $threeClass['twoName'];?></h1>
                <?php }else{?>
                <h1 class="title"><?php echo $twoClass['oneName'];?></h1>
                <?php }?>
            </header>
            <?php if($level ==3){?>
            <section class="user-tab class-nav" data-href="ajaxtpl/ajax_product.php?level=<?php echo $level;?>&id=<?php echo $cId;?>" style="margin-top:2.0rem">
                <div class="show-down"></div>
                <ul class="show">
                    <li data-type="<?php echo $cId;?>" class="active"><a>全部</a></li>
                    <?php foreach ($threeClass['threeLevelList'] as $three){?>
                    <li data-type="<?php echo $three['threeId'];?>"><a><?php echo $three['threeName'];?></a></li>
                    <?php }?>
                </ul>
            </section>
            <?php }else{?>
            <section class="user-tab class-nav" data-href="ajaxtpl/ajax_product.php?level=<?php echo $level;?>&id=<?php echo $cId;?>">
                <div class="show-down"></div>
                <ul class="show">
                    <li data-type="<?php echo $cId;?>" class="active"><a>全部</a></li>
                    <?php foreach ($twoClass['twoLevelList'] as $two){?>
                    <li data-type="<?php echo $two['twoId'];?>"><a><?php echo $two['twoName'];?></a></li>
                    <?php }?>
                </ul>
            </section>
            <?php }?>
            <div class="content native-scroll" style="top: 4.0rem;">

                <section class="index-pro clickbox infinite-scroll infinite-scroll-bottom">
                    <ul class="list-container"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                </section>

            </div>

            <script id='tpl_pull_tab' type="text/template">
                <%if(data["data"].length>0){%>
                    <%for(var i=0;i<data["data"].length; i++){%>
                        <li><a href="groupon.php?id=<%=data["data"][i]["activityId"]%>">
                            <div class="img"><img src="<%=data["data"][i]["productImage"]%>" /></div>
                            <div class="name">
                                <span class="num"><%=data["data"][i]["groupNum"]%>人团</span><%=data["data"][i]["productName"]%>
                            </div>
                            <div class="info">
                                ￥<span class="price"><%=data["data"][i]["productPrice"]%></span>
                                <span class="sales">已团<%=data["data"][i]["proSellrNum"]%>件</span>
                            </div>
                        </a></li>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <li class="tips-null">暂无产品</li>
                <%}%>
            </script>

        </div>
    </div>
</body>

</html>
