<?php include_once('header_notice_web.php');?>
<?php include_once('wxshare_web.php');?>

<body>
    <div class="page-group" id="page-collection">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">我的收藏</h1>
            </header>
            <div class="content native-scroll">

                <section class="user-collection pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="ajaxtpl/ajax_product_collect.php">
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
                        <a href="javascript:;" class="img"><img src="<%=data["data"][i]["productImage"]%>" /></a>
                        <div class="info">
                            <a href="groupon.php?id=<%=data["data"][i]["activityId"]%>" class="name"><%=data["data"][i]["productName"]%></a>
                            <div class="option">
                                <a href="groupon.php?id=<%=data["data"][i]["activityId"]%>" class="group">
                                    <%=data["data"][i]["groupNum"]%>人团&nbsp;&nbsp;<font class="themeColor">￥<span class="price"><%=data["data"][i]["productPrice"]%></span></font>
                                    <span class="btn">去开团&nbsp;&gt;</span>
                                </a>
                                <a href="javascript:;" class="collecting" data-actid="<%=data["data"][i]["activityId"]%>" data-pid="<%=data["data"][i]["productId"]%>"></a>
                            </div>
                        </div>
                    </li>
                <%}%>
            <%}else if(data["pageNow"]==1){%>
                <div class="tips-null">暂无收藏</div>
            <%}%>
            </script>

            <script>
                $(document).on("pageInit", "#page-collection", function(e, pageId, page) {
                    $(document).on("click", ".collecting" ,function(){
                        var actid = $(this).attr("data-actid"),
                        	pid = $(this).attr("data-pid");
                        $.showIndicator();
                        $.ajax({
                            url: 'api_action.php?act=uncollect',
                            type: 'POST',
                            dataType: 'json',
                            data: {"id":actid,"pid":pid},
                            success: function(res){
                                location.href=document.location;
                            }
                        });
                    });
                });
            </script>

        </div>
    </div>
</body>

</html>
