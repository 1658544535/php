<?php

define('HN1', true);
require_once('../global.php');


//设置只能用微信窗口打开
require_once LOGIC_ROOT.'productBean.php';

$type = $_REQUEST['category_id'] = null ? '0' : intval($_REQUEST['category_id']);
$page = $_REQUEST['page'] = null ? '0' : intval($_REQUEST['page']);

$ib = new productBean();


$productList = $ib->searchs($db,$page,20,$type,$userid);
?>
<div class="product_02">
        <ul>
<?php foreach($productList['DataSet'] as $product){ ?>
 	<li><div class="product_02-Pic"><a href="product_detail?product_id=<?php echo $product->id;?>">
        	<div  style="width:154px;height:154px;overflow:hidden;"><img src="<?php echo $site_image?>/product/small/<?php echo $product->image;?>" alt="" width="154px" height="154px" class="product_02-Pic-color02"/></div></a>
        	<div class="product_02-Pic-txt"><a href="product_detail?product_id=<?php echo $product->id;?>">
        	<span class="product_title" style="font-size:12px;color:#404040;"><?php
$v=&$product->product_name;  //以$v代表‘长描述’
mb_internal_encoding('utf8');//以utf8编码的页面为例
if(mb_strlen($v)>10) //如果内容多余10字
    echo mb_substr($v,0,10).'...'; //限制10个字的输出，加上省略号
else //如果不够100字
    echo $v;
?></span>
        	<p class="product_02-Pic-txt02">价格￥<?php echo $product->distribution_price;?></p>
        	</a></div></div></li>
<?php } ?>
        </ul>
    </div>