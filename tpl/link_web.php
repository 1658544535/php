<?php include_once('header_notice_web.php');?>
<script type="text/javascript" src="/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script type="text/javascript">
var imgUrl = "<?php echo $site;?>images/hongbao.jpg";
var link = "<?php echo $site;?>link.php?url=<?php echo $url;?>&title=<?php echo $title;?>";
var title = '【拼得好】恭贺新春！';
var desc = '春节不打烊，福利不停歇！';
wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
</script>
<body>
    <div class="page-group" id="page-taskList">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a href="index.php" class="button button-link button-nav pull-left">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title"><?php echo $title;?></h1>
            </header>

            <div class="content native-scroll">
                <iframe src="<?php echo $url;?>" frameborder="0" width="100%" height="100%"></iframe>
                <input type="hidden" name="noGoIndex" value="1" />
            </div>
        
        </div>
    </div>
</body>

</html>