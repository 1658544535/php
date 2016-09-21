<?php

define('HN1', true);
require_once('../global.php');

//设置只能用微信窗口打开
require_once LOGIC_ROOT.'user_shopBean.php';

$type = $_REQUEST['type'] = null ? '0' : intval($_REQUEST['type']);
$key = $_REQUEST['key'] == null || $_REQUEST['key'] == '请输入关键字' ? '' : $_REQUEST['key'];
$page = $_REQUEST['page'] = null ? '0' : intval($_REQUEST['page']);

$ib = new user_shopBean();


$product_addList = $ib->searchs($db,$page,10,$type);
?>
<div class="product_02">
        <ul>
<?php foreach($product_addList['DataSet'] as $product){
$main_category=$db->get_var("select name from sys_dict where type ='main_category'and value='".$product->main_category."' ");
$city=$db->get_var("select name from sys_area  where id = '".$product->city."' ");
$address=$province.$city;
	 ?>
 	<li><div class="product_02-Pic"><a href="shop_detail?id=<?php echo $product->id;?>">
       <div  style="width:154px;height:154px;overflow:hidden;"><img src="<?php echo $site_image?>shop/<?php echo $product->images;?>" alt="" width="154px" height="154px" class="product_02-Pic-color02"/></div></a>	<div class="product_02-Pic-txt"><a href="shop_detail?id=<?php echo $product->id;?>">
        <span style="font-size:14px;color:#404040;text-align:center;"><?php echo $product->name;?></span></br>
        	<p class="product_02-Pic-txt02">主营：<?php echo $main_category;?></p>
        	<span style="font-size:12px;color:#404040;">所在区域：<?php echo $address;?></span>
        	</a></div></div></li>
<?php } ?>
        </ul>
    </div>