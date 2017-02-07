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

                <section class="user-collection pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="/turntable.php?act=ajax_log">
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
                        <span class="pull-right"><%=data["data"][i]["prize"]%></span>
                    </li>
                <%}%>
            <%}else if(data["pageNow"]==1){%>
                <div class="list-null">您的记录为空</div>
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