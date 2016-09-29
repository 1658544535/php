<?php

define('HN1', true);
require_once('../global.php');


$page           = max(1, intval($_POST['page']));
$Type           = CheckDatas( 'type', '' );





$guess = apiData('myGuessListApi.do', array('userId'=>$userid,'type'=>$Type,'pageNo'=>$page));

if($guess !='')
{
     echo	ajaxJson( 1,'获取成功',$guess['result'],$page);
}
else
{
	echo	ajaxJson( 0,'获取失败');
}



?>