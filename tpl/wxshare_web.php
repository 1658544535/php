<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>
<script type="text/javascript">
var imgUrl = "<?php echo $site;?>images/wxLOGO.png";
var link = "<?php echo $_wxShareDef['link'] ? $wxShareParam['link'] : $site;?>";
var title ="<?php echo $site_name;?>";
var desc = "拼得精彩";
wxshare(false, '<?php echo $wxShareParam['appId'];?>', <?php echo $wxShareParam['timestamp'];?>, '<?php echo $wxShareParam['nonceStr'];?>', '<?php echo $wxShareParam['signature'];?>', imgUrl, link, title, desc);
</script>