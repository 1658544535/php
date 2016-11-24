<?php
define('HN1', true);
require_once('./global.php');

$level = CheckDatas( 'level', '' );
$cId   = CheckDatas( 'id', '' );
$act   = CheckDatas( 'act', 'info' );
$page  = max(1, intval($_POST['page']));


switch($act)
{
	case 'twoClass'://获取二分类数据
		$classList = apiData('productCategoryApi.do');
		$classList = $classList['result'];
	
		foreach ($classList as $k=>$v){
				if(in_array($cId,$v)){
					$twoClass = $v;
				}
			  }
	
		include_once('tpl/class_good_web.php');
		break;
	case 'threeClass'://获取三级分类数据
		$classList = apiData('productCategoryApi.do');
		$classList = $classList['result'];
		
		foreach ($classList as $two){
			foreach ($two['twoLevelList'] as $k=>$v){
				if(in_array($cId,$v)){
					$threeClass = $v;
				}
			}
		}

		
		include_once('tpl/class_good_web.php');
		break;
		default:
			
			//获取搜索页面分类数据
			$oneClass = apiData('productCategoryApi.do');
			$oneClass = $oneClass['result'];
			
			
			$footerNavActive = 'search';
			include_once('tpl/search_class_web.php');
}


?>