<?php

define('HN1', true);
require_once('../global.php');

$ProductRecommendModel     = M('product_recommend');
// $ProductModel              = M('product');

// 获取每日上新&销量排行数据
$page = $_REQUEST['page'] = null ? '0' : intval($_REQUEST['page']);
$type   = $_REQUEST['type'] == null ? '' : $_REQUEST['type'];

$objProduct = $ProductRecommendModel ->query("SELECT p2.`id`, p2.`status`, p2.`product_no`, p2.`product_name`,p2.`image`, p2.`product_sketch`,p2.`selling_price`,p2.`distribution_price`,p1.`type`,p1.`sorting` FROM product_recommend AS p1 LEFT JOIN product AS p2 on p2.`id` = p1.`product_id`   WHERE  p2.`status` = 1 and p1.`type`='".$type."'  ORDER BY p1.sorting DESC,p1.create_date DESC ",false, true, $page);

?>
             <?php foreach ($objProduct['DataSet'] as $pro) {
             if($pro->status !=0){
             	?>
        		<li>
                    <a href="product_detail?pid=<?php echo $pro->id;?>">
            			<div class="img"><img src="<?php echo $site_image?>product/<?php echo $pro->image ;?>" /></div>
            			<div class="info">
            				<div class="title"><?php echo $pro->product_name ;?></div>
            				<div class="tips"><?php echo $pro->product_sketch ;?></div>
            				<div class="oldPrice"><span>¥</span><?php echo $pro->selling_price;?></div>
            				<div class="price"><span>¥</span><?php echo $pro->distribution_price;?></div>
            			</div>
            		</a>
               </li>
            <?php }}?>
            <input type="hidden" name="recordCount" value="<?php echo $objProduct['PageCount']; ?>" />
           
