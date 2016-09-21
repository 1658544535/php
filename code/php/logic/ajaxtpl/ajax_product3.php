<?php

define('HN1', true);
require_once('../global.php');

define('SCRIPT_ROOT',  dirname(__FILE__).'/');


	//设置只能用微信窗口打开
require_once SCRIPT_ROOT.'../logic/productBean.php';

$type = $_REQUEST['category_id'] = null ? '0' : intval($_REQUEST['category_id']);
$page = $_REQUEST['page'] = null ? '0' : intval($_REQUEST['page']);

$ib = new productBean();


$productList = $ib->searchs($db,$page,10,$type,$userid);
?>
<div class="product_02">
        <ul>
<?php foreach($productList['DataSet'] as $product){ ?>
 	<li><div class="product_02-Pic"><a href="product_detail?product_id=<?php echo $product->id;?>">
        	<div  style="width:154px;height:154px;overflow:hidden;"><img src="<?php echo $site_image?>/product/small/<?php echo $product->image;?>" alt="" width="154px" height="154px" class="product_02-Pic-color02"/></div></a>
        	<div class="product_02-Pic-txt"><a href="product_detail?product_id=<?php echo $product->id;?>">
        	<span style="font-size:14px;color:#404040;"><?php echo mb_substr($product->product_name , 0 , 20 ,'utf-8');?></span>
        	</a></div></div></li>
<?php } ?>
        </ul>
    </div>