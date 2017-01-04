<?php
define('HN1', true);
require_once('../global.php');

$page           = max(1, intval($_POST['page']));

//获取钱包明细数据	
    $walletInfo = apiData('userWelletDetail.do', array('uid'=>$userid,'pageNo'=>$page));
    
    if($walletInfo['success'] !=''){
    	 echo ajaxJson( 1,'获取成功',$walletInfo['result']['detailList'],$page);
    }else{
    	echo ajaxJson( 0,$walletInfo['error_msg']);
    }


?>