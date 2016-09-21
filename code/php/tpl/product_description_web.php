<!-- 图文详情 -->
<?php if($version ==1){?>
<?php echo $url3;?>
<?php }else{?>
<?php
	if ( $imageList != null ){
		foreach($imageList as $image){ ?>
			<img src="<?php echo $site_image?>product/<?php echo $image->images;?>" />
<?php 	}
	}
?>
<?php }?>


