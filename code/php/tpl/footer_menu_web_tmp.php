<?php if( isset($showDownBar) && $showDownBar ){ ?>
<div id="btm-downbar">
	<div id="downbar-close"></div>
	<a href="http://dwz.cn/tzm1314">
		<img src="/images/downbar.png" />
	</a>
</div>
<?php } ?>

<div style="width:100%;height:45px;"></div>
<div class="menu-foot2">
<?php $urlname = $_SERVER['PHP_SELF']; ?>
<?php $arr = explode( '/' , $urlname );?>
<?php  $filename= $arr[count($arr)-1];?>
	<div class="menu-foot-button">
		<a href="index" class="menu-foot-index <?php if($filename=="index.php" || $filename=="index" ){echo "active";}?>"></a>
	</div>

    <!-- <div class="menu-foot-button">
    	<a href="scene.php" class="menu-foot-scene <?php if($filename=="class.php" || $filename=="class"){echo "active";}?>"></a>
    </div> -->

    <div class="menu-foot-button">
    	<a href="cart?return_url=<?php echo $_SERVER['REQUEST_URI']; ?>" class="menu-foot-cart <?php if($filename=="cart.php" || $filename=="cart"){echo "active";}?>">
    		<div id="menu-cart-tip">0</div>
    	</a>
    </div>

    <div class="menu-foot-button">
    	<a href="user?return_url=<?php echo $_SERVER['REQUEST_URI']; ?>" class="menu-foot-user <?php if($filename=="user.php" || $filename=="user"){echo "active";}?>">
    </div>
</div>
<script language="javascript">
$(function(){
	gShowCartNum();

	if($("#downbar-close")[0]){
		$("#downbar-close").on("click", function(){
			$("#btm-downbar").hide();
		});
	}
});
function gShowCartNum(){
	$.get("/tool.php", {"t":"cartnum"}, function(r){
		if(r.n > 0) {
			if (parseInt(r.n) >= 100) r.n = "...";
			$("#menu-cart-tip").text(r.n).show();
		}
	}, "json");
}
</script>
