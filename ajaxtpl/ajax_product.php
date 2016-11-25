<?php
define('HN1', true);
require_once('../global.php');
$level = CheckDatas( 'level', '' );
$cid   = CheckDatas( 'type', '' );

$act   = CheckDatas( 'act', 'info' );
$page  = max(1, intval($_POST['page']));


$productlist = apiData('findProductListApi.do', array('id'=>$cid,'pageNo'=>$page,'level'=>$level));
		 

if($productlist['success'])
{
	echo	ajaxJson( 1,'获取成功',$productlist['result'],$page);
}
else
{
	echo	ajaxJson( 0,'获取失败');

}

?>
