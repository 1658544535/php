<?php
define('HN1', true);
require_once('../global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开
require_once SCRIPT_ROOT.'../admin/logic/productBean.php';

$category_id = $_REQUEST['category_id'] = null ? '0' : intval($_REQUEST['category_id']);
$page = $_REQUEST['page'] = null ? '0' : intval($_REQUEST['page']);

$ib = new productBean();

$product_addList = $ib->search_list($db,$page,10,$category_id);
?>
<div class="product_02">
        <ul>
<?php foreach($product_addList['DataSet'] as $product){ ?>
        	<li><div class="product_02-Pic"><a href="product_detail.php?product_id=<?php echo $product->product_id;?>"><div  style="width:305px;height:305px;overflow:hidden;"><img src="product/small/<?php echo $product->image;?>" alt="" width="305px" height="305px" class="product_02-Pic-color02"/></div></a><div class="product_02-Pic-txt"><a href="product_detail.php?product_id=<?php echo $product->product_id;?>"><span style="font-size:28px;color:#404040;"><?php echo $product->name;?></span><p class="product_02-Pic-txt02">价格￥<?php echo number_format($product->price,2);?><?php echo $product->brand;?></p></a></div></div></li>
<?php } ?>
        </ul>
    </div>