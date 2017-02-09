<?php include_once('header_notice_web.php');?>
<?php include_once('wxshare_web.php');?>

<body>
    <div class="page-group" id="page-turntableLog">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">参与记录</h1>
            </header>
            <div class="content native-scroll">

                <section class="turntable-log pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="/turntable.php?act=ajax_log">
                    <div class="tips">温馨提示：红包会以两次为一个发放周期，抽奖两次即会马上发送，即刻到账</div>
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
                        <span><%=data["data"][i]["time"]%></span>
                        <span class="center"><%=data["data"][i]["prize"]%></span>
                        <span class="right"><%=data["data"][i]["status"]%></span>
                    </li>
                <%}%>
            <%}else if(data["pageNow"]==1){%>
                <div style="margin-top: 20%" class="list-null">您的记录为空</div>
            <%}%>
            </script>

            <script>
                $(document).on("pageInit", "#page-turntableLog", function(e, pageId, page) {
                    fn_pull(page);
                });
            </script>

        </div>
    </div>
</body>

</html>
