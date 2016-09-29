<?php
(!defined('ORDER_IN') || !ORDER_IN) && redirect('/');

////商品
//$objPro = D('Product');
//$product = $objPro->getInfo($productId);
//($product['stock'] == 0) && redirect($prevUrl, '库存不够');
//!isset($factOrderPrice) && $factOrderPrice = $product['order_price'];
//
////地址
//$UserAddressModel = D('UserAddress');
//$addressID = isset($_SESSION['order']['addressId']) ? $_SESSION['order']['addressId'] : '';
////获取运费
//if($addressID != ''){
//	$UserAddressInfo = $UserAddressModel->getUserAddressInfo($userid, $addressID);
//
//	if($UserAddressInfo != NULL){
//		// 如果是偏远地区，则算全部商品的总重
//		$espress_price = get_espress_price($UserAddressInfo->province, $product['weight']);
//	}
//}
////获取用户地址
//if($addressID == NULL){
//	// 如果没有选择用户地址，则选取默认的地址
//	$UserAddressInfo = $UserAddressModel->getUserAddressOne($userid);
//	if ( $UserAddressInfo != NULL )
//	{
//		$_SESSION['order']['addressId'] = $UserAddressInfo->id;
//	}
//}
//else
//{
//	$UserAddressInfo = $UserAddressModel->getUserAddressInfo($userid, $addressID);
//}



if(isset($_SESSION['order']['address'])){
	$address = $_SESSION['order']['address'];
}else{
	$address = apiData('defaultAddress.do', array('uid'=>$userid));
	$address = $address['success'] ? $address['result'] : array();
}

//地址是否可配送
$canDispatch = (!empty($address) && in_array($address['province'], $unSendProviceIds)) ? false : true;

$_SESSION['order']['productId'] = $productId;
$_SESSION['order']['addressId'] = $address['id'];

include_once('tpl/order_web.php');
?>