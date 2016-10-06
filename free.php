<?php
//团免券链接
define('HN1', true);
require_once('./global.php');

IS_USER_LOGIN();

$linkId = intval($_GET['id']);
empty($linkId) && redirect('/', '参数异常');

$info = apiData('getFreeCouponApi.do', array('linkId'=>$linkId,'userId'=>$userid));
if($info['success']){
	redirect('groupon_free.php', '团免券领取成功');
}else{
	redirect('/', $info['error_msg']);
}
?>