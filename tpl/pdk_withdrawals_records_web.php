<?php include_once('header_web.php');?>
<?php include_once('wxshare_web.php');?>

<body>
    <div class="page-group" id="page-pdk-record">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="pindeke.php?act=withdrawals&uid=<?php echo $userid;?>">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">提现记录列表</h1>
            </header>

            <div class="content native-scroll">
                <section class="pdkRecord-search">
                    <ul>
                        <li>
                            <div class="label">按时间搜索：</div>
                            <div class="main">
                                <input id="startTime" name="startTime" type="text" rel="req" placeholder="设置开始时间" />
                                <input id="endTime" name="endTime" type="text" rel="req" placeholder="设置结束时间" />
                            </div>
                        </li>
                        <li>
                            <div class="label">审核状态：</div>
                            <div class="main">
                                <input id="type-value" name="status" rel="req" type="hidden" />
                                <input id="type" type="text" placeholder="选择审核状态" />
                            </div>
                        </li>
                    </ul>
                    <div class="btn"><input type="button" value="搜索" /></div>
                </section>

                <section class="pdkRecord-list pullbox infinite-scroll infinite-scroll-bottom" data-distance="30" data-href="ajaxtpl/ajax_pdk_withdrawals_records.php">
                    <h3 class="title1">共提现<span class="themeColor">￥<?php echo $Objrecord['result']['wdPrice'];?></span>元</h3>
                    <ul class="list-container list"></ul>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                </section>
                
            </div>
            <script id='tpl_pull' type="text/template">
                <%if(data["data"]["tranList"].length>0){%>
                    <%for(var i=0;i<data["data"]["tranList"].length; i++){%>
                        <li>
                          <a href="pindeke.php?act=withdrawals_record&id=<%=data["data"]["tranList"][i]["id"]%>">                            
                            <%if(data["data"]["tranList"][i]["status"] ==0 ){%>
                            <p class="type">提现(待审核)</p>
                            <%}else if(data["data"]["tranList"][i]["status"] ==3){%>
                            <p class="type">提现(转账完成)</p>
                            <%}else if(data["data"]["tranList"][i]["status"] ==1){%>
                            <p class="type">提现(审核通过)</p>
                            <%}else if(data["data"]["tranList"][i]["status"] ==2){%>
                            <p class="type">提现(审核不通过)</p>
                            <%}%>
                            <p class="time"><%=data["data"]["tranList"][i]["date"]%></p>
                            <p class="price">-<%=data["data"]["tranList"][i]["price"]%></p>
                          </a>
                        </li>
                    <%}%>
                <%}else if(data["pageNow"] == 1){%>
                    <div class="tips-null">暂无记录</div>
                <%}%>
            </script>

            <script>
                var searchReq = {};
                $(document).on("pageInit", "#page-pdk-record", function(e, pageId, page) {
                    $("#startTime").datetimePicker({});
                    $("#endTime").datetimePicker({});
                    $("#type").picker({
                        cols: [{
                          textAlign: 'center',
                          displayValues: ['全部', '待审核', '审核通过','转账完成'],
                          values: ['', 0,1,3]
                        }],
                        formatValue: function(picker, values, displayValues){
                            $("#type-value").val(values);
                            return displayValues;
                        }
                    });

                });
            </script>
        </div>
    </div>
</body>

</html>
