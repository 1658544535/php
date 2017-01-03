<?php include_once('header_notice_web.php');?>
<script type="text/javascript" src="/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script type="text/javascript">
var imgUrl = "<?php echo $site;?>images/200.jpg";
var link = "<?php echo $site;?>pindeke.php?act=mission";
var title ="拼得好";
var desc = "1毛夺好礼，拼享新玩法";
wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
</script>
<style>
    .user-tab{
        position: absolute;
        width: 100%;
        top: 2.2rem;
        z-index: 11;
    }
    .user-tab:after{
        content: ' ';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 1px;
        background: #e7e7e7;
    }
    .user-tab ul li.double.active-type1:after{
        display: inline-block;
        vertical-align: top;
        width: 0.5rem;
        height: 100%;
        background: url(../images/active-down.png) no-repeat 0 center;
        background-size: 100% auto;
        content: ' ';
    }
    .user-tab ul li.double.active-type2:after{
        display: inline-block;
        vertical-align: top;
        width: 0.5rem;
        height: 100%;
        background: url(../images/active-up.png) no-repeat 0 center;
        background-size: 100% auto;
        content: ' ';
    }
    .user-tab ul li.active a{
        border-bottom: none;
    }
    .index-seckill .list-container{
        margin-top: 2px;
    }
    .popup-class .main{
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background: #fff;
    }
    .popup-class .main .title1{
        margin: 0;
        height: 2.0rem;
        line-height: 2.0rem;
        font-size: .75rem;
        color: #818181;
        font-weight: 400;
        text-indent: 1.0rem;
        background: #e9e9e9;
    }
    .popup-class .main .info{
        margin: 1.5rem 1rem;
        overflow: hidden;
    }
    .popup-class .main .info .item{
        float: left;
        width: 30%;
        margin: 0 1.5%;
    }
    .popup-class .main .info .item input{
        display: block;
        width: 100%;
        height: 1.7rem;
        line-height: 1.8rem;
        border: 1px solid #c8c8c8;
        border-radius: 5px;
        text-align: center;
    }
    .popup-class .main .btn{
        overflow: hidden;
    }
    .popup-class .main .btn a{
        float: left;
        width: 50%;
        height: 2.25rem;
        line-height: 2.25rem;
        font-size: .8rem;
        color: #fff;
        text-align: center;
        background: #ff464e;
    }
    .popup-class .main .btn a.gray{
        background: #979797;
    }
</style>

<body>
    <div class="page-group" id="page-taskList">
        <div id="page-nav-bar" class="page page-current">
            <script>
                // var classJson = <?php echo json_encode($classOne);?>;
                // console.log(classJson);
            </script>
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <a class="button button-link button-nav pull-right search">搜索</a>
                <div class="bar-search">
                    <div class="txt"><input id="search" type="text" name="name" value="" placeholder="搜索商品" /></div>
                </div>
            </header>
            <!-- <section class="user-tab user-tab3">
                <ul>
                    <li class="double" data-type1="2" data-type2="3"><a href="javascript:;">销量</a></li>
                    <li class="double" data-type1="2" data-type2="3"><a href="javascript:;">价格</a></li>
                    <li class="out"><a href="javascript:;">筛选</a></li>
                </ul>
            </section> -->

            <div class="content native-scroll">

                <section class="index-seckill pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="ajaxtpl/ajax_pdk_mission.php">
                    <ul class="list-container"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                </section>
            </div>
        
            <script id='tpl_pull' type="text/template">
                <%if(data.length>0){%>
                    <%for(var i=0;i<data.length; i++){%>
                       <li>
                         <a href="groupon.php?id=<%=data[i]["activityId"]%>">
                           <div class="img"><img src="<%=data[i]["productImage"]%>" /></div>
                            <div class="info">
                                <div class="name"><span class="num"><%=data[i]["groupNum"]%>人团</span><%=data[i]["productName"]%></div>
                                <div class="price">
                                    <div class="price1">赚: ￥<%=data[i]["rebatePrice"]%></div>
                                    <span class="price3">￥<%=data[i]["productPrice"]%></span>
                                </div>
                                <div class="btn">
                                    <span class="red">领取任务</span>
                                </div>
                            </div>
                        </a></li>
                    <%}%>
                <%}else if(pageNow == 1){%>
                    <div class="pdk-list-null">暂无商品</div>
                <%}%>
            </script>
        
        </div>
        <div class="popup popup-class">
            <div class="main">
                <h3 class="title1">分类</h3>
                <div class="info">
                    <div class="item"><input id="class1" type="text" placeholder="一级分类" /></div>
                    <div class="item"><input id="class2" type="text" placeholder="二级分类" /></div>
                    <div class="item"><input id="class3" type="text" placeholder="三级分类" /></div>
                </div>
                <div class="btn">
                    <a class="gray close-popup" href="javascript:;">取消</a>
                    <a href="javascript:;">确定</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>