<?php include_once('header_web.php');?>
<?php include_once('wxshare_web.php');?>

<body>
    <div class="page-group" id="page-pdk-record">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">我的钱包</h1>
            </header>

            <div class="content native-scroll">
                <section class="wallet-header">
                    <div>剩余金额(元)</div>
                    <?php if($walletInfo['balance']){?>
                    <div class="price"><?php echo $walletInfo['balance'];?></div>
	                <?php }else{?>
	                <div class="price">0.0</div>
	                <?php }?>
                </section>

                <section class="pdkRecord-list pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="ajaxtpl/ajax_user_wallet.php">
                    <ul class="list-container list"></ul>
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
                            <p class="type"><%=data["data"][i]["digest"]%></p>
                            <p class="time"><%=data["data"][i]["addTime"]%></p>
                           <%if(data["data"][i]["type"] ==0){%>
                            <p class="price">+<%=data["data"][i]["receive"]%></p>
                           <%}else{%>
                            <p class="price">-<%=data["data"][i]["receive"]%></p>
                           <%}%>
                        </li>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="tips-null">暂无记录</div>
                <%}%>
            </script>

        </div>
    </div>
</body>

</html>