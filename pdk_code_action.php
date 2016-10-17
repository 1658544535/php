<?php
define('HN1', true);
require_once('./global.php');

$minfo  = CheckDatas( 'minfo', '' );
$info = apiData('userlogin.do',array('openid'=>$openid,'source'=>3));
if($info['result'] ==''){
	redirect('user_binding.php',您还没登陆，请先登录);
}else{
	$pdkcode = apiData('activeFreeCoupon.do',array('code'=>$minfo,'userId'=>$userid));
	redirect('groupon_free.php',领取成功！);
}





?>