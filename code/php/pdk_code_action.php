<?php
define('HN1', true);
require_once('./global.php');

$minfo  = CheckDatas( 'minfo', '' );
    IS_USER_LOGIN();
	$pdkcode = apiData('activeFreeCoupon.do',array('code'=>$minfo,'userId'=>$userid));
    if($pdkcode['success']){
	    redirect('groupon_free.php',领取成功！);
    }else{
    	redirect('index.php',领取失败！);
    }
?>