<?php include_once('header_web.php');?>
<?php include_once('wxshare_web.php');?>

<body>
    <div class="page-group" id="page-ranking">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="user.php">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title">排行榜</h1>
            </header>

            <div class="content native-scroll ranking">
                <section class="date">
                    <input type="text" id="date" value="<?php echo $year;?>年 <?php echo $month;?>月" />
                </section>
                <section class="list">
                    <h3 class="title1">我的排名: <span class="themeColor"><?php echo $rankList['result']['myRanking'];?></span></h3>
                    <table>
	                        <tr>
	                            <th width="70">排名</th>
	                            <th width="65">头像</th>
	                            <th>昵称</th>
	                            <th width="120">目前销售额</th>
	                        </tr>
                        <?php foreach ($rankList['result']['list'] as $list){?>
	                        <tr>
	                            <td class="serial">
                                    <?php if($list['ranking'] ==1){?>
                                        <img width="28" src="images/ranking/01.png" alt="<?php echo $list['ranking'];?>" />
                                    <?php }elseif($list['ranking'] ==2){?>
                                        <img width="28" src="images/ranking/02.png" alt="<?php echo $list['ranking'];?>" />
                                    <?php }elseif($list['ranking'] ==3){?>
                                        <img width="28" src="images/ranking/03.png" alt="<?php echo $list['ranking'];?>" />
                                    <?php }else{echo $list['ranking'];}?>
                                </td>
	                            <td><img class="img" src="<?php echo $list['userLogo'];?>" /></td>
	                            <td><?php echo $list['userName'];?></td>
	                            <td>￥ <?php echo $list['price'];?></td>
	                        </tr>
                        <?php }?>
                    </table>
                </section>
                <seciotn class="reward">
                    <h3 class="title1">奖励金额</h3>
                    <p><img width="22" src="images/ranking/01.png" />第一名：奖励现金<span class="themeColor">￥1000.0</span></p>
                    <p><img width="22" src="images/ranking/02.png" />第二名：奖励现金<span class="themeColor">￥500.0</span></p>
                    <p><img width="22" src="images/ranking/03.png" />第三名：奖励现金<span class="themeColor">￥300.0</span></p>
                </seciotn>
                <section class="rule">
                    <h3 class="title1">排名&奖励说明</h3>
                    <ul>
                        <li>排名按自然月销售金额进行排名</li>
                        <li>自然月销售金额超过3000元即可进入排行榜</li>
                        <li>进入排行榜销售金额前三的拼得客将获得对应榜单奖励</li>
                        <li>奖励现金将于次月5个工作日内转入相应上榜拼得客钱包内</li>
                        <li>当天销售额会在第二天进行更新</li>
                    </ul>
                    <div class="themeColor">在法律法规允许范围内，拼得好商城拥有对该活动的最终解释权</div>
                </section>
            </div>
        </div>
        <script>
            $(document).on("pageInit", "#page-ranking", function(e, pageId, page) {
                var yearNow = new Date().getFullYear(),
                    yearArr = [];
                for(var year = 1900; year<=yearNow; year++){
                    yearArr.unshift(year + '年');
                };
                $("#date").picker({
                  toolbarTemplate: '<header class="bar bar-nav">\
                  <button class="button button-link pull-right close-picker">确定</button>\
                  <h1 class="title">请选择日期</h1>\
                  </header>',
                  cols: [{
                      textAlign: 'center',
                      values: yearArr
                    },{
                      textAlign: 'center',
                      values: ['01月', '02月', '03月', '04月', '05月', '06月', '07月', '08月', '09月', '10月', '11月', '12月']
                    }],
                    onClose: function(e){
                        var y = e.value[0],
                            m = e.value[1];
                        y = y.split('年')[0];
                        m = m.split('月')[0];
                        location.href="pindeke.php?act=ranking&y=" + y + "&m=" + m; 
                    }
                });
            })
        </script>
    </div>
</body>

</html>
