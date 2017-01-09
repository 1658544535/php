<?php include_once('header_web.php');?>
<?php include_once('wxshare_web.php');?>

<body>
	<style type="text/css">
		.redImg{
			display: block;
			width: 100%;
		}
	</style>
    <div class="page-group">
        <div id="page-nav-bar" class="page page-current">
            <div class="content">
                <img class="redImg" src="<?php echo $red['url'];?>" />
                <input type="hidden" name="noGoIndex" value="1">
            </div>
        </div>
    </div>
</body>

</html>
