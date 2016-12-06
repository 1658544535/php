<?php
define('HN1', true);
require_once('./global.php');

IS_USER_LOGIN();
$hongbao = apiData('gainCouponApi.do', array('userId'=>$userid));

if(!empty($hongbao['success'])){
	redirect('user_info.php?act=coupon', $hongbao['error_msg']);
}else{
	redirect('index.php', $hongbao['error_msg']);
}


?>