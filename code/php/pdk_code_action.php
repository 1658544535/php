<?php
define('HN1', true);
require_once('./global.php');
IS_USER_LOGIN();
    $minfo  = CheckDatas( 'minfo', '' );
	$pdkcode = apiData('activeFreeCoupon.do',array('code'=>VOLO8O,'userId'=>$userid),'get',true);
    if($pdkcode['success']){
	    redirect('groupon_free.php',领取成功！);
    }else{
    	redirect('index.php',您已经领取过，请不要重复领取！);
    }
?>