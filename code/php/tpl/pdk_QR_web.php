<?php include_once('header_web.php');?>
<?php include_once('wxshare_web.php');?>

<body>
    <div class="page-group" id="page-ranking">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="user.php">
                    <span class="icon icon-back"></span>
                </a>
                <a class="button button-link button-nav pull-right share">
                    <span class="icon icon-share"></span>
                </a>
                <h1 class="title">我的二维码</h1>
            </header>

            <div class="content native-scroll ranking">
                <section class="code">
                    <div class="txt">用户通过扫面您的二维码，注册并成为拼得客，即可与您绑定关系</div>
                    <img class="img" src="<?php echo $imgPath;?>" />
                </section>
                <section class="rule">
                    <h3 class="title1">奖励规则：</h3>
                    <ul>
                        <li>通过扫描您的二维码注册并成为拼得客的用户，自注册之日起30日内（次数仅限1次），该拼得客销售额总数超过以下条件的，您会获得相应的奖励，该奖励会在5个工作日内同步到您的钱包中。
                        </li>
                    </ul>
                    <div>销售金额满<span class="themeColor">9000元</span>，奖励<span class="themeColor">450元</span></div>
                    <div>销售金额满<span class="themeColor">5000元</span>，奖励<span class="themeColor">300元</span></div>
                    <div>销售金额满<span class="themeColor">3000元</span>，奖励<span class="themeColor">100元</span></div>
                    <div>销售金额满<span class="themeColor">1000元</span>，奖励<span class="themeColor">50元</span></div>
                </section>
            </div>
        </div>
        <div class="popup popup-share">
            <a href="javascript:;" class="close-popup"></a>
        </div>
        <script>
                $(".share").on("click", function(){
                    $.popup(".popup-share");
                })
        </script>
    </div>
</body>

</html>
