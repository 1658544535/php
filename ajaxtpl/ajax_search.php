<?php
define('HN1', true);
require_once ('../global.php');


$name  = CheckDatas( 'name', '' );



	$search = apiData('searchAll.do', array('name'=>$name,'pageNo'=>$page,'sorting'=>1));
	
	if($search !='')
	{
		echo	ajaxJson( 1,'获取成功',$search['result']);
	}
	else
	{
		echo	ajaxJson( 0,'获取失败');
	
	}
?>