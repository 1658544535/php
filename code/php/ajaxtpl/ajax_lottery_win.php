<?php
define('HN1', true);
require_once('../global.php');

$attId  	    = CheckDatas( 'attId', '' );
$page           = max(1, intval($_POST['page']));



//获取中奖用户列表数据
$winList = apiData('prizeDetail.do', array('attendId'=>$attId,'pageNo'=>$page));
if(!empty($winList['result']))
{
	echo	ajaxJson( 1,'获取成功',$winList['result']['prizelist'],$page);
}
else
{
	echo	ajaxJson( 0,'获取失败');
}






?>