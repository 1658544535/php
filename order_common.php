<?php
(!defined('ORDER_IN') || !ORDER_IN) && redirect('/');

if(isset($_SESSION['order']['address'])){
	$address = $_SESSION['order']['address'];
	$addrId = $address['id'];
}else{
	$address = apiData('defaultAddress.do', array('uid'=>$userid));
	$address = $address['success'] ? $address['result'] : array();
    if(empty($address)){//如果没有默认地址，则取第一个
        $addressList = apiData('myaddress.do', array('uid'=>$userid,'pageNo'=>1));
        $addressList = $addressList['result'];
        $address = array_shift($addressList);
    }
	$addrId = $address['addId'];
}

//地址是否可配送
$canDispatch = (!empty($address) && in_array($address['province'], $unSendProviceIds)) ? false : true;

$_SESSION['order']['productId'] = $productId;
$_SESSION['order']['addressId'] = $addrId;

//优惠券
$cpns = apiData('getValidUserCoupon.do', array('pid'=>$productId,'price'=>$info['sumPrice'],'uid'=>$userid));
$cpns = $cpns['success'] ? $cpns['result'] : array();

include_once('tpl/order_web.php');
?>