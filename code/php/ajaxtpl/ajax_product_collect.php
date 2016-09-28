<?php
define('HN1', true);
require_once('../global.php');


$page           = max(1, intval($_POST['page']));

$favorites = apiData('myCollectListApi.do', array('userId'=>$userid,'pageNo'=>$page));

if($favorites !='')
{
	echo	ajaxJson( 1,'获取成功',$favorites['result']);
}
else
{
	echo	ajaxJson( 0,'获取失败');

}



?>