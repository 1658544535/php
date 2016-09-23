<?php
define('HN1', true);
require_once('./global.php');

$activeId = intval($_GET['id']);
empty($activeId) && redirect('/');

$objGroupon = M('groupon_activity');
$groupon = $objGroupon->get(array('id'=>$activeId,'status'=>1,'is_delete'=>0), '*', ARRAY_A);
empty($groupon) && redirect('/', '没有相关的活动');
($groupon['type'] == 3) && redirect('/');//猜价则跳出

//对应商品有多种拼团则跳转到选择拼团页面
$count = $objGroupon->getCount(array('product_id'=>$groupon['product_id'],'type'=>1,'status'=>1,'is_delete'=>0,'__NOTIN__'=>array('id'=>array($activeId))));
if($count > 1){
	redirect('groupon_multi.php?id='.$groupon['product_id']);
	exit();
}
echo '这是详情衣';

switch($groupon['type']){
	case 1://普通拼团
		//对应
		break;
	case 2://团免
		break;
	case 3://猜价
		redirect('/');
		break;
}
?>