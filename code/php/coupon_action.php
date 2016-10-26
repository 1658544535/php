<?php
define('HN1', true);
require_once('./global.php');
IS_USER_LOGIN();
    $linkid  = CheckDatas( 'linkid', '' );
    $Aid     = CheckDatas( 'aid', '' );
	$coupon = apiData('getCouponApi.do',array('linkId'=>$linkid,'userId'=>$userid));
   if($Aid !=''){
    if($coupon['success']){
	    redirect('groupon.php?id='.$Aid,领取成功！);
    }elseif($coupon['result'] ==0){
    	redirect('groupon.php?id='.$Aid,$coupon['error_msg']);
    }else{
    	redirect('index.php',$coupon['error_msg']);
    }
   }else{
   	if($coupon['success']){
   		redirect('index.php',领取成功！);
   	}else{
   		redirect('index.php',$coupon['error_msg']);
   	}
   }
?>