<?php
define('HN1', true);
require_once('./global.php');

/*----------------------------------------------------------------------------------------------------
	-- 配置
-----------------------------------------------------------------------------------------------------*/
$SceneModel = D('Scene');
$act = CheckDatas( 'act', 'lists' );

switch ( $act )
{
	case 'info':
		/*----------------------------------------------------------------------------------------------------
			-- 获取场景详情
		-----------------------------------------------------------------------------------------------------*/
		$nSceneID 		= CheckDatas( 'sid', 0 );

		if ( (int)$nSceneID == 0 )
		{
			redirect('/scene.php');
		}

		// 获取该场景的信息
		$objSceneInfo = $SceneModel->getSceneInfo( $nSceneID );

		$SceneIntroduction = str_replace( "/upfiles", "http://b2c.taozhuma.com/upfiles", $objSceneInfo->introduction);													// 图片显示地址

		if ( $objSceneInfo == NULL )
		{
			redirect('/scene.php');
		}

		// 获取该场景的产品信息
		$objSceneProduct = $SceneModel->getSceneProductData( $nSceneID );

		include_once('tpl/scene_detail_web.php');
	break;

	default:
		/*----------------------------------------------------------------------------------------------------
			-- 获取场景列表
		-----------------------------------------------------------------------------------------------------*/
		$objScene = $SceneModel->getSceneList4Filter();
		include_once('tpl/scene_web.php');

}


?>