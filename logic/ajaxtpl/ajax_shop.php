<?php

define('HN1', true);
require_once('../global.php');

define('SCRIPT_ROOT',  dirname(__FILE__).'/');


	//设置只能用微信窗口打开
require_once SCRIPT_ROOT.'../logic/user_shopBean.php';

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

	 ?>
 	<li><div class="product_02-Pic"><a href="shop_detail?id=<?php echo $product->id;?>">
       <div  style="width:154px;height:154px;overflow:hidden;"><img src="<?php echo $site_image?>shop/<?php echo $product->images;?>" alt="" width="154px" height="154px" class="product_02-Pic-color02"/></div></a>	<div class="product_02-Pic-txt"><a href="shop_detail?id=<?php echo $product->id;?>">
        <span style="font-size:14px;color:#404040;">店铺名：<?php echo $product->name;?></span></br>
        	<span style="font-size:14px;color:#404040;">主打：<?php echo $main_category;?></span>
        	</a></div></div></li>
<?php } ?>
        </ul>
    </div>